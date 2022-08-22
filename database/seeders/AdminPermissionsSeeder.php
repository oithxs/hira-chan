<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminPermissions;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminPermissions::updateOrCreate([
            'name' => 'General users',
            'slug' => 'general.users',
            'http_method' => '',
            'http_path' => '/general/users'
        ]);

        AdminPermissions::updateOrCreate([
            'name' => 'Send general users',
            'slug' => 'general.users.mail',
            'http_method' => 'GET,POST',
            'http_path' => '/general/users/create/mail'
        ]);
    }
}
