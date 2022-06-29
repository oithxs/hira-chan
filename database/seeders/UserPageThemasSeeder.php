<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPageThemas;

class UserPageThemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPageThemas::updateOrCreate([
            'thema_id' => 0,
            'thema_name' => 'default'
        ]);

        UserPageThemas::updateOrCreate([
            'thema_id' => 1,
            'thema_name' => 'dark'
        ]);
    }
}
