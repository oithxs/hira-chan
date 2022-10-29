<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPageTheme;

class UserPageThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPageTheme::updateOrCreate([
            'theme_name' => 'default'
        ]);

        UserPageTheme::updateOrCreate([
            'theme_name' => 'dark'
        ]);
    }
}
