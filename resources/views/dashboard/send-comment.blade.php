<!--
    スレッドへ書き込むための部分
 -->

<div class="col-sm-4 col-xs-12">
    <a href="/dashboard">トップページへ</a>
    <form id="dashboard_sendMessage_form" enctype="multipart/form-data">
        <div class="mb-2">
            <label class="form-label">コメント</label>
            <textarea class="form-control" id="dashboard_message_textarea" rows="4"></textarea>
            <br />
            <input type="file" id="dashboard_send_comment_upload_img">
            <img src="" id="dashboard_send_commnet_img_preview" class="img_preview">
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

<!-- ここからデザイン関係なし -->
<script>
    const url = "{{ url('') }}";
</script>
<script src="{{ mix('js/app_jquery.js') }}"></script>
<!-- ここまでデザイン関係なし -->
