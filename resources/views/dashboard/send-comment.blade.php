<!--
    スレッドへ書き込むための部分
 -->

@if (Auth::check() && Auth::user()->hasVerifiedEmail())
<form id="dashboard_sendMessage_form" enctype="multipart/form-data">
    <div class="width: 100% mb-2">
        <div class="row">
            <div class="col-8">
                <a id="dashboard_send_comment_reply_source" href="#!">
                    <input class="form-control" type="text" id="dashboard_send_comment_reply_disabled_text" disabled>
                </a>
            </div>
            <div class="col-4">
                <a id="dashboard_send_comment_replay_clear" href="#!">クリア</a>
            </div>
        </div>

        <label id="dashboard_send_comment_label" class="form-label mt-2">コメント</label>
        <textarea class="form-control" id="dashboard_message_textarea" rows="4"></textarea>

        <div class="form-text">
            入力欄の右下にマウスカーソルを移動させると，高さを変えることができます
        </div>

        <img id="dashboard_send_commnet_img_preview" class="img_preview">
        <label>
            <span class="btn btn-secondary mb-2">
                ファイル選択
                <input type="file" style="display:none" id="dashboard_send_comment_upload_img">
            </span>
        </label>

        <div id="dashboard_sendAlertArea"></div>

        <button id="dashboard_sendMessage_btn" class="btn btn-primary">
            {{ __("Write forum") }}
        </button>
    </div>
</form>
@else
<div class="mb-3 p-3 bg-warning bg-opacity-25 text-center rounded-pill">
    <a href="{{ route('login') }}">スレッドへ書き込む</a>
</div>
@endif

<!-- ここからデザイン関係なし -->
@if (Auth::check() && Auth::user()->hasVerifiedEmail())
<script>
    const url = "{{ url('') }}";
</script>
<script>
    function reply(message_id) {
        $('#dashboard_send_comment_reply_disabled_text').val(">>> " + message_id);
        $('#dashboard_send_comment_reply_source').attr('href', '#thread_message_id_' + message_id);
    }
</script>
<script src="{{ asset('js/app_jquery.js') }}"></script>
@endif
<!-- ここまでデザイン関係なし -->
