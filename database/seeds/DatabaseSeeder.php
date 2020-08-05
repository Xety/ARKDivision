<?php

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

        // Discuss
        $this->call(DiscussCategoriesTableSeed::class);
        $this->call(DiscussConversationsTableSeed::class);
        $this->call(DiscussPostsTableSeed::class);
        $this->call(DiscussUsersTableSeed::class);
        $this->call(DiscussLogsTableSeed::class);

        // Experiences & Rubies
        $this->call(ExperiencesTableSeed::class);

        // Servers & Statutes
        $this->call(ServersTableSeed::class);
        $this->call(StatutesTableSeed::class);
        $this->call(ServerStatusTableSeed::class);
    }
}
