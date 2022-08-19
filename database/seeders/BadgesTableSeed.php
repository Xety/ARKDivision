<?php
namespace Database\Seeders;

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
            // Inscription
            [
                'name' => 'Inscrit depuis 1 an !',
                'slug' => 'newregister1',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 1 an.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#2ec5ff',
                'type' => 'onNewRegister',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Jeune adolescent !',
                'slug' => 'newregister2',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 2 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#2eff51',
                'type' => 'onNewRegister',
                'rule' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Tu deviens vieux !',
                'slug' => 'newregister3',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 3 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#dfff2e',
                'type' => 'onNewRegister',
                'rule' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Club du 3ième âge !',
                'slug' => 'newregister5',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 5 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#ffbf2e',
                'type' => 'onNewRegister',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'C\'est la maison de retraite !',
                'slug' => 'newregister7',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 7 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#ff412e',
                'type' => 'onNewRegister',
                'rule' => 7,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Donations
            [
                'name' => 'Première donation !',
                'slug' => 'newdonation1',
                'description' => 'Gagné lors de votre première donation à Division.',
                'icon' => 'fas fa-gift',
                'color' => '#2ec5ff',
                'type' => 'onNewDonation',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5 donations déjà !',
                'slug' => 'newdonation5',
                'description' => 'Gagné lorsque vous avez fait au moins 5 donations.',
                'icon' => 'fas fa-gift',
                'color' => '#2eff51',
                'type' => 'onNewDonation',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Donateur hors pair !',
                'slug' => 'newdonation10',
                'description' => 'Gagné lorsque vous avez fait au moins 10 donations.',
                'icon' => 'fas fa-gift',
                'color' => '#dfff2e',
                'type' => 'onNewDonation',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Bill Gates !',
                'slug' => 'newdonation20',
                'description' => 'Gagné lorsque vous avez fait 20 donations.',
                'icon' => 'fas fa-gift',
                'color' => '#ff412e',
                'type' => 'onNewDonation',
                'rule' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('badges')->insert($badges);
    }
}
