<!--
    マイページのファイル（ログイン後右上「ユーザ名」->「マイページ」で移動）
    {{ __('〇〇') }}は，resources/lang/ja.jsonとリンク
-->

<x-app-layout>
    <!-- ここからデザイン（いいねが押された数などを取得予定・取得していないので今は放置） -->

    <!-- ここからタイトル（ページのヘッダではない） -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('My page')}}
        </h2>
    </x-slot>
    <!-- ここまでタイトル（ページのヘッダではない） -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <meta name="csrf-token" content="{{ csrf_token() }}" />

                <p>ページテーマ</p>
                <select id="page_thema">
                    <option value="">選択して下さい</option>
                    <option value="default">デフォルト</option>
                    <option value="dark">ダークテーマ</option>
                </select>

                <!-- ここからテーマ取得例（不要になり次第削除） -->
                <br>
                <br>
                @if (Auth::user()->thema == 0)
                デフォルトテーマ
                @elseif (Auth::user()->thema == 1)
                ダークテーマ
                @endif
                <!-- ここまでテーマ取得例（不要になり次第削除） -->

                <!-- デザイン関係なし -->
                <!-- jQuery -->
                <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>

                <script src="{{ mix('js/app_jquery.js') }}"></script>
                <script>
                    const url = "{{ url('/') }}";
                </script>
                <!-- デザイン関係なし -->

            </div>
        </div>
    </div>
    <!-- ここまでデザイン -->
</x-app-layout>
