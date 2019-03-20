<?php

namespace Modules\Platform\User\Repositories;

use Modules\Platform\Core\Helper\FileHelper;
use Modules\Platform\Core\Repositories\PlatformRepository;
use Modules\Platform\User\Entities\Role;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;

/**
 * Class RoleRepository
 * @package Modules\Platform\User\Repositories
 */
class RoleRepository extends PlatformRepository
{

    /**
     * @var array
     */
    private $permissionCreated = [

    ];

    /**
     * @var array
     */
    private $permissionDeleted = [

    ];

    public function model()
    {
        return Role::class;
    }

    /**
     * Return grouped permissions by perm_group
     *
     * @param Role|null $role
     * @return array
     */
    public function getGroupedAllPermissions(Role $role = null )
    {

        $availablePermissions = Permission::all();

        $company = session()->get('currentCompany');
        if($role != null && $role->id != 1 && $company != null && $company->plan != null ){
            $availablePermissions = $company->plan->permissions;
        }

        $grouped =  Arrays::groupBy($availablePermissions->toArray(), Functions::extractField('perm_group'));

        ksort($grouped);

        return $grouped;
    }

    public function getRoleForAdmin(){
        return Role::where(function($q){
            $q->where('id','=',1)
                ->orWhere('company_id',\Landlord::getTenantId('company_id'));
        })->pluck('display_name', 'name')
            ->toArray();
    }

    public function getRolesByNames($rolesNames,$adminCheck = false ){

        if($adminCheck){

            return Role::where(function($q){
                $q->where('id','=',1)->orWhere('company_id',\Landlord::getTenantId('company_id'));
            })->whereIn('name',$rolesNames)->get();
        }
        return Role::where('id','<>',1)
            ->where('company_id',\Landlord::getTenantId('company_id'))
            ->whereIn('name',$rolesNames)->get();
    }

    public function getRolesForCompany(){
        return Role::where('id','<>',1)
            ->where('company_id',\Landlord::getTenantId('company_id'))
            ->pluck('display_name', 'name')
            ->toArray();
    }


    /**
     * @param $deleteUnused - Delete Unused permissions
     * @return array
     */
    public function synchModulePermissions($deleteUnused = false)
    {
        if ($deleteUnused) {
            $this->deletePermissions();
        }

        $modules = \Module::toCollection();

        foreach ($modules as $module) {
            $config = include $module->getPath().'/Config/config.php';

            if (isset($config['permissions'])) {
                $permissions = $config['permissions'];

                if ($permissions != null) {
                    foreach ($permissions as $permissionName) {
                        try {
                            $permission = Permission::findByName($permissionName);
                        } catch (PermissionDoesNotExist $e) {
                            // Permission not exist create one

                            $permission = Permission::create([
                                'name' => $permissionName,
                                'guard_name' => 'web',
                                'perm_group' => $module->name
                            ]);

                            $this->permissionCreated[] = $permission;
                        }
                    }
                }
            }
        }

        return [
            'created' => $this->permissionCreated,
            'deleted' => $this->permissionDeleted
        ];
    }

    /**
     * Check permissions in database and delete unused
     */
    private function deletePermissions()
    {
        $databasePermissions = Permission::all()->pluck('name');

        $modules = \Module::toCollection();

        $permissionCollection = [];

        foreach ($modules as $module) {
            $permissions = config($module->getLowerName() . '.permissions');
            if ($permissions != null) {
                foreach ($permissions as $permissionName) {
                    $permissionCollection[] = $permissionName;
                }
            }
        }

        $dif = array_diff($databasePermissions->toArray(), $permissionCollection);

        foreach ($dif as $perm) {
            $perm = Permission::findByName($perm);
            $this->permissionDeleted[] = $perm;
            $perm->delete();
        }
    }
}
