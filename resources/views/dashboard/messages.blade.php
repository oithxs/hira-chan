<!-- ここからデザイン関係なし -->
<script>
    const table = "{{ $thread_name }}";
    const thread_id = "{{ $thread_id }}";
    var max_message_id = 0;
</script>

<script>
    function likes(message_id) {
        var access = "";

        $('#js_dashboard_Get_allRow_button_' + message_id).prop('disabled', true);
        $('#js_dashboard_Get_allRow_button_' + message_id).toggleClass('btn-light');
        $('#js_dashboard_Get_allRow_button_' + message_id).toggleClass('btn-dark');

        if ($('#js_dashboard_Get_allRow_button_' + message_id).hasClass('btn-dark')) {
            access = '/jQuery.ajax/like';
        } else {
            access = '/jQuery.ajax/unlike';
        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: url + access,
            data: {
                thread_id: thread_id,
                message_id: message_id,
            },
        }).done(function () {
            $('#js_dashboard_Get_allRow_button_' + message_id).prop('disabled', false);
        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(textStatus);
            console.log(errorThrown.message);
        });
    }
</script>
<!-- ここまでデザイン関係なし -->

<!-- ここからスレッドが存在したとき -->
@if ($result == 1)
<div class="row">

    <!-- ここから非同期通信で掲示板の表示 -->
    <div id="dashboard_displayArea" class="col-sm-12 col-xs-12" style="
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

<!-- ここからデザイン関係なし -->
<script>
    const url = "{{ url('') }}";
    show_thread_messages_flag = 1;
</script>
<script src="{{ asset('js/app_jquery.js') }}"></script>
<!-- ここまでデザイン関係なし -->
