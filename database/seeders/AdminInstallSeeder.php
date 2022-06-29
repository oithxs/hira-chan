<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminMenu;

class AdminInstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminMenu::updateOrCreate([
            'parent_id' => 0,
            'order' => 8,
            'title' => 'General',
            'icon' => 'fa-street-view'
        ]);

        AdminMenu::updateOrCreate([
            'parent_id' => 8,
            'order' => 9,
            'title' => 'Users',
            'icon' => 'fa-users',
            'uri' => 'users'
        ]);
    }
}
