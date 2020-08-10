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
                'password' => 'nicoslifefaitdelasso',
                'color' => 'aa8ed6',
                'emoji' => '<:aberration:737713854217191454>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CrystalIsles',
                'slug' => 'crystalisles',
                'ip' => '149.202.89.195',
                'rcon_port' => 32344,
                'password' => 'nicoslifefaitdelasso',
                'color' => '7c7c7c',
                'emoji' => '<:crystal_isles:737713911591206952>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Extinction',
                'slug' => 'extinction',
                'ip' => '149.202.89.195',
                'rcon_port' => 32332,
                'password' => 'nicoslifefaitdelasso',
                'color' => '55acee',
                'emoji' => '<:extinction:737713970319851599>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Genesis',
                'slug' => 'genesis',
                'ip' => '149.202.89.195',
                'rcon_port' => 32342,
                'password' => 'nicoslifefaitdelasso',
                'color' => 'dd2e44',
                'emoji' => '<:genesis:737714037676048445>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ragnarok',
                'slug' => 'ragnarok',
                'ip' => '149.202.89.195',
                'rcon_port' => 32334,
                'password' => 'nicoslifefaitdelasso',
                'color' => 'c1694f',
                'emoji' => '<:ragnarok:737714090075750492>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Scorched Earth',
                'slug' => 'scorched-earth',
                'ip' => '149.202.89.195',
                'rcon_port' => 32346,
                'password' => 'nicoslifefaitdelasso',
                'color' => 'fdcb58',
                'emoji' => '<:scorched_earth:737714145473986591>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'The Center',
                'slug' => 'the-center',
                'ip' => '149.202.89.195',
                'rcon_port' => 32336,
                'password' => 'nicoslifefaitdelasso',
                'color' => 'ffac33',
                'emoji' => '<:the_center:737714184892055634>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'The Island',
                'slug' => 'the-island',
                'ip' => '149.202.89.195',
                'rcon_port' => 32338,
                'password' => 'nicoslifefaitdelasso',
                'color' => '2f2f2f',
                'emoji' => '<:the_island:737714241532067913>',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Valguero',
                'slug' => 'valguero',
                'ip' => '149.202.89.195',
                'rcon_port' => 32340,
                'password' => 'nicoslifefaitdelasso',
                'color' => '78b159',
                'emoji' => '<:valguero:737714310171721780>',
                'is_display' => 1,
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
                'is_display' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ZTest Ragnarok',
                'slug' => 'ztest-ragnarok',
                'ip' => '149.202.89.195',
                'rcon_port' => 32348,
                'password' => 'MbSzeAbvMUUVs6iF',
                'color' => '2f2f2f',
                'emoji' => '<:ragnarok:737714090075750492>',
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
