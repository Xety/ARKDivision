<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesUsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $badges = [
            [
                'badge_id' => 1,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 2,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 3,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 4,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 5,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 6,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 7,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 8,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 9,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 10,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 11,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 12,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'badge_id' => 13,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('badge_user')->insert($badges);
    }
}
