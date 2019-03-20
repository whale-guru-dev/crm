<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 08.09.18
 * Time: 18:38
 */

namespace Modules\Api\Service\Saas;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Platform\Companies\Entities\Company;
use Modules\Platform\Companies\Entities\CompanyPlan;
use Modules\Platform\Companies\Repositories\CompanyRepository;
use Modules\Platform\Core\Helper\StringHelper;
use Modules\Platform\Core\Helper\ValidationHelper;
use Modules\Platform\User\Entities\Role;
use Modules\Platform\User\Entities\User;
use Modules\Platform\User\Repositories\UserRepository;
use Spatie\Permission\PermissionRegistrar;

class SaasService
{

    private $companyRepo;

    private $userRepo;

    public function __construct(CompanyRepository $companyRepository, UserRepository $userRepository)
    {
        $this->companyRepo = $companyRepository;
        $this->userRepo = $userRepository;
    }

    /**
     * Deactivate company
     *
     * @param $companyId
     * @return null
     */
    public function deactivateCompany($companyId)
    {

        $company = $this->companyRepo->findWithoutFail($companyId);

        if (!empty($company)) {

            $company->is_enabled = false;

            $company->save();

            $users = $this->userRepo->findWhere(['company_id' => $company->id]);

            foreach ($users as $u) {
                $u->is_active = false;
                $u->save();
            }

            return $company;
        }


        return null;
    }

    /**
     * Deactivate company
     *
     * @param $companyId
     * @return null
     */
    public function activateCompany($companyId)
    {

        $company = $this->companyRepo->findWithoutFail($companyId);

        if (!empty($company)) {

            $company->is_enabled = true;
            $company->save();

            $users = $this->userRepo->findWhere(['company_id' => $company->id]);

            foreach ($users as $u) {
                $u->is_active = true;
                $u->save();
            }

            return $company;
        }


        return null;
    }

    private function updateUser($data)
    {

        $userRepo = App::make(UserRepository::class);

        $entity = $userRepo->findWithoutFail($data['id']);

        if ($entity->company_id != $data['company_id']) {
            return [
                'status' => 'error',
                'code' => 'invalid_user',
                'message' => 'This user is not assigned to this company'
            ];
        }

        if (!empty($entity)) {
            $entity->first_name = $data['first_name'];
            $entity->is_active = $data['is_active'];
            $entity->email = $data['email'];

            if (!empty($data['password'])) {
                $entity->password = bcrypt($data['password']);
            }

            $entity->save();

            return [
                'status' => 'success',
                'code' => 'user_updated',
                'message' => 'User has been updated',
                'uid' => $entity->id
            ];

        } else {
            return [
                'status' => 'error',
                'code' => 'invalid_user',
                'message' => 'This user don\'t exist'
            ];
        }

    }

    private function createUser($data)
    {
        $userRepo = App::make(UserRepository::class);

        $entity = $userRepo->create([
            'first_name' => $data['first_name'],
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
            'company_id' => $data['company_id']
        ]);


        if (!empty($entity)) {

            $userRole = Role::where('name', 'user')->where('company_id', $data['company_id'])->first();

            $entity->syncRoles($userRole->id);

            return [
                'status' => 'success',
                'code' => 'user_created',
                'message' => 'User has been created',
                'uid' => $entity->id
            ];
        }


    }

