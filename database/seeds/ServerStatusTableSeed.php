<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServerStatusTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->subMinutes(50);

        $seversStatutes = [
            [
                'server_id' => 1,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 2,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 3,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 4,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 5,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 6,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 7,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 8,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 9,
                'status_id' => 2,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 10,
                'status_id' => 3,
                'event_type' => 'discord',
                'was_forced' => false,
                'finished_at' => Carbon::now(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'server_id' => 10,
                'status_id' => 3,
                'event_type' => 'cron',
                'was_forced' => true,
                'finished_at' => null,
                'created_at' => Carbon::now()->subMinutes(45),
                'updated_at' => Carbon::now()->subMinutes(45),
            ]
        ];

        DB::table('server_status')->insert($seversStatutes);
    }
}
