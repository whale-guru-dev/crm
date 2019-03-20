<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 08.09.18
 * Time: 18:14
 */

namespace Modules\Api\Http\Controllers\Saas;


use Illuminate\Http\Request;
use Modules\Api\Http\Controllers\Base\SaasApiBaseController;
use Modules\Api\Http\Requests\Saas\ActivateCompanyRequest;
use Modules\Api\Http\Requests\Saas\DeactivateCompanyRequest;
use Modules\Api\Http\Requests\Saas\RegisterCompanyRequest;
use Modules\Api\Http\Requests\Saas\UpdateCompanyPlanRequest;
use Modules\Api\Service\Saas\SaasService;

class SaasApiController extends SaasApiBaseController
{

    public function __construct(SaasService $service)
    {
        parent::__construct($service);
    }

    public function deleteUser(Request $request){

        $this->validateSecret($request);

        $data = [
            'id' => $request->get('id'),
            'company_id' => $request->get('company_id')
        ];

        $result = $this->service->deleteUser($data);

        if($result['status'] == 'success'){
            return $this->respondWithSuccess('User deleted',[
               'status' => $result['code'],
               'code' => $result['code'],
               'message' => $result['message']
            ]);
        }else{
            return $this->respondWithError('Cant delete user',[
                'status' => $result['code'],
                'code' => $result['code'],
                'message' => $result['message']
            ]);
        }
    }

    /**
     * Save or Update
     * @param Request $request
     */
    public function saveOrUpdateUser(Request $request){

        $this->validateSecret($request);

        $result = $this->service->saveOrUpdateUser($request->only('id', 'first_name', 'email', 'password', 'is_active','company_id'));

        if($result['status'] == 'success'){
            return $this->respondWithSuccess('User saved',[
                'status' => $result['code'],
                'code' => $result['code'],
                'message' => $result['message'],
                'uid' => isset($result['uid']) ? $result['uid'] : null
            ]);
        }else{
            return $this->respondWithError('Cant save user',[
                'status' => $result['code'],
                'code' => $result['code'],
                'message' => $result['message']
            ]);
        }
    }

    public function validateAccount(Request $request){

        $this->validateSecret($request);

        if(!$this->service->mainAccountIsFree($request->get('user_email'))){
            $this->respondWithError('This e-mail is already registered');
        }

        $this->respondWithSuccess('Valid',[
            'company' => $request->get('company_name'),
            'user_email' => $request->get('user_email')
        ]);
    }

    /**
     * Register company (W)
     *
     * @param RegisterCompanyRequest $request
     */
    public function registerCompany(RegisterCompanyRequest $request)
    {

        $this->validateSecret($request);

        $companyName = $request->get('company_name');
        $userFirstName = $request->get('user_first_name');
        $userEmail     = $request->get('user_email');
        $userPassword  = $request->get('user_password');
        $userLimit      = $request->get('user_limit');
        $storageLimit = $request->get('storage_limit');
        $api_plan         = $request->get('api_plan');

        if(!$this->service->mainAccountIsFree($request->get('user_email'))){
            $this->respondWithError('This e-mail is already registered');
        }

        $result = $this->service->register($companyName,$userFirstName,$userEmail,$userPassword,$userLimit,$storageLimit,$api_plan);

        if(!empty($result)){
            $this->respondWithSuccess('Company Registered',[
                'company' => $result['company'],
                'user' => $result['user']
            ]);
        }

        $this->respondWithError('Whoops! Something went terrible wrong! Please contact Us');
    }


    /**
     * Update Plan (W)
     *
     * @param UpdateCompanyPlanRequest $request
     */
    public function updatePlan(UpdateCompanyPlanRequest $request){

        $this->validateSecret($request);

        $companyId = $request->get('company_id');
        $usersLimit = $request->get('users_limit');
        $storageLimit = $request->get('storage_limit');
        $apiPlan      = $request->get('api_plan');

        $result = $this->service->updateCompanyPlan($usersLimit,$storageLimit,$companyId,$apiPlan);

        if(!empty($result)){
            $this->respondWithSuccess('Account Updated');
        }

        $this->respondWithError('Whoops! Something went terrible wrong! Please contact Us');

    }

    public function deactivateAccount(DeactivateCompanyRequest $request){

        $this->validateSecret($request);

        $companyId = $request->get('company_id');

        $result = $this->service->deactivateCompany($companyId);

        if(!empty($result)){
            $this->respondWithSuccess('Account Deactivated');
        }

        $this->respondWithError('Whoops! Something went terrible wrong! Please contact Us');
    }

    public function resumeAccount(ActivateCompanyRequest $request){

        $this->validateSecret($request);

        $companyId = $request->get('company_id');

        $result = $this->service->activateCompany($companyId);

        if(!empty($result)){
            $this->respondWithSuccess('Account Activated');
        }

        $this->respondWithError('Whoops! Something went terrible wrong! Please contact Us');
    }

}