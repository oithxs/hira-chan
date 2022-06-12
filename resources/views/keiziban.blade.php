<x-app-layout>
    <x-slot name="header">
        <?php
        $title = str_replace("&slash;", "/", $thread_name);
        $title = str_replace("&backSlash;", "\\", $title);
        $title = str_replace("&hash;", "#", $title);
        ?>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- my area begin -->

                <head>
                    <meta charset="utf-8" />
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <meta
                        name="viewport"
                        content="width=device-width, initial-scale=1"
                    />
                    <!-- Bootstrap CSS -->
                    <link
                        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
                        rel="stylesheet"
                        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
                        crossorigin="anonymous"
                    />

                    <!-- jQuery -->
                    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>

                    <!-- グローバル変数 -->
                    <script>
                        const url = "{{ $url }}";
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
                                    .done(function () {})
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
                                    .done(function () {})
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
                </head>

                <body>
                    <div class="container-fluid">
                        <div>
                            <a href="{{ url('/hub') }}">{{ __("Go hub") }}</a>
                            <p class="h2">{{ $username }}</p>
                        </div>
                        <br />
                        <br />

                        @if ($result == 1)
                        <div class="row">
                            <hr />
                            <div class="col-sm-4 col-xs-12">
                                <form id="sendMessage">
                                    <div class="mb-2">
                                        <label class="form-label"
                                            >コメント</label
                                        >
                                        <textarea
                                            class="form-control"
                                            name="message"
                                            rows="4"
                                        ></textarea>
                                        <br />
                                        <div class="form-text">
                                            入力欄の右下にマウスカーソルを移動させると，高さを変えることができます
                                        </div>
                                        <div id="sendAlertArea"></div>
                                    </div>
                                </form>
                                <button
                                    id="sendMessageBtn"
                                    class="btn btn-primary"
                                >
                                    {{ __("Write forum") }}
                                </button>
                            </div>

                            <div
                                id="displayArea"
                                class="col-sm-8 col-xs-12"
                                style="
                                    height: 70vh;
                                    width: 100;
                                    overflow-y: scroll;
                                    overflow-x: hidden;
                                "
                            ></div>
                        </div>
                        @else
                        <div class="mt-4">
                            <h1 class="text-danger">※スレッドが存在しません</h1>
                        </div>
                        <br />
                        <br />
                        @endif
                    </div>

                    <div>
                        <!-- Bootstrap用JavaScript -->
                        <script
                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                            crossorigin="anonymous"
                        ></script>

                        <!-- others -->
                        @if ($result == 1)
                        <script src="{{ mix('js/app_jquery.js') }}"></script>
                        @endif
                    </div>
                </body>
                <!-- my area end -->
            </div>
        </div>
    </div>
</x-app-layout>
