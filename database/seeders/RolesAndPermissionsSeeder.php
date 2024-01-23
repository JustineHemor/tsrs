<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles_permissions = [
            'User Manager' => [
                'assign-role',
                'access-nova',
            ],
            'Trip Requester' => [
                'create-trip-ticket',
                'view-trip-ticket',
            ],
            'Supplies Requester' => [
                'create-supplies-request',
                'view-supplies-requests',
            ],
            'Trip Approver' => [
                'view-all-trip-ticket',
                'approve-trip-ticket',
                'deny-trip-ticket',
                'view-reports',
                'generate-report',
            ],
            'Supplies Approver' => [
                'view-all-supplies-requests',
                'approve-supplies-request',
                'deny-supplies-request',
                'fulfill-supplies-request',
                'view-reports',
                'generate-report',
            ],
        ];

        foreach ($roles_permissions as $role => $permissions) {
            $this_role = Role::findOrCreate($role);

            foreach ($permissions as $permission) {
                $this_permission = Permission::findOrCreate($permission);

                if (!$this_role->hasPermissionTo($permission)) {
                    $this_role->givePermissionTo($this_permission);
                }
            }
        }
    }
}
