<div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CreateThread_Modal">
        {{ __('Create new thread') }}
    </button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __("Thread name") }}</th>
                <th>
                    <button onclick="location.href='/dashboard?sort=new_create'">
                        {{ __("Create time") }}
                    </button>
                </th>
                <th>
                    <button onclick="location.href='/dashboard?sort=access_count'">
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
                    <a href="/dashboard?thread_name={{
                            $tableName
                        }}&thread_id={{
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

<script>
    const url = "{{ url('') }}";
</script>
<script src="{{ mix('js/app_jquery.js') }}"></script>
