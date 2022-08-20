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
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
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
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
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
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Donation\DonationRewardEvent',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/YashiFactory/gorillastatue/medium/PrimalItemStructure_Furniture_gorillaM.PrimalItemStructure_Furniture_gorillaM\' 1 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Casquette Division',
                'description' => 'Une très belle casquette au nom de Division reçu lors de la participation à l\'évènement L\'épopée de Nakor le 28/02/2021.',
                'image' => 'images/rewards/casquette_division.png',
                'gender' => 1,
                'gender_male' => '/Game/Mods/YashiFactory/maleskins/casquette_Division/PrimalItemSkin_DivCap.PrimalItemSkin_DivCap',
                'gender_female' => '/Game/Mods/YashiFactory/femaleskins/Div_Cap_F/PrimalItemSkin_DivCapF.PrimalItemSkin_DivCapF',
                'type' => 'Xetaravel\Events\Events\RewardNakor',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'%s\' 1 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '200 Lingots ARc',
                'description' => '200 Lingots ARc obtenu lors de la participation à l\'évènement L\'épopée de Nakor le 28/02/2021.',
                'image' => 'images/rewards/arc_bars_platinium.jpg',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardNakor',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/TCsAutoRewards/Main/Currency/PrimalItemConsumable_TCsAR_CurrencyARcPlatinum.PrimalItemConsumable_TCsAR_CurrencyARcPlatinum\' 2 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '7500 Shop Points',
                'description' => '7500 Points obtenu lors de la participation à l\'évènement  Le Labyrinthe de Tatie  le 20/08/2022.',
                'image' => 'images/rewards/points/arkshop-500.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardLabyrintheTatie',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts50.PrimalItemConsumable_Pts50\' 15 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un Kaprosuchus',
                'description' => 'Un Kaprosuchus lvl 300 obtenu lors de la participation à l\'évènement  Le Labyrinthe de Tatie  le 20/08/2022.',
                'image' => 'images/rewards/dinos/kaprosuchus.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardLabyrintheTatie',
                'data' => '{"command":"scriptcommand spawndino_ds %s /Game/PrimalEarth/Dinos/Kaprosuchus/Kaprosuchus_Character_BP.Kaprosuchus_Character_BP 0 0 0 10 1 ? 1 1 0 1 1 60 36 36 36 36 36 60 35 0 211 90 90 211 90 90 Reward_Le_Labyrinthe_de_Tatie Ouvrez_pour_voir_votre_Dino"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('rewards')->insert($rewards);
    }
}
