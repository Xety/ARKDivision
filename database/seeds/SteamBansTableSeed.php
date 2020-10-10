<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SteamBansTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $bans = [
            [
                'steam_id' => 76561198099250608,
                'banned_by' => 92596320333742080,
                'forever' => false,
                'reason' => 'Beaucoup trop BG pour jouer sur les serveurs Division.',
                'expire_at' => '2020-07-09 01:35:26',
                'created_at' => '2020-07-06 01:35:26',
                'updated_at' => '2020-07-06 01:35:26'
            ],
            [
                'steam_id' => 76561198867477680,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-06 01:36:21',
                'created_at' => '2020-07-06 01:36:21',
                'updated_at' => '2020-07-06 01:36:21'
            ],
            [
                'steam_id' => 76561198973123614,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 01:36:21',
                'created_at' => '2020-07-06 01:36:21',
                'updated_at' => '2020-07-06 01:36:21'
            ],
            [
                'steam_id' => 76561198865253268,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198169850030,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198826938577,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561197981403026,
                'banned_by' => 92596320333742080,
                'forever' => false,
                'reason' => 'A été ban le 31/08/2019 par Kev264 pour vol d\'oeuf de Gigano. A demandé à être' .
                'débanni le 14/08/2020 en MP à ZoRo. A été débanni le 18/08/2020 sur décision du staff.',
                'expire_at' => '2020-08-18 21:00:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198069890666,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198100328989,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198887678140,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198089943024,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198965055076,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198080233914,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198156401665,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198132524709,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198297899292,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198367161416,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198365834462,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198015518814,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198002817497,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198364676378,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561198078572474,
                'banned_by' => 92596320333742080,
                'forever' => true,
                'reason' => 'Test de raison',
                'expire_at' => '2020-07-08 16:32:04',
                'created_at' => '2020-07-08 16:32:04',
                'updated_at' => '2020-07-08 16:32:04'
            ],
            [
                'steam_id' => 76561199019759272,
                'banned_by' => 267393701393858561,
                'forever' => false,
                'reason' => 'Comportement avec Commu & Staff + Vol avéré de la tribu',
                'expire_at' => '2020-07-24 20:31:08',
                'created_at' => '2020-07-22 20:31:08',
                'updated_at' => '2020-07-22 20:31:08'
            ],
            [
                'steam_id' => 76561198201902935,
                'banned_by' => 267393701393858561,
                'forever' => false,
                'reason' => 'Vol de d\'oeufs fécondés (avoué)',
                'expire_at' => '2020-07-25 19:50:58',
                'created_at' => '2020-07-23 19:50:58',
                'updated_at' => '2020-07-23 19:50:58'
            ],
            [
                'steam_id' => 76561198048662724,
                'banned_by' => 267393701393858561,
                'forever' => false,
                'reason' => 'Vols d\'oeufs fécondés + Pillage de base (impossible à contacter par MP)',
                'expire_at' => '2020-08-14 18:30:00',
                'created_at' => '2020-08-02 16:41:28',
                'updated_at' => '2020-08-02 16:41:28'
            ],
            [
                'steam_id' => 76561198033538897,
                'banned_by' => 267393701393858561,
                'forever' => true,
                'reason' => 'Irrespect',
                'expire_at' => '2020-08-10 01:00:26',
                'created_at' => '2020-08-09 23:00:26',
                'updated_at' => '2020-08-09 23:00:26'
            ],
            [
                'steam_id' => 76561198960005237,
                'banned_by' => 267393701393858561,
                'forever' => true,
                'reason' => 'Irrespect',
                'expire_at' => '2020-08-10 01:00:42',
                'created_at' => '2020-08-09 23:00:42',
                'updated_at' => '2020-08-09 23:00:42'
            ],
            [
                'steam_id' => 76561198300683073,
                'banned_by' => 149850524294840321,
                'forever' => true,
                'reason' => 'Foutage de gueule,Nos serveurs sont des serveurs "de merde"...etc',
                'expire_at' => '2020-08-13 17:55:13',
                'created_at' => '2020-08-13 15:55:13',
                'updated_at' => '2020-08-13 15:55:13'
            ],
            [
                'steam_id' => 76561198244254036,
                'banned_by' => 267393701393858561,
                'forever' => false,
                'reason' => 'Vol d\'oeufs dans une base (spawn dans la base et coffre déverrouillé)',
                'expire_at' => '2020-08-17 12:33:17',
                'created_at' => '2020-08-15 10:33:17',
                'updated_at' => '2020-08-15 10:33:17'
            ],
            [
                'steam_id' => 76561198353968814,
                'banned_by' => 267393701393858561,
                'forever' => true,
                'reason' => 'Loxas : Comportement déplacé + Insultes envers le staff',
                'expire_at' => '2020-08-22 00:28:38',
                'created_at' => '2020-08-21 22:28:38',
                'updated_at' => '2020-08-21 22:28:38'
            ]
        ];

        DB::table('steam_bans')->insert($bans);
    }
}
