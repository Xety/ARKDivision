<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatutesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statutes = [
            [
                'type' => 'starting',
                'description' => 'Le serveur démarre',
                'emoji' => '🔵',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'initializing',
                'description' => 'Le serveur s\'initialise',
                'emoji' => '🟡',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'started',
                'description' => 'Le serveur est démarré',
                'emoji' => '🟢',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'stopping',
                'description' => 'Le serveur s\'arrête',
                'emoji' => '🟠',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'stopped',
                'description' => 'Le serveur est arrêté',
                'emoji' => '🔴',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('statutes')->insert($statutes);
    }
}
