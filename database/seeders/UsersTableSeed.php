<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'ZoRo',
                'email' => 'zoro.fmt@gmail.com',
                'password' => bcrypt('zoro'),
                'slug' => 'zoro',
                'discord_id' => 92596320333742080,
                'steam_id' => 76561198099250608,
                'api_token' => 'mGJxtv2xEkkzVh5Hax2t85J6j6CTlOPg8klkePfrKC3O5D4PuPe0wEMyndOp2lSSdg2va9AOEQzHMkBP',
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Admin',
                'email' => 'admin@division.io',
                'password' => bcrypt('admin'),
                'slug' => 'admin',
                'discord_id' => null,
                'steam_id' => null,
                'api_token' => null,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Membre',
                'email' => 'membre@division.io',
                'password' => bcrypt('membre'),
                'slug' => 'membre',
                'discord_id' => null,
                'steam_id' => null,
                'api_token' => null,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'email_verified_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Utilisateur',
                'email' => 'utilisateur@division.io',
                'password' => bcrypt('utilisateur'),
                'slug' => 'utilisateur',
                'discord_id' => null,
                'steam_id' => null,
                'api_token' => null,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'email_verified_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Banni',
                'email' => 'banni@division.io',
                'password' => bcrypt('banni'),
                'slug' => 'banni',
                'discord_id' => null,
                'steam_id' => null,
                'api_token' => null,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'email_verified_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('users')->insert($users);

        // Update avatars
        foreach ($users as $user) {
            $model = \Xetaravel\Models\User::where('username', $user['username'])->first();
            $model->addMedia(resource_path('assets/images/avatar.png'))
                ->preservingOriginal()
                ->setName(substr(md5($user['username']), 0, 10))
                ->setFileName(substr(md5($user['username']), 0, 10) . '.png')
                ->withCustomProperties(['primaryColor' => '#B4AEA4'])
                ->toMediaCollection('avatar');
        }
    }
}
