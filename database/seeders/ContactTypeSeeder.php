<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * contact_types テーブルの初期データ
     *
     * @link https://readouble.com/laravel/9.x/ja/seeding.html
     *
     * @return void
     */
    public function run()
    {
        ContactType::updateOrCreate([
            'name' => '不快なコンテンツ',
        ]);

        ContactType::updateOrCreate([
            'name' => '嫌がらせ，いじめ',
        ]);

        ContactType::updateOrCreate([
            'name' => '権利の侵害',
        ]);

        ContactType::updateOrCreate([
            'name' => 'スパムまたは誤解を招く内容',
        ]);

        ContactType::updateOrCreate([
            'name' => '掲示板サイトのバグ・脆弱性',
        ]);

        ContactType::updateOrCreate([
            'name' => 'その他',
        ]);
    }
}
