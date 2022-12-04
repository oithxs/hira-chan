<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPageTheme;

class UserPageThemeSeeder extends Seeder
{
    /**
     * user page theme の初期データ
     *
     * @link https://readouble.com/laravel/9.x/ja/seeding.html
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
