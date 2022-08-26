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

            // Disciple de Nakor
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

            // Labyrinthe de Tatie
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
            ],

            // Coffres
            [
                'name' => 'Biles d\'ammonite',
                'description' => '30 Bile d\'ammonite obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/ammonite_bile.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_AmmoniteBlood.PrimalItemResource_AmmoniteBlood\' 30 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Fléchettes tranquillisante améliorée',
                'description' => '20 Fléchettes tranquillisante améliorée obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/shocking_tranquilizer_dart.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Weapons/PrimalItemAmmo_RefinedTranqDart.PrimalItemAmmo_RefinedTranqDart\' 20 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Sang de sangsue',
                'description' => '20 Sang de sangsue obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/leech_blood.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_LeechBlood.PrimalItemResource_LeechBlood\' 20 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Poches de sang',
                'description' => '10 Poches de sang obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/blood_pack.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_BloodPack.PrimalItemConsumable_BloodPack\' 10 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Eléments',
                'description' => '20 Eléments obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/element.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_Element.PrimalItemResource_Element\' 20 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Eléments',
                'description' => '20 Eléments obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/element.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_Element.PrimalItemResource_Element\' 20 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Fragments d\'Element',
                'description' => '1000 Fragments d\'Elément obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/element_shard.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_ElementShard.PrimalItemResource_ElementShard\' 1000 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Polymères',
                'description' => '100 Polymères obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/polymer.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_Polymer.PrimalItemResource_Polymer\' 100 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Cheveux humains',
                'description' => '200 Cheveux humains obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/human_hair.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_Hair.PrimalItemResource_Hair\' 200 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Fibres',
                'description' => '100 Fibres obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/fiber.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_Fibers.PrimalItemResource_Fibers\' 100 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Graines de speciment plante Z',
                'description' => '10 Graines de speciment plante Z obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/plant_species_z_seed.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Aberration/WeaponPlantSpeciesZ/PrimalItemConsumable_Seed_PlantSpeciesZ.PrimalItemConsumable_Seed_PlantSpeciesZ\' 10 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Laits de wyverne',
                'description' => '20 Laits de wyverne obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/plant_species_z_seed.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/BaseBPs/PrimalItemConsumable_WyvernMilk.PrimalItemConsumable_WyvernMilk\' 20 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Gâteaux aux légumes',
                'description' => '10 Gâteaux aux légumes obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/sweet_vegetable_cake.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_SweetVeggieCake.PrimalItemConsumable_SweetVeggieCake\' 10 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Oeufs d\'Hesperornis en or',
                'description' => '3 Oeufs d\'Hesperornis en or obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/golden_hesperornis_egg.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/Test/PrimalItemConsumable_Egg_Hesperonis_Golden.PrimalItemConsumable_Egg_Hesperonis_Golden\' 3 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Potions de santé',
                'description' => '50 Potions de santé obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/medical_brew.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_HealSoup.PrimalItemConsumable_HealSoup\' 50 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Cartouche de fusil à pompe',
                'description' => '100 Cartouche de fusil à pompe obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/simple_shotgun_ammo.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Weapons/PrimalItemAmmo_SimpleShotgunBullet.PrimalItemAmmo_SimpleShotgunBullet\' 100 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Super fertilisant',
                'description' => '10 Super fertilisant obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/re-fertilizer.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/BaseBPs/PrimalItemConsumableMiracleGro.PrimalItemConsumableMiracleGro\' 10 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Tonic d\'amnésie totale',
                'description' => '3 Tonic d\'amnésie totale obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/mindwipe_tonic.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/BaseBPs/PrimalItemConsumableRespecSoup.PrimalItemConsumableRespecSoup\' 3 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '100 Points',
                'description' => '100 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 2 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '150 Points',
                'description' => '150 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 3 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '200 Points',
                'description' => '200 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 4 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '250 Points',
                'description' => '250 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 5 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '300 Points',
                'description' => '300 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 6 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '350 Points',
                'description' => '350 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 7 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '400 Points',
                'description' => '400 Points obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-50.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts5.PrimalItemConsumable_Pts5\' 8 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5 Kibbles Extraordinaires',
                'description' => '5 Kibbles Extraordinaires obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/extraordinary_kibble.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_Kibble_Base_Special.PrimalItemConsumable_Kibble_Base_Special\' 5 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '3 Soupes Piquantes',
                'description' => '3 Soupes Piquantes obtenues dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/calien_soup.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_Soup_CalienSoup.PrimalItemConsumable_Soup_CalienSoup\' 3 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '100 Pétroles',
                'description' => '100 Pétroles obtenus dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/oil.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Resources/PrimalItemResource_Oil.PrimalItemResource_Oil\' 100 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5 Mutagens',
                'description' => '5 Mutagens obtenus dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/mutagen.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Genesis2/CoreBlueprints/Environment/Mutagen/PrimalItemConsumable_Mutagen.PrimalItemConsumable_Mutagen\' 5 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5 Gros excréments',
                'description' => '5 Gros excréments obtenus dans les coffres journaliers.' .
                                                'On peut le dire, tu as choppé le pack de merde !',
                'image' => 'images/rewards/coffres/feces.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_DinoPoopLarge.PrimalItemConsumable_DinoPoopLarge\' 5 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '50 Narcotiques',
                'description' => '50 Narcotiques obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/narcotic.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_Narcotic.PrimalItemConsumable_Narcotic\' 50 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '1 Cristal de Gacha',
                'description' => '1 Cristal de Gacha obtenu dans les coffres journaliers.' .
                                                ' Il semblerait que c\'est ton jour de chance !',
                'image' => 'images/rewards/coffres/gacha_crystal.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Extinction/Dinos/Gacha/PrimalItemConsumable_GachaPod.PrimalItemConsumable_GachaPod\' 1 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '50 Pommes de Terre',
                'description' => '50 Pommes de Terre obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/savoroot.webp',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffre',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/PrimalEarth/CoreBlueprints/Items/Consumables/PrimalItemConsumable_Veggie_Savoroot.PrimalItemConsumable_Veggie_Savoroot\' 50 0 0"}',
                'rule' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Coffres Bonus
            [
                'name' => '500 Points',
                'description' => '500 Points Bonus obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-500.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffreBonus',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts50.PrimalItemConsumable_Pts50\' 1 0 0"}',
                'rule' => '500',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '1000 Points',
                'description' => '1000 Points Bonus obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-500.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffreBonus',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts50.PrimalItemConsumable_Pts50\' 2 0 0"}',
                'rule' => '1000',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '1500 Points',
                'description' => '1500 Points Bonus obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-500.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffreBonus',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts50.PrimalItemConsumable_Pts50\' 3 0 0"}',
                'rule' => '1500',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '2500 Points',
                'description' => '2500 Points Bonus obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-500.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffreBonus',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts50.PrimalItemConsumable_Pts50\' 5 0 0"}',
                'rule' => '2500',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5000 Points',
                'description' => '5000 Points Bonus obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-1000.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffreBonus',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts50.PrimalItemConsumable_Pts50\' 5 0 0"}',
                'rule' => '5000',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '10000 Points',
                'description' => '10000 Points Bonus obtenu dans les coffres journaliers.',
                'image' => 'images/rewards/coffres/arkshop-1000.png',
                'gender' => 0,
                'gender_male' => null,
                'gender_female' => null,
                'type' => 'Xetaravel\Events\Events\RewardDailyCoffreBonus',
                'data' => '{"command":"GiveItemToSteamId %s Blueprint\'/Game/Mods/ShopPoints/Items/Points/PrimalItemConsumable_Pts100.PrimalItemConsumable_Pts100\' 10 0 0"}',
                'rule' => '10000',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('rewards')->insert($rewards);
    }
}
