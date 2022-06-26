<!--
    トップページのファイル
    このページはログインユーザ全てに表示されます
    {{ __('〇〇') }}は，resources/lang/ja.jsonとリンク
-->

<x-app-layout>
    <!-- ここからデザイン -->

    <!-- ここからタイトル（ページのヘッダでなはい） -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __("Top page") }}
        </h2>
    </x-slot>
    <!-- ここまでタイトル（ページのヘッダではない） -->

    <div class="container">
        <div class="row">
            <!-- 左側のフレーム -->
            <div class="py-12 col-lg-2 col-md-12 text-center">
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
                            大阪工業大学
                            情報科学部
                            HxSコンピュータ部
                            組織アカウント
                        </div>
                    </div>
                </div>
                <!-- ここまでHxS GitHubへのリンクとコメント -->

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
                            HxSコンピュータ部
                            非公式アカウント
                        </div>
                    </div>
                </div>
                <!-- ここまでHxS Twitterへのリンクとコメント -->

            </div>
            <!-- ここまでが左側のフレーム -->

            <div class="py-12 col-lg-7 col-md-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                        <!-- ここからデザイン関係なし -->
                        <!-- データ処理で使う変数 -->
                        <script>
                            const url = "{{ url('') }}";
                        </script>

                        <!-- jQuery -->
                        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
                        <!-- ここまでデザイン関係なし -->

                        <div></div>



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
                                                <th>{{ __("Access Ranking") }}</th>
                                                <th>{{ __("Access count") }}</th>
                                                <th>{{__('Thread name')}}</td>
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
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $row["access_count"] }}</td>
                                                <td>{{ $title }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- ここまでアクセスランキング -->

                        <!-- ここから掲示板へのリンク -->
                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">

                            @if ($type == 'top')
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __("Thread name") }}</th>
                                        <th>
                                            <button onclick="location.href='/test/dashboard?sort=new_create'">
                                                {{ __("Create time") }}
                                            </button>
                                        </th>
                                        <th>
                                            <button onclick="location.href='/test/dashboard?sort=access_count'">
                                                {{ __("Access number") }}
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- スレッド名使う時は「$tableName」 -->
                                    @foreach($tables as $tableInfo)
                                    <?php
										$tableName = str_replace('/', '&slash;', $tableInfo['thread_name']);
										$tableName = str_replace('\\', '&backSlash;' , $tableName);
										$tableName = str_replace('#', '&hash;', $tableName);
									?>
                                    <tr>
                                        <td>
                                            <a href="/test/dashboard/thread_name={{
                                                    $tableName
                                                }}/id={{
                                                    $tableInfo['thread_id']
                                                }}" class="text-decoration-none">{{
                                                $tableInfo["thread_name"]
                                                }}</a>
                                        </td>
                                        <td>{{ $tableInfo["created_at"] }}</td>
                                        <td>{{ $tableInfo['Access'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </dvi>

                            @elseif ($type == 'thread')
                            <!-- ここからデザイン関係なし -->
                            <script>
                                const table = "{{ $thread_name }}";
                                const thread_id = "{{ $thread_id }}";
                            </script>

                            <script>
                                function likes(message_id, user_like) {
                                    $.ajaxSetup({
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content"),
                                        },
                                    });

                                    if (user_like == 1) {
                                        $.ajax({
                                            type: "POST",
                                            url: url + "/jQuery.ajax/unlike",
                                            data: {
                                                thread_id: thread_id,
                                                message_id: message_id,
                                            },
                                        })
                                            .done(function () { })
                                            .fail(function (
                                                XMLHttpRequest,
                                                textStatus,
                                                errorThrown
                                            ) {
                                                console.log(XMLHttpRequest.status);
                                                console.log(textStatus);
                                                console.log(errorThrown.message);
                                            });
                                    } else {
                                        $.ajax({
                                            type: "POST",
                                            url: url + "/jQuery.ajax/like",
                                            data: {
                                                thread_id: thread_id,
                                                message_id: message_id,
                                            },
                                        })
                                            .done(function () { })
                                            .fail(function (
                                                XMLHttpRequest,
                                                textStatus,
                                                errorThrown
                                            ) {
                                                console.log(XMLHttpRequest.status);
                                                console.log(textStatus);
                                                console.log(errorThrown.message);
                                            });
                                    }
                                }
                            </script>
                            <!-- ここまでデザイン関係なし -->

                            <!-- ここからスレッドが存在したとき -->
                            @if ($result == 1)
                            <div class="row">
                                <hr />
                                <div class="col-sm-4 col-xs-12">
                                    <a href="/test/dashboard">トップページへ</a>
                                    <form id="dashboard_sendMessage_form">
                                        <div class="mb-2">
                                            <label class="form-label">コメント</label>
                                            <textarea class="form-control" id="dashboard_message_textarea"
                                                rows="4"></textarea>
                                            <br />
                                            <div class="form-text">
                                                入力欄の右下にマウスカーソルを移動させると，高さを変えることができます
                                            </div>
                                            <div id="dashboard_sendAlertArea"></div>
                                        </div>
                                    </form>
                                    <button id="dashboard_sendMessage_btn" class="btn btn-primary">
                                        {{ __("Write forum") }}
                                    </button>
                                </div>

                                <!--
                                ここから非同期通信で掲示板の表示
                                表示はresources/js/GetallRow.js
                                -->
                                <div id="dashboard_displayArea" class="col-sm-8 col-xs-12" style="
                                    height: 70vh;
                                    width: 100;
                                    overflow-y: scroll;
                                    overflow-x: hidden;
                                "></div>
                                <!-- ここまで非同期通信で掲示板の表示 -->

                            </div>
                            <!-- ここまでスレッドが存在したとき -->

                            <!-- ここからスレッドが存在しなかったとき -->
                            @else
                            <div class="mt-4">
                                <h1 class="text-danger">※スレッドが存在しません</h1>
                            </div>
                            <br />
                            <br />
                            @endif
                            <!-- ここまでスレッドが存在しなかったとき -->
                            @endif
                        </div>
                        <!-- ここまで掲示板へのリンク -->
                    </div>
                </div>



                <!-- ここからスレッド作成時に表示されるモーダル -->
                <div class="modal fade" id="CreateThread_Modal" tabindex="-1" aria-labelledby="CreateThreadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form id="dashboard_create_thread_form">
                                    <label for="thread-name" class="" col-form-label>
                                        {{ __("Thread name") }}
                                    </label>
                                    <input id="dashboard_create_thread_text" type="text" class="form-control">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <x-jet-danger-button id="dashboard_create_thread_btn" type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">
                                    Save changes
                                </x-jet-danger-button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ここまでスレッド作成時に表示されるモーダル -->

                <!-- Bootstrap JS -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                    crossorigin="anonymous"></script>

                <!-- ここからデザイン関係なし -->
                <script src="{{ mix('js/app_jquery.js') }}"></script>
                <!-- ここまでデザイン関係なし -->
            </div>

            <!-- ここからTwitterの表示 -->
            <div class="py-12 col-lg-3 col-md-12 text-center">
                @if (Auth::user()->thema == 0)
                <a class="twitter-timeline" data-chrome="nofooter" data-width="400" data-height="550"
                    data-theme="light" href="https://twitter.com/hxs_?ref_src=twsrc%5Etfw">Tweets by hxs_</a>
                @elseif (Auth::user()->thema == 1)
                <a class="twitter-timeline" data-chrome="nofooter" data-width="400" data-height="550"
                    data-theme="dark" href="https://twitter.com/hxs_?ref_src=twsrc%5Etfw">Tweets by hxs_</a>
                @endif

                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
            <!-- ここまでTwitterの表示 -->
        </div>
        <!-- ここまでデザイン -->
</x-app-layout>
