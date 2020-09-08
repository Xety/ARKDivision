<?php

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
                'ip' => '149.202.89.195',
                'rcon_port' => 32330,
                'password' => 'torafaitdutcs',
                'color' => 'aa8ed6',
                'emoji' => '<:aberration:737713854217191454>',
                'discord_message_id' => 742878106951483552,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CrystalIsles',
                'slug' => 'crystalisles',
                'ip' => '149.202.89.195',
                'rcon_port' => 32344,
                'password' => 'torafaitdutcs',
                'color' => '7c7c7c',
                'emoji' => '<:crystal_isles:737713911591206952>',
                'discord_message_id' => 742878110512578651,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Extinction',
                'slug' => 'extinction',
                'ip' => '149.202.89.195',
                'rcon_port' => 32332,
                'password' => 'torafaitdutcs',
                'color' => '55acee',
                'emoji' => '<:extinction:737713970319851599>',
                'discord_message_id' => 742878114962473010,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Genesis',
                'slug' => 'genesis',
                'ip' => '149.202.89.195',
                'rcon_port' => 32342,
                'password' => 'torafaitdutcs',
                'color' => 'dd2e44',
                'emoji' => '<:genesis:737714037676048445>',
                'discord_message_id' => 742878119249051738,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ragnarok',
                'slug' => 'ragnarok',
                'ip' => '149.202.89.195',
                'rcon_port' => 32334,
                'password' => 'torafaitdutcs',
                'color' => 'c1694f',
                'emoji' => '<:ragnarok:737714090075750492>',
                'discord_message_id' => 742878123879563334,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Scorched Earth',
                'slug' => 'scorched-earth',
                'ip' => '149.202.89.195',
                'rcon_port' => 32346,
                'password' => 'torafaitdutcs',
                'color' => 'fdcb58',
                'emoji' => '<:scorched_earth:737714145473986591>',
                'discord_message_id' => 742878131752402964,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'The Center',
                'slug' => 'the-center',
                'ip' => '149.202.89.195',
                'rcon_port' => 32336,
                'password' => 'torafaitdutcs',
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
                'ip' => '149.202.89.195',
                'rcon_port' => 32338,
                'password' => 'torafaitdutcs',
                'color' => '2f2f2f',
                'emoji' => '<:the_island:737714241532067913>',
                'discord_message_id' => 742878137184157798,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Valguero',
                'slug' => 'valguero',
                'ip' => '149.202.89.195',
                'rcon_port' => 32340,
                'password' => 'torafaitdutcs',
                'color' => '78b159',
                'emoji' => '<:valguero:737714310171721780>',
                'discord_message_id' => 742878141760012300,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ZDiscovery',
                'slug' => 'zdiscovery',
                'ip' => '149.202.89.195',
                'rcon_port' => 32338,
                'password' => 'torafaitdutcs',
                'color' => '78b159',
                'emoji' => '<:the_island:737714241532067913>',
                'discord_message_id' => 0,
                'is_display' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ZMap Event',
                'slug' => 'zmap-event',
                'ip' => '149.202.89.195',
                'rcon_port' => 32350,
                'password' => 'bigeventserver',
                'color' => '2f2f2f',
                'emoji' => '<:the_island:737714241532067913>',
                'discord_message_id' => 742878146642051272,
                'is_display' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ZTest Map Temp',
                'slug' => 'ztest-map-temp',
                'ip' => '149.202.89.195',
                'rcon_port' => 32352,
                'password' => 'MbSzeAbvMUUVs6iF',
                'color' => '2f2f2f',
                'emoji' => '<:ragnarok:737714090075750492>',
                'discord_message_id' => 742878153940271134,
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
