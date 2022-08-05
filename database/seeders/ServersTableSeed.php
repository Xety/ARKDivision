<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servers = [
            [
                'name' => 'Aberration',
                'slug' => 'aberration',
                'ip' => '162.55.6.39',
                'rcon_port' => 32330,
                'password' => 'zorofaitdubot',
                'color' => 'aa8ed6',
                'emoji' => '<:aberration:737713854217191454>',
                'discord_message_id' => 769134754363867156,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CrystalIsles',
                'slug' => 'crystalisles',
                'ip' => '162.55.6.39',
                'rcon_port' => 32344,
                'password' => 'zorofaitdubot',
                'color' => '7c7c7c',
                'emoji' => '<:crystal_isles:737713911591206952>',
                'discord_message_id' => 769135986495979572,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Extinction',
                'slug' => 'extinction',
                'ip' => '162.55.6.39',
                'rcon_port' => 32332,
                'password' => 'zorofaitdubot',
                'color' => '55acee',
                'emoji' => '<:extinction:737713970319851599>',
                'discord_message_id' => 769135991293870080,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Genesis',
                'slug' => 'genesis',
                'ip' => '162.55.6.39',
                'rcon_port' => 32342,
                'password' => 'zorofaitdubot',
                'color' => 'dd2e44',
                'emoji' => '<:genesis:737714037676048445>',
                'discord_message_id' => 769135995551350815,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ragnarok',
                'slug' => 'ragnarok',
                'ip' => '162.55.6.39',
                'rcon_port' => 32334,
                'password' => 'zorofaitdubot',
                'color' => 'c1694f',
                'emoji' => '<:ragnarok:737714090075750492>',
                'discord_message_id' => 769135999698993153,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Scorched Earth',
                'slug' => 'scorched-earth',
                'ip' => '162.55.6.39',
                'rcon_port' => 32346,
                'password' => 'zorofaitdubot',
                'color' => 'fdcb58',
                'emoji' => '<:scorched_earth:737714145473986591>',
                'discord_message_id' => 769136003524591646,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'The Center',
                'slug' => 'the-center',
                'ip' => '162.55.6.39',
                'rcon_port' => 32336,
                'password' => 'zorofaitdubot',
                'color' => 'ffac33',
                'emoji' => '<:the_center:737714184892055634>',
                'discord_message_id' => 742878132784201838,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'The Island',
                'slug' => 'the-island',
                'ip' => '162.55.6.39',
                'rcon_port' => 32338,
                'password' => 'zorofaitdubot',
                'color' => '2f2f2f',
                'emoji' => '<:the_island:737714241532067913>',
                'discord_message_id' => 769136008435990530,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Valguero',
                'slug' => 'valguero',
                'ip' => '162.55.6.39',
                'rcon_port' => 32340,
                'password' => 'zorofaitdubot',
                'color' => '78b159',
                'emoji' => '<:valguero:737714310171721780>',
                'discord_message_id' => 769136032099991553,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Genesis2',
                'slug' => 'genesis2',
                'ip' => '162.55.6.39',
                'rcon_port' => 32348,
                'password' => 'zorofaitdubot',
                'color' => 'dd2e44',
                'emoji' => '<:Gen2:853249913348554752>',
                'discord_message_id' => 769136036432838656,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fjordur',
                'slug' => 'fjordur',
                'ip' => '162.55.6.39',
                'rcon_port' => 32354,
                'password' => 'zorofaitdubot',
                'color' => 'dd2e44',
                'emoji' => '<:fjordur:998000086548222033>',
                'discord_message_id' => 769136040622948352,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lost Island',
                'slug' => 'lostisland',
                'ip' => '162.55.6.39',
                'rcon_port' => 32350,
                'password' => 'zorofaitdubot',
                'color' => 'dd2e44',
                'emoji' => '<:lost_island:998000130303213668>',
                'discord_message_id' => 769136044439240714,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ZEvent',
                'slug' => 'zevent',
                'ip' => '162.55.6.39',
                'rcon_port' => 32352,
                'password' => 'nicoleplusbeau',
                'color' => '2f2f2f',
                'emoji' => '<:the_island:737714241532067913>',
                'discord_message_id' => 769136048700784650,
                'is_display' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('servers')->insert($servers);

        // Update servers image
        foreach ($servers as $server) {
            $model = \Xetaravel\Models\Server::withoutGlobalScopes()->where('slug', $server['slug'])->first();
            $model->addMedia(resource_path('assets/images/servers/' . $server['slug'] . '.png'))
                ->preservingOriginal()
                ->setName($server['name'])
                ->setFileName($server['slug'] . '.png')
                ->toMediaCollection('server');
        }
    }
}
