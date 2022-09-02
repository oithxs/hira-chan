<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminPermission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminPermission::updateOrCreate([
            'name' => 'General users',
            'slug' => 'general.users',
            'http_method' => '',
            'http_path' => '/general/users'
        ]);

        AdminPermission::updateOrCreate([
            'name' => 'Send general users',
            'slug' => 'general.users.mail',
            'http_method' => 'GET,POST',
            'http_path' => '/general/users/create/mail'
        ]);

        AdminPermission::updateOrCreate([
            'name' => 'General threads',
            'slug' => 'general.threads',
            'http_method' => '',
            'http_path' => '/general/threads'
        ]);
    }
}
