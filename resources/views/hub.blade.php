<!--
    掲示板ハブのファイル（掲示板へのリンクがはってるところ）
    {{ __('〇〇') }}は，resources/lang/ja.jsonとリンク
-->

<x-app-layout>
    <!-- ここからデザイン -->

    <!-- ここからタイトル（ページのヘッダでなはい） -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Forum Hub") }}
        </h2>
    </x-slot>
    <!-- ここまでタイトル（ページのヘッダでなはい） -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">

                <head>
                    <meta charset="utf-8" />
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <meta name="viewport" content="width=device-width, initial-scale=1" />
                </head>

                <body>
                    <div class="container-fluid">
                        <form id="hub_CreateThread_form" class="col-sm">
                            <div class="mb-2">
                                <label class="form-label">スレッド名</label>
                                <input class="form-control" type="text" id="hub_new_threadName_text" />
                            </div>
                            <button id="hub_create_thread_btn" class="btn btn-primary">
                                {{ __("Create new thread") }}
                            </button>
                        </form>

                        <br /><br />

                        <!-- ここから管理者のみに表示 -->
                        @if (Auth::user()->is_admin == 1)
                        <form id="hub_thread_actions_form">
                            <label class="form-label">対象：スレッドID</label>
                            <input id="hub_thread_id_text" class="form-control" type="text" />
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        操作
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <!-- actions -->
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#hub_DeleteThread_Modal">
                                                {{ __("Delete") }}
                                            </button>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#hub_EditThread_Modal">
                                                {{ __("Edit") }}
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </form>
                        @endif
                        <!-- ここまで管理者のみに表示 -->

                        <br />
                        <br />

                        <div>
                            <!-- ここから掲示板へのリンク -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __("Thread name") }}</th>
                                        <td>{{ __("Create time") }}</td>

                                        <!-- ここから管理者のみに表示 -->
                                        @if (Auth::user()->is_admin == 1)
                                        <td>
                                            {{ __("Thread ID") }}
                                        </td>
                                        @endif
                                        <!-- ここまで管理者のみに表示 -->

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
                                        <th>
                                            <a href="hub/thread_name={{
                                                    $tableName
                                                }}/id={{
                                                    $tableInfo['thread_id']
                                                }}" class="text-decoration-none">{{
                                                $tableInfo["thread_name"]
                                                }}</a>
                                        </th>
                                        <td>
                                            {{ $tableInfo["created_at"] }}
                                        </td>

                                        <!-- ここから管理者のみに表示 -->
                                        @if (Auth::user()->is_admin == 1)
                                        <td>
                                            {{ $tableInfo["thread_id"] }}
                                        </td>
                                        @endif
                                        <!-- ここまで管理者のみに表示 -->

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- ここまで掲示板へのリンク -->
                        </div>
                    </div>

                    <!-- ここから管理者のみに表示 -->
                    <!-- Modal -->
                    @if (Auth::user()->is_admin == 1)
                    <div class="modal fade" id="hub_DeleteThread_Modal" tabindex="-1"
                        aria-labelledby="DeleteThreadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    {{ __("Do you really want to delete it?") }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button id="hub_delete_thread_btn" type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">
                                        Save changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="hub_EditThread_Modal" tabindex="-1"
                        aria-labelledby="EditThreadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    {{ __("Edit thread") }}
                                </div>
                                <div class="modal-body">
                                    <form id="hub_edit_thread_form">
                                        <div class="mb-3">
                                            <label for="thread-name" class="col-form-label">
                                                {{ __("Thread name")}}
                                            </label>
                                            <input id="hub_edit_ThreadName_text" type="text" class="form-control" />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button id="hub_edit_thread_btn" type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">
                                        Save changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- ここまで管理者のみに表示 -->

                    <div>
                        <!-- Bootstrap用JavaScript -->
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                            crossorigin="anonymous"></script>

                        <!-- ここからデザイン関係なし -->
                        <!-- jQuery -->
                        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>

                        <!-- グローバル変数 -->
                        <script>
                            const url = "{{ $url }}";
                        </script>

                        <!-- others -->
                        <script src="{{ mix('js/app_jquery.js') }}"></script>
                        <!-- ここまでデザイン関係なし -->
                    </div>
                </body>
            </div>
        </div>
    </div>
    <!-- ここまでデザイン -->
</x-app-layout>
