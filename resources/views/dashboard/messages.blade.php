<!--
    スレッドの書き込みを表示するページ
 -->

<!-- ここからデザイン関係なし -->
<script>
    const table = "{{ $thread_name }}";
    const thread_id = "{{ $thread_id }}";
    var max_message_id = 0;
</script>

@if (Auth::check() && Auth::user()->hasVerifiedEmail())
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
        }).done(function (data) {
            $('#js_dashboard_Get_allRow_button_' + message_id).prop('disabled', false);
            $('#js_dashboard_Get_allRow_dev_' + message_id).html(data);
        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(textStatus);
            console.log(errorThrown.message);
        });
    }
</script>
@else
<script>
    function likes() {
        window.location.href = "{{ route('login') }}";
    }
</script>
@endif
<!-- ここまでデザイン関係なし -->

<!-- ここからスレッドが存在したとき -->
@if ($result == 1)
<div class="overflow-hidden sm:rounded-lg">
    <div class="p-3 border-t border-gray-200 md:border-t-0 md:border-l bg-primary bg-opacity-25 ">
        <div class="hidden sm:flex sm:items-center">
            <div class="text-lg leading-7 font-semibold">
                <div class="items-right">
                    <x-jet-nav-link href="{{ route('dashboard') }}" active="request()->routeIs('dashboard')"
                        class="text-nowrap me-4 mb-2">
                        ＜戻る
                    </x-jet-nav-link>
                </div>
            </div>
            <div class="text-lg leading-7 font-semibold mb-2">
                {{ $thread_name }}
            </div>
        </div>
    </div>

    <!-- ここから非同期通信で掲示板の表示 -->
    <div class="row px-3 bg-primary bg-opacity-25">
        <div id="dashboard_displayArea" class="col-sm-12 col-xs-12 bg-secondry" style="
                                    height: 100vh;
                                    width: 50;
                                    overflow-y: scroll;
                                    overflow-x: hidde;">
        </div>
    </div>
    <!-- ここまで非同期通信で掲示板の表示 -->
</div>
<!-- ここまでスレッドが存在したとき -->

<!-- ここからスレッドが存在しなかったとき -->
@else
<div class="mt-4">
    <h1 class="text-danger">※スレッドが存在しません</h1>
</div>
<br>
<br>
@endif
<!-- ここまでスレッドが存在しなかったとき -->

<!-- ここからデザイン関係なし -->
<script>
    const url = "{{ url('') }}";
    show_thread_messages_flag = 1;
</script>
<script src="{{ asset('js/app_jquery.js') }}"></script>
<!-- ここまでデザイン関係なし -->
