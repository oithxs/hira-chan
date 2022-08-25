<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPageThema;

class UserPageThemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPageThema::updateOrCreate([
            'thema_id' => 0,
            'thema_name' => 'default'
        ]);

        UserPageThema::updateOrCreate([
            'thema_id' => 1,
            'thema_name' => 'dark'
        ]);
    }
}
