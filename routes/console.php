<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| コンソールルート
|--------------------------------------------------------------------------
|
| このファイルでは，クロージャベースのコンソールコマンドをすべて定義することが
| できます．各クロージャはコマンドのインスタンスにバインドされ，各コマンドの
| IOメソッドと対話するためのシンプルなアプローチを可能にします．
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
