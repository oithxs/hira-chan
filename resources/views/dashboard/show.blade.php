<!--
    ダッシュボードのファイル
    この場所に他ファイルを載せて表示
 -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            <!-- ここからカテゴリ別 -->
            @livewire('dashboard.header')
            <!-- ここまでカテゴリ別 -->
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="py-12 col-lg-2 col-md-12">
                <!-- ここからスレッド一覧の表示（スレッド一覧表示時） -->
                @if ($main_type == 'threads')
                @livewire('dashboard.threads')
                <!-- ここまでスレッド一覧の表示（スレッド一覧表示時） -->

                <!-- ここからアクセスランキング（スレッドアクセス時） -->
                @elseif ($main_type == 'messages')
                @livewire('dashboard.rankings')
                <!-- ここまでアクセスランキング（スレッドアクセス時） -->
                @endif
            </div>

            <div class="py-12 col-lg-7 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                        <!-- ここからアクセスラングキング（スレッド一覧表示時） -->
                        @if ($main_type == 'threads')
                        @livewire('dashboard.rankings')
                        <!-- ここまでアクセスランキング（スレッド一覧表示時） -->

                        <!-- ここからスレッド表示（スレッドアクセス時） -->
                        @elseif ($main_type == 'messages')
                        @livewire('dashboard.messages')
                        <!-- ここからスレッド表示（スレッドアクセス時） -->
                        @endif
                    </div>
                </div>
            </div>

            <div class="py-12 col-lg-3 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                    <!-- ここからスレッド一覧の切り替え（スレッド一覧表示時） -->
                    @if ($main_type == 'threads')
                    @livewire('dashboard.select-thread-pages')
                    <!-- ここまでスレッド一覧の切り替え（スレッド一覧表示時） -->

                    <!-- ここからスレッドに書き込み（スレッドアクセス時） -->
                    @elseif ($main_type == 'messages')
                    @livewire('dashboard.send-comment')
                    <!-- ここまでスレッドに書き込み（スレッドアクセス時） -->
                    @endif
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                    <!-- いろいろ部分 -->
                    @livewire('dashboard.various')
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                    <!-- ここからTwitterの表示 -->
                    @if (!Auth::check() || Auth::user()->thema == 0)
                    <a class="twitter-timeline" data-chrome="nofooter" data-width="400" data-height="550"
                        data-theme="light" href="https://twitter.com/hxs_?ref_src=twsrc%5Etfw">Tweets by
                        hxs_</a>
                    @elseif (Auth::user()->thema == 1)
                    <a class="twitter-timeline" data-chrome="nofooter" data-width="400" data-height="550"
                        data-theme="dark" href="https://twitter.com/hxs_?ref_src=twsrc%5Etfw">Tweets by hxs_</a>
                    @endif
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    <!-- ここまでTwitterの表示 -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
