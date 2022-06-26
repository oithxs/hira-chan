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

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __("Thread name") }}</th>

                <!-- ここからソートのためのリンク -->
                <th>
                    @if ($page == NULL)
                    <button onclick="location.href='/dashboard?sort=new_create'">
                        {{ __("Create time") }}
                    </button>
                    @else
                    <button onclick="location.href='/dashboard?page={{ $page }}&sort=new_create'">
                        {{ __("Create time") }}
                    </button>
                    @endif
                </th>
                <th>
                    @if ($page == NULL)
                    <button onclick="location.href='/dashboard?sort=access_count'">
                        {{ __("Access number") }}
                    </button>
                    @else
                    <button onclick="location.href='/dashboard?page={{ $page }}&sort=access_count'">
                        {{ __('Access number') }}
                    </button>
                    @endif
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
                <td>
                    <a href="/dashboard/thread/name={{ $tableInfo['thread_name'] }}&id={{ $tableInfo['thread_id'] }}"
                        class="text-decoration-none">
                        {{$tableInfo["thread_name"]}}
                    </a>
                </td>
                <td>{{ $tableInfo["created_at"] }}</td>
                <td>{{ $tableInfo['Access'] }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="dashboard_create_thread_btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">
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
<script src="{{ mix('js/app_jquery.js') }}"></script>
<!-- ここまでデザイン関係なし -->
