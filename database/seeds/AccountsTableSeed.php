<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            [
                'user_id' => 1,
                'first_name' => 'Emeric',
                'last_name' => '',
                'facebook' => 'AdminFB',
                'twitter' => 'FMT_ZoRo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'first_name' => 'Admin',
                'last_name' => 'Name',
                'facebook' => 'EditorFB',
                'twitter' => 'EditorTW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('accounts')->insert($accounts);
    }
}