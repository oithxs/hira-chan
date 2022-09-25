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

<div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">

    <div class="mb-2">
        <label>スレッド検索</label>
        <input type="text" id="dashboard_threads_search_thread">

        <input type="button" value="全て表示" id="dashboard_threads_show_all_threads_button">

        <select id="dashboard_threads_category_type_select">
            <option value="">
                未選択
            </option>
            @foreach ($category_types as $category_type)
            <option value="{{ $category_type->category_type }}">
                {{ $category_type->category_type }}
            </option>
            @endforeach
        </select>

        <select id="dashboard_threads_category_select">
            <option value="">
                未選択
            </option>
            @foreach ($categorys as $category)
            <option value="{{ $category->category_name }}" data-val="{{ $category->category_type }}">
                {{ $category->category_name }}
            </option>
            @endforeach
        </select>
    </div>

    <table id="dashboard_threads_threads_table" class="table table-striped">
        <thead>
            <tr>
                <th>{{ __("Thread name") }}</th>

                <!-- ここからソートのためのリンク -->
                <th>
                    <button
                        onclick="location.href='dashboard?category={{ $category_name }}&page={{ $page }}&sort=new_create'">
                        {{ __("Create time") }}
                    </button>
                </th>
                <th>
                    <button
                        onclick="location.href='dashboard?category={{ $category_name }}&page={{ $page }}&sort=access_count'">
                        {{ __('Access number') }}
                    </button>
                </th>
                <!-- ここまでソートのためのリンク -->

            </tr>
        </thead>
        <tbody>
            <!-- スレッド名使う時は「$thread_name」 -->
            @foreach($threads as $thread)
            <?php
                if ($count < $min) {
                    $flag = 0;
                } else if ($max <= $count) {
                    break;
                } else {
                    $flag = 1;
                }

                $count++;
                $thread_name = str_replace('/', '&slash;', $thread['name']);
                $thread_name = str_replace('\\', '&backSlash;' , $thread_name);
                $thread_name = str_replace('#', '&hash;', $thread_name);
            ?>
            @if ($flag == 1)
            <tr>
                <td>
                    <a href="dashboard/thread/name={{ $thread_name }}&id={{ $thread['id'] }}"
                        class="text-decoration-none">
                        {{$thread["name"]}}
                    </a>
                </td>
                <td>{{ $thread["created_at"] }}</td>
                <td>{{ $thread['access_logs_count'] }}</td>
                <td class="hidden">{{ $thread['thread_category'] }}</td>
                <td class="hidden">{{ $thread['thread_category_type'] }}</td>
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
                        <label for="thread-name" class="" col-form-label>
                            {{ __("Thread name") }}
                        </label>
                        <input id="dashboard_create_thread_text" type="text" class="form-control">
                        <label for="thread-category" class="" col-form-label>
                            {{ __('Thread category') }}
                        </label>
                        <select id="dashboard_thread_category_select">
                            <option value="">選択して下さい</option>
                            @foreach ($categorys as $category)
                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button id="dashboard_create_thread_btn" type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">
                        Save changes
                    </button>
                </div>
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
