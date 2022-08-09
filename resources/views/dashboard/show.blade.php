<!--
    ダッシュボードのファイル
    この場所に他ファイルを載せて表示
 -->

<x-app-layout>

    <!-- ここからカテゴリ別 -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            @livewire('dashboard.header')
        </h2>

        <script>
            var show_thread_messages_flag = 0;
        </script>
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
                        @if ($main_type == 'threads')
                        @livewire('dashboard.threads')
                        @elseif ($main_type == 'messages')
                        @livewire('dashboard.messages')
                        <!-- elseif (カテゴリ別) -->
                        @endif
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
            <div class="py-12 col-lg-8 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        @if ($main_type == 'threads')
                        @livewire('dashboard.select-thread-pages')
                        @elseif ($main_type == 'messages')
                        @livewire('dashboard.send-comment')
                        <!-- elseif (カテゴリ別) -->
                        @endif
                    </div>
                </div>
            </div>

            <div class="py-12 col-lg-4 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <!--
                            ここからTwitterの表示
                            配置のイメージがつかめなかったので応急処置的にここに書いています
                        -->
                        @if (Auth::user()->thema == 0)
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
        <!-- ここまでスレッド一覧の移動や書き込みなど -->

    </div>
</x-app-layout>
