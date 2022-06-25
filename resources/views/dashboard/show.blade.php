<!--
    ダッシュボードのファイル（予定）
    他ファイルと組み合わせて表示予定
    現在は大体の構成
 -->

<x-app-layout>

    <!-- ここからカテゴリ別 -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            @livewire('dashboard.header')
        </h2>
    </x-slot>
    <!-- ここまでカテゴリ別 -->


    <div class="container">

        <!-- ここからPVランキング -->
        <div class="row container">
            <div class="py-12 col-lg-12 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        @livewire('dashboard.rankings')
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
                        @livewire('dashboard.main-display')
                    </div>
                </div>
            </div>
            <!-- ここまでメインの表示欄 -->

            <!-- ここから右にいろいろ -->
            <div class="py-12 col-lg-4 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        @livewire('dashboard.various')
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
                        @livewire('dashboard.display-support')
                    </div>
                </div>
            </div>
        </div>
        <!-- ここまでスレッド一覧の移動や書き込みなど -->

    </div>
</x-app-layout>
