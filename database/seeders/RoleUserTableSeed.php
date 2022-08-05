<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

class RoleUserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'ZoRo')->first();
        $user->attachRole(Role::where('slug', 'developpeur')->first());

        $user = User::where('username', 'Admin')->first();
        $user->attachRole(Role::where('slug', 'administrateur')->first());

        $user = User::where('username', 'Membre')->first();
        $user->attachRole(Role::where('slug', 'membre')->first());

        $user = User::where('username', 'Utilisateur')->first();
        $user->attachRole(Role::where('slug', 'utilisateur')->first());

        $user = User::where('username', 'Banni')->first();
        $user->attachRole(Role::where('slug', 'banni')->first());
    }
}
