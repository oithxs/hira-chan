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
        <a href="/dashboard">トップページへ</a>
        <form id="dashboard_sendMessage_form">
            <div class="mb-2">
                <label class="form-label">コメント</label>
                <textarea class="form-control" id="dashboard_message_textarea" rows="4"></textarea>
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

    <!-- ここから非同期通信で掲示板の表示 -->
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

<script>
    const url = "{{ url('') }}";
</script>
<script src="{{ mix('js/app_jquery.js') }}"></script>
