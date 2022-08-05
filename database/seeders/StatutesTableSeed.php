<?php
namespace Database\Seeders;

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
                'type_formatted' => 'Démarrage',
                'description' => 'Le serveur démarre',
                'color' => '0078d7',
                'emoji' => '🔵',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'initializing',
                'type_formatted' => 'Initialisation',
                'description' => 'Le serveur s\'initialise',
                'color' => 'fff100',
                'emoji' => '🟡',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'started',
                'type_formatted' => 'En ligne',
                'description' => 'Le serveur est démarré',
                'color' => '16c60c',
                'emoji' => '🟢',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'stopping',
                'type_formatted' => 'En cours d\'arrêt',
                'description' => 'Le serveur s\'arrête',
                'color' => 'f7630c',
                'emoji' => '🟠',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'stopped',
                'type_formatted' => 'Hors ligne',
                'description' => 'Le serveur est arrêté',
                'color' => 'e81224',
                'emoji' => '🔴',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('statutes')->insert($statutes);
    }
}
