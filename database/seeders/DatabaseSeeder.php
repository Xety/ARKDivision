<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        $this->call(UsersTableSeed::class);
        $this->call(AccountsTableSeed::class);

        // Permissions
        $this->call(RolesTableSeed::class);
        $this->call(PermissionsTableSeed::class);
        $this->call(PermissionsRolesTableSeed::class);
        $this->call(RoleUserTableSeed::class);

        // Badges
        $this->call(BadgesTableSeed::class);
        $this->call(BadgesUsersTableSeed::class);

        // Servers & Statutes
        $this->call(ServersTableSeed::class);
        $this->call(StatutesTableSeed::class);
        $this->call(ServerStatusTableSeed::class);

        // Rewards
        $this->call(RewardsTableSeed::class);

        // Steam Bans
        $this->call(SteamBansTableSeed::class);

        // Settings
        $this->call(SettingsTableSeed::class);
    }
}
