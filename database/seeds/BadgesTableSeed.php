<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesTableSeed extends Seeder
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
                'name' => 'Première donation',
                'image' => 'images/badges/donation-1.png',
                'type' => 'onNewDonation',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5 donations déjà !',
                'image' => 'images/badges/donation-5.png',
                'type' => 'onNewDonation',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Donateur hors pair !',
                'image' => 'images/badges/donation-10.png',
                'type' => 'onNewDonation',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Inscrit depuis 1 an',
                'image' => 'images/badges/registration-1.png',
                'type' => 'onNewRegister',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('badges')->insert($badges);
    }
}