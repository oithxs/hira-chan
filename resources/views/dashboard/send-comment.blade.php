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

<script>
    const url = "{{ url('') }}";
</script>
<script src="{{ mix('js/app_jquery.js') }}"></script>
