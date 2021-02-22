<?php

use Illuminate\Database\Seeder;
use Xetaravel\Models\Permission;
use Xetaravel\Models\Role;

class PermissionsRolesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Développeur Role
        $role = Role::where('slug', 'developpeur')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.users')->first());
        $role->attachPermission(Permission::where('slug', 'manage.roles')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.conversations')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.categories')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.posts')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Administrateur Role
        $role = Role::where('slug', 'administrateur')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.conversations')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.categories')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.posts')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Ambassadeur Role
        $role = Role::where('slug', 'ambassadeur')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.conversations')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.posts')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Membre Role
        $role = Role::where('slug', 'membre')->first();
        $role->attachPermission(Permission::where('slug', 'access.member')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Utilisateur Role
        $role = Role::where('slug', 'utilisateur')->first();
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Banni Role
        $role = Role::where('slug', 'banni')->first();
        $role->attachPermission(Permission::where('slug', 'show.banished')->first());
    }
}
