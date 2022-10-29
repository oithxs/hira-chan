<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminMenuSeeder::class);
        $this->call(AdminPermissionSeeder::class);
        $this->call(UserPageThemeSeeder::class);
        $this->call(ThreadCategorySeeder::class);
    }
}
