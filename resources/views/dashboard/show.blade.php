<!--
    ダッシュボードのファイル（予定）
    他ファイルと組み合わせて表示予定
    現在は大体の構成
 -->

<x-app-layout>

    <!-- ここからカテゴリ別 -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __("Top page") }}
        </h2>
    </x-slot>
    <!-- ここまでカテゴリ別 -->


    <div class="container">

        <!-- ここからPVランキング -->
        <div class="row container">
            <div class="py-12 col-lg-12 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <br>
                        PV ランキング
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- ここまでPVランキング -->

        <div class="row">
            <!-- ここからメインの表示欄 -->
            <div class="py-12 col-lg-8 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <br>
                        1. トップページの場合は新着スレッド紹介表示<br>
                        2. すでに何かのスレにアクセスしていればスレ内容を表示<br>
                        3. カテゴリ別（詳細カテゴリの場合も含むにアクセスした場合はカテゴリの新着順にスレッド紹介表示）<br>
                        <br>
                    </div>
                </div>
            </div>
            <!-- ここまでメインの表示欄 -->

            <!-- ここから右にいろいろ -->
            <div class="py-12 col-lg-4 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <br>
                        イ，詳細カテゴリ<br>
                        ロ，問い合わせ<br>
                        ハ，週間ランキング<br>
                        等々
                        <br>
                    </div>
                </div>
            </div>
            <!-- ここまで右にいろいろ -->
        </div>

        <!-- ここからスレッド一覧の移動や書き込みなど -->
        <div class="row container">
            <div class="py-12 col-lg-12 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <br>
                        2. のとき，コメント入力欄<br>
                        1. or 3. のとき，「1 2 3 4 次へ」の様に表示<br>

                        いずれの場合もHxS Twitter
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- ここまでスレッド一覧の移動や書き込みなど -->

    </div>
</x-app-layout>
