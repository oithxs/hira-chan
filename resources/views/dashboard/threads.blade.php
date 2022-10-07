<!--
    スレッド一覧を表示する部分
    php部分で1ページに何個スレッドを表示させるかを決められる
    1ページに表示するスレッド数を変えた際はここも変更する
 -->

<?php
 $count = 0;
 $flag = 0;
 if ($page == NULL) {
     $page = 1;
 }

 $max = $page * 10;
 $min = ($page - 1) * 10;
?>

<!-- 検索モーダル -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning bg-opacity-25">
                <h5 class="modal-title" id="exampleModalLabel">スレッド検索</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <label>スレッド名</label>
                <input type="text" id="dashboard_threads_search_thread" style="width:100%">

                <label class="mt-2">カテゴリー</label>
                <br>
                <input type="button" value="全て表示" id="dashboard_threads_show_all_threads_button">

                <select id="dashboard_threads_category_type_select">
                    <option value="">全て</option>
                    @foreach ($category_types as $category_type)
                    <option value="{{ $category_type->category_type }}">
                        {{ $category_type->category_type }}
                    </option>
                    @endforeach
                </select>

                <select id="dashboard_threads_category_select">
                    <option value="">未選択</option>
                    @foreach ($categorys as $category)
                    <option value="{{ $category->category_name }}" data-val="{{ $category->category_type }}">
                        {{ $category->category_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary bg-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<table id="dashboard_threads_threads_table" style="table-layout:fixed;width:100%;"
    class="table shadow-xl table table-hover">
    <thead class="table-info text-nowrap">
        <tr>
            <!-- ここからソートのためのリンク -->
            <th>
                <div class="hidden sm:flex sm:items-center">
                    <div class="text-lg leading-7 font-semibold">
                        <button
                            onclick="location.href='/dashboard?category={{ $category_name }}&page={{ $page }}&sort=access_count'">
                        </button>
                        {{ __("Thread name") }}

                        <button
                            onclick="location.href='/dashboard?category={{ $category_name }}&page={{ $page }}&sort=new_create'">
                        </button>
                    </div>
                    <div class="text-lg text-right leading-7 font-semibold ms-auto">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-default justify-continent-md-end" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </th>
            <!-- ここまでソートのためのリンク -->
        </tr>
    </thead>
    <tbody>
        <!-- スレッド名使う時は「$tableName」 -->
        @foreach($tables as $tableInfo)
        <?php
            if ($count < $min) {
                $flag = 0;
            } else if ($max <= $count) {
                break;
            } else {
                $flag = 1;
            }

            $count++;
            $tableName = str_replace('/', '&slash;', $tableInfo['thread_name']);
            $tableName = str_replace('\\', '&backSlash;' , $tableName);
            $tableName = str_replace('#', '&hash;', $tableName);
        ?>
        @if ($flag == 1)
        <tr>
            <td style="word-wrap:break-word;">
                <a href="/dashboard/thread/name={{ $tableInfo['thread_name'] }}&id={{ $tableInfo['thread_id'] }}"
                    class="font-semibold text-center">
                    {{$tableInfo["thread_name"]}}
                </a>
                <br>

                <div class="text-gray-400">
                    {{ $tableInfo["created_at"] }}
                </div>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

<!-- ここからスレッド作成時に表示されるモーダル -->
<div class="modal fade" id="CreateThread_Modal" tabindex="-1" aria-labelledby="CreateThreadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="dashboard_create_thread_form">
                    <label for="thread-name" col-form-label>{{ __("Thread name") }}</label>
                    <input id="dashboard_create_thread_text" type="text" class="form-control">
                    <label for="thread-category" class="mt-2" col-form-label>{{ __('Thread category') }}</label>
                    <br>
                    <select id="dashboard_thread_category_select">
                        <option value="">選択して下さい</option>
                        @foreach ($categorys as $category)
                        <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="dashboard_create_thread_btn" type="button" class="btn btn-primary bg-primary"
                    data-bs-dismiss="modal">
                    Save changes
                </button>
            </div>
        </div>
    </div>
    <!-- ここまでスレッド作成時に表示されるモーダル -->

    <!-- ここからデザイン関係なし -->
    <script>
        const url = "{{ url('') }}";
    </script>
    <script src="{{ asset('js/app_jquery.js') }}"></script>
    <!-- ここまでデザイン関係なし -->
</div>
