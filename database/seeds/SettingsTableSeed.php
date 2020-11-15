<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $settings = [
            [
                'name' => 'ticket.number',
                'value_int' => 176,
                'value_str' => null,
                'value_bool' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.login.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.rewards.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'discuss.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}
