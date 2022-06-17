<!--
    トップページのファイル
    {{ __('〇〇') }}は，resources/lang/ja.jsonとリンク
-->

<x-app-layout>
    <!-- ここからデザイン -->

    <!-- ここからタイトル（ページのヘッダでなはい） -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Top page") }}
        </h2>
    </x-slot>
    <!-- ここまでタイトル（ページのヘッダではない） -->

    <div class="container">
        <div class="row">
            <div class="py-12 col-lg-8 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <meta charset="utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1" />
                        <!-- Bootstrap CSS -->
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
                            rel="stylesheet"
                            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
                            crossorigin="anonymous" />

                        <div></div>

                        <!--　ここから掲示板へのリンクとコメント -->
                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-card-heading" viewBox="0 0 16 16">
                                    <path
                                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                    <path
                                        d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <a href="{{ url('hub') }}"
                                        class="underline text-gray-900 text-decoration-none">掲示板</a>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    HxSコンピュータ部が提供する掲示板です．利用には学内ネットワーク・ログインが必要です．
                                </div>
                            </div>
                        </div>
                        <!-- ここまで掲示板へのリンクとコメント -->

                        <!-- ここからHxS Twitterへのリンクとコメント -->
                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <a href="https://twitter.com/hxs_" target="_blank"
                                        class="underline text-gray-900 text-decoration-none">Twitter</a>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    大阪工業大学
                                    HxSコンピュータ部の非公式アカウントです。ハードウェア（Hardware）とソフトウェア（Software）の両面からスキルアップを図る事を目標とした部活です。活動内容・イベント宣伝等をつぶやきます。
                                </div>
                            </div>
                        </div>
                        <!-- ここまでHxS Twitterへのリンクとコメント -->

                        <!-- ここからアクセスランキング -->
                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" />
                                </svg>

                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    アクセスランキング
                                </div>
                            </div>

                            <div class="ml-12">
                                <?php
                                $count = 1;
                                ?>
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    {{ __("Access Ranking") }}
                                                </th>
                                                <td>
                                                    {{ __("Access count") }}
                                                </td>
                                                <td>{{ __("Thread name") }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- スレッド名は「$row['thread_name']」ではなく「$title」 -->
                                            @foreach($access_ranking as $row)
                                            <?php
                                            $title = str_replace("&amp;", "&", $row['thread_name']);
                                            $title = str_replace("&slash;", "/", $title);
                                            $title = str_replace("&backSlash;", "\\", $title);
                                            $title = str_replace("&hash;", "#", $title);
                                            ?>
                                            <tr>
                                                <th>{{ $count++ }}</th>
                                                <td>
                                                    {{ $row["access_count"] }}
                                                </td>
                                                <td>{{ $title }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- ここまでアクセスランキング -->

                        <!-- ここからHxS GitHubへのリンクとコメント -->
                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-github" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                                </svg>

                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <a href="https://github.com/oithxs" target="_blank"
                                        class="underline text-gray-900 text-decoration-none">Github</a>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    大阪工業大学情報科学部HxSコンピュータ部の組織アカウントです。
                                </div>
                            </div>
                        </div>
                        <!-- ここまでHxS GitHubへのリンクとコメント -->

                    </div>
                </div>
            </div>

            <!-- ここからTwitterの表示 -->
            <div class="py-12 col-lg-4 col-md-12 text-center">
                <a class="twitter-timeline" data-chrome="nofooter" data-width="400" data-height="550" data-theme="light"
                    href="https://twitter.com/hxs_?ref_src=twsrc%5Etfw">Tweets by hxs_</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
            <!-- ここまでTwitterの表示 -->
        </div>
    </div>
    <!-- ここまでデザイン -->
</x-app-layout>