    /**
     * Save or Update User
     *
     * @param $data
     * @return array
     */
    public function saveOrUpdateUser($data)
    {


        if (isset($data['id']) && $data['id'] > 0) {

            $rules = array('email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users')->ignore($data['id'])->where(function ($query) {
                    $query->whereNull('deleted_at');
                })
            ],);

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'code' => 'email_already_taken',
                    'message' => 'Cant change to this email. This email is already taken'
                ];
            }

            return $this->updateUser($data);

        } else {

            $rules = array('email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })
            ],);

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'code' => 'user_already_taken',
                    'message' => 'This email is already taken'
                ];
            }

            return $this->createUser($data);
        }
    }

    /**
     * Delete user
     * @param $data
     * @return array
     */
    public function deleteUser($data)
    {

        $userRepo = App::make(UserRepository::class);

        $entity = $userRepo->findWithoutFail($data['id']);

        if (empty($entity) || (!empty($entity) && $data['company_id'] != $entity->company_id)) {

            return [
                'status' => 'error',
                'code' => 'invalid_user',
                'message' => 'This user dont exist'
            ];

        }

        $validator = ValidationHelper::validateForeignKeys($entity);

        if (count($validator) > 0) {

            return [
                'status' => 'error',
                'code' => 'cant_delete_this_user',
                'message' => StringHelper::validationArrayToString($validator)
            ];

        }

        $userRepo->delete($entity->id);
        return [
            'status' => 'success',
            'code' => 'user_deleted',
            'message' => "User deleted"
        ];
    }

    /**
     * Register new company
     *
     * @param $companyName
     * @param $userFirstName
     * @param $userEmail
     * @param $userPassword
     * @param $userLimit
     * @return array|null
     */
    public function register($companyName, $userFirstName, $userEmail, $userPassword, $userLimit, $storageLimit,$apiPlan = null )
    {

        $company = new Company();
        $company->name = $companyName;
        $company->is_enabled = true;

        if (!empty($userLimit)) {
            $company->user_limit = $userLimit;
        }
        if (!empty($storageLimit)) {
            $company->storage_limit = $storageLimit;
        }

        if(!empty($apiPlan) && config('bap.enable_plans')){
            $plan = CompanyPlan::where('api_name',$apiPlan)->first();
            if(!empty($plan)){
                $company->plan()->associate($plan);
            }
        }

        $company->save();

        if ($company) {

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            $user = new User();
            $user->first_name = $userFirstName;
            $user->email = $userEmail;
            $user->password = Hash::make($userPassword);
            $user->company()->associate($company);

            $user->save();

            $role = Role::where('company_id', $company->id)->where('name', config('api.saas.defaultRole'))->first();

            $user->roles()->attach($role);
            $user->save();

            return [
                'company' => $company,
                'user' => $user
            ];
        }

        return null;
    }


    /**
     * Update Company Plan
     *
     * @param $userLimit
     * @param $storageLimit
     * @param $companyId
     * @param null $apiPlan
     * @return null
     */
    public function updateCompanyPlan($userLimit, $storageLimit, $companyId,$apiPlan = null )
    {

        $company = $this->companyRepo->findWithoutFail($companyId);

        if (!empty($company)) {

            if (!empty($userLimit)) {
                $company->user_limit = $userLimit;
            } else {
                $company->user_limit = null;
            }

            if (!empty($storageLimit)) {
                $company->storage_limit = $storageLimit;
            } else {
                $company->storage_limit = null;
            }

            if(!empty($apiPlan) && config('bap.enable_plans')){
                $plan = CompanyPlan::where('api_name',$apiPlan)->first();
                if(!empty($plan)){
                    $company->plan()->associate($plan);
                }
            }


            $company->save();

            return $company;
        }


        return null;
    }

    public function validateSecret($secret)
    {

        $fromConfig = config('app.bap_saas_secret');

        if ($secret != $fromConfig) {
            return [
                'status' => 'error',
                'message' => 'Invalid secret'
            ];
        } else {
            return [
                'status' => 'success',
                'message' => 'All Good!'
            ];
        }

    }


    public function mainAccountIsFree($email)
    {

        $user = $this->userRepo->findWhere([
            'email' => $email
        ])->first();

        if (!empty($user)) {
            return false;
        }
        return true;
    }

    public function companyNameIsFree($companyName)
    {

        $company = $this->companyRepo->findWhere([
            'name' => strtolower($companyName)
        ])->first();

        if (!empty($company)) {
            return false;
        }
        return true;

    }

}