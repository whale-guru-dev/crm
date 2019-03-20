<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 03.03.19
 * Time: 19:34
 */

namespace Modules\Platform\Companies\Service;


use Modules\Platform\Companies\Entities\Company;
use Modules\Platform\Companies\Entities\CompanyPlan;
use Modules\Platform\Companies\Repositories\CompanyRepository;
use Modules\Platform\User\Entities\Role;
use Spatie\Permission\PermissionRegistrar;

class PlanService
{

    private $companyRepo;

    public function __construct(CompanyRepository $repository)
    {
        $this->companyRepo = $repository;
    }


    public function syncPermissions(CompanyPlan $companyPlan,Company $company = null ){

        //loop each company with this plan and attach detach permissions
        if(!empty($company)){
            $companies = collect($company);
        }else{
            $companies = $this->companyRepo->getCompaniesWithPlan($companyPlan);
        }

        $planPermissions = $companyPlan->permissions()->pluck('id');

        foreach ($companies as $company){

            // loop each role for company and check if there is permission that needs to be removed
            $roles = Role::where('company_id',$company->id)->get();

            foreach ($roles as $role){

                $permissionsToRemove = $role->permissions()->pluck('id')->diff($planPermissions);

                $role->permissions()->detach($permissionsToRemove);

            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

    }

}