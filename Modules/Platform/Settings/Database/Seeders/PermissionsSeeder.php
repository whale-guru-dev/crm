<?php

namespace Modules\Platform\Settings\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Modules\Platform\Companies\Entities\Company;
use Modules\Platform\Core\Helper\CrudHelper;
use Modules\Platform\Core\Helper\SeederHelper;
use Modules\Platform\User\Entities\Role;
use Modules\Platform\User\Repositories\RoleRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

/**
 * Class SettingsSeeder
 */
class PermissionsSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {
        $roles = [
            ['display_name' => 'Company Admin', 'name' => 'company_manager', 'guard_name' => 'web', 'company_id' => $companyId],
            ['display_name' => 'User', 'name' => 'user', 'guard_name' => 'web', 'company_id' => $companyId],
        ];

        DB::table('roles')->insert(CrudHelper::setDatesInArray($roles));

        $this->addCompanyManagerPermissions($companyId);
        $this->addUserRolePermissions($companyId);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear();

        $this->addAdminPermissions();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }

    private function clear()
    {
        \Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
    }

    /**
     * Admin permissions
     */
    private function addAdminPermissions()
    {

        $roles = [['id' => '1', 'display_name' => 'Admin', 'name' => 'admin', 'guard_name' => 'web']];

        //Default Permission & Role seeder
        $roleRepo = \App::make(RoleRepository::class);

        // Synchronize permissions
        $result = $roleRepo->synchModulePermissions(true);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        DB::table('roles')->insert(CrudHelper::setDatesInArray($roles));

        $admin = Role::findById(1);

        $permissions = \Spatie\Permission\Models\Permission::all();

        if (count($permissions) == 0) {
            $roleRepo->synchModulePermissions();

            $permissions = Permission::all();
        }

        foreach ($permissions as $permission) {
            $admin->permissions()->attach($permission->id);
        }
    }

    /**
     * Company Default Permissions
     * @param $companyId
     */
    private function addUserRolePermissions($companyId)
    {

        $roleRepo = \App::make(RoleRepository::class);

        $companyManager = Role::where('name', 'user')->where('company_id', $companyId)->first();


        $permissions = \Spatie\Permission\Models\Permission::all()
            ->where('name','!=','company.settings')
            ->where('name', '!=', 'settings.access');


        try {
            $company = Company::findOrFail($companyId);

            if ($company != null && $company->plan != null) {
                if($company->plan->permissions->count() > 0) {
                    $permissions = $company->plan->permissions;
                }
            }
        }catch (\Exception $exception){

        }

        $permissions = $permissions->where('name','!=','company.settings');

        if (count($permissions) == 0) {
            $roleRepo->synchModulePermissions();

            $permissions = Permission::all();
        }

        foreach ($permissions as $permission) {
            $companyManager->permissions()->attach($permission->id);
        }

    }

    /**
     * Company Default Permissions
     * @param $companyId
     */
    private function addCompanyManagerPermissions($companyId)
    {

        $roleRepo = \App::make(RoleRepository::class);

        $companyManager = Role::where('name', 'company_manager')->where('company_id', $companyId)->first();

        $permissions = \Spatie\Permission\Models\Permission::all()->where('name', '!=', 'settings.access');

        try {
            $company = Company::findOrFail($companyId);
            if ($company != null && $company->plan != null) {
                if($company->plan->permissions->count() > 0) {
                    $permissions = $company->plan->permissions;
                }
            }
        }catch (\Exception $exception){

        }

        if (count($permissions) == 0) {
            $roleRepo->synchModulePermissions();

            $permissions = Permission::all();
        }

        foreach ($permissions as $permission) {
            $companyManager->permissions()->attach($permission->id);
        }

    }
}
