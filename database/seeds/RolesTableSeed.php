<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Développeur',
                'slug' => 'developpeur',
                'description' => '',
                'css' => 'font-weight: bold; color: #ef3c3c;',
                'level' => 4,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Administrateur',
                'slug' => 'administrateur',
                'description' => '',
                'css' => 'font-weight: bold; color: #14e8e1;',
                'level' => 3,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Membre',
                'slug' => 'membre',
                'description' => '',
                'css' => 'font-weight: bold; color: #00af94;',
                'level' => 2,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Utilisateur',
                'slug' => 'utilisateur',
                'description' => '',
                'css' => 'font-weight: bold;',
                'level' => 1,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Banni',
                'slug' => 'banni',
                'description' => '',
                'css' => 'font-weight: bold; color: #843729;',
                'level' => 0,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
