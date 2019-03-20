<?php

namespace Modules\Platform\Companies\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Platform\Companies\Repositories\CompanyPlansRepository;
use Modules\Platform\Companies\Service\PlanService;
use Modules\Platform\Core\Http\Controllers\AppBaseController;
use Modules\Platform\User\Http\Requests\SetupPermissionsRequest;
use Modules\Platform\User\Repositories\RoleRepository;

/**
 * Class CompanyPlanPermissionsController
 * @package Modules\Platform\User\Http\Controllers\Roles
 */
class CompanyPlansPermissionsController extends AppBaseController
{

    /**
     * @var CompanyPlansRepository
     */
    private $planRepo;

    /**
     * @var RoleRepository
     */
    private $roleRepo;

    private $planService;

    /**
     * CompanyPlanPermissionsController constructor.
     * @param CompanyPlansRepository $planRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(CompanyPlansRepository $planRepository, RoleRepository $roleRepository, PlanService $planService)
    {
        parent::__construct();

        $this->planRepo = $planRepository;

        $this->roleRepo = $roleRepository;

        $this->planService = $planService;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function setup($id)
    {
        $disabledGroups = [
            //'settings'
        ];
        $disabledPermissions = [];

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Load permissions from config files
        $this->roleRepo->synchModulePermissions(true);

        $view = view('companies::plan_permissions');

        $plan = $this->planRepo->find($id);

        if (empty($plan)) {
            flash(trans('core::core.general_exception'))->error();
            return redirect(route('settings.companies.index'));
        }

        if(!\Auth::user()->hasPermissionTo('settings.access')){
            $this->respondWith(\Redirect::to(route('settings.companies.index')));
        }

        $view->with('plan', $plan);
        $view->with('disabledGroups',$disabledGroups);
        $view->with('disabledPermissions',$disabledPermissions);
        $view->with('permissions', $this->roleRepo->getGroupedAllPermissions());
        $view->with('planPermissions', $plan->permissions()->pluck('name')->toArray());

        return $view;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save($id, Request $request)
    {
        if (config('bap.demo')) {
            flash(trans('core::core.you_cant_do_that_its_demo'))->error();
            return redirect()->back();
        }

        $plan = $this->planRepo->find($id);

        if (empty($plan)) {
            flash(trans('core::core.general_exception'))->error();
            return redirect(route('settings.companies.index'));
        }

        if(!\Auth::user()->hasPermissionTo('settings.access')){
            $this->respondWith(\Redirect::to(route('settings.companies.index')));
        }

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        if ($request->get('permissions') != null) {
            $plan->syncPermissions($request->get('permissions'));
        } else {
            $plan->syncPermissions([]);
        }

        $this->planService->syncPermissions($plan);

        flash(trans('companies::companyPlans.permissions_updated'))->success();

        return redirect()->route('settings.company-plans.permissions', $id);
    }
}
