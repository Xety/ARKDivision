<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $rewards = [
            [
                'name' => 'Statue de la Manticore',
                'description' => 'Donne la statue de la Manticore lors d\'une donation.',
                'type' => 'Xetaravel\Events\Donation\NewDonationEvent',
                'data' => '{"commands":{"MediumManticore":"giveitem %s \"/Game/Mods/YashiFactory/manticorestatue/medium/PrimalItemStructure_Furniture_manticoreM.PrimalItemStructure_Furniture_manticoreM\" %s 0 0"}}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Statue de la Dragon',
                'description' => 'Donne la statue du Dragon lors d\'une donation.',
                'type' => 'Xetaravel\Events\Donation\NewDonationEvent',
                'data' => '{"commands":{"MediumManticore":"giveitem %s \"/Game/Mods/YashiFactory/manticorestatue/medium/PrimalItemStructure_Furniture_manticoreM.PrimalItemStructure_Furniture_manticoreM\" %s 0 0"}}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Statue du Gorilla',
                'description' => 'Donne la statue du Gorilla lors d\'une donation.',
                'type' => 'Xetaravel\Events\Donation\NewDonationEvent',
                'data' => '{"commands":{"MediumManticore":"giveitem %s \"/Game/Mods/YashiFactory/gorillastatue/medium/PrimalItemStructure_Furniture_gorillaM.PrimalItemStructure_Furniture_gorillaM\" %s 0 0"}}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('rewards')->insert($rewards);
    }
}
