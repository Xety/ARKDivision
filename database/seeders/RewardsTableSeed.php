<?php
namespace Database\Seeders;

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
                'description' => 'Une très belle statue de la Manticore de taille moyenne obtenu uniquement lors d\'une donation.',
                'image' => 'images/rewards/manticore.png',
                'type' => 'Xetaravel\Events\Donation\DonationRewardEvent',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/YashiFactory/manticorestatue/medium/PrimalItemStructure_Furniture_manticoreM.PrimalItemStructure_Furniture_manticoreM\' 1 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Statue du Dragon',
                'description' => 'Une très belle statue du Dragon de taille moyenne obtenu uniquement lors d\'une donation.',
                'image' => 'images/rewards/dragon.png',
                'type' => 'Xetaravel\Events\Donation\DonationRewardEvent',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/YashiFactory/statuedragon/medium/PrimalItemStructure_Furniture_dragonM.PrimalItemStructure_Furniture_dragonM\' 1 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Statue du Gorille',
                'description' => 'Une très belle statue du Gorille de taille moyenne obtenu uniquement lors d\'une donation.',
                'image' => 'images/rewards/gorilla.png',
                'type' => 'Xetaravel\Events\Donation\DonationRewardEvent',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/YashiFactory/gorillastatue/medium/PrimalItemStructure_Furniture_gorillaM.PrimalItemStructure_Furniture_gorillaM\' 1 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('rewards')->insert($rewards);
    }
}
