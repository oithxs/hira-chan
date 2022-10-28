<!--
    PVランキング部分のファイイル
 -->
<div class="px-2">
    <div class="nav justify-content-end mb-1">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#dashboard_rankings_access_ranking" class="nav-link active" data-bs-toggle="tab">全体</a>
            </li>
            <li class="nav-item">
                <a href="#dashboard_rankings_weekly_access_ranking" class="nav-link" data-bs-toggle="tab">週間</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <!-- access ranking -->
        <div id="dashboard_rankings_access_ranking" class="tab-pane active">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                    <path
                        d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" />
                </svg>
                <div class="ml-4 text-lg leading-7 font-semibold">
                    アクセスランキング
                </div>
            </div>

            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <?php
                    $count = 1;
                ?>
                <table style="table-layout:fixed;width:100%;margin-bottom:0px;" class="table table-striped">
                    <thead class="table-info">
                        <tr class="text-nowrap">
                            <th style="width:13%;" class="text-center">{{ __("Access Ranking") }}</th>
                            <th style="width:70%;">{{__('Thread name')}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- スレッド名は「$row['name']」ではなく「$thread_name」 -->
                        @foreach($access_ranking as $row)
                        <?php
                            $thread_name = str_replace("&amp;", "&", $row['name']);
                            $thread_name = str_replace("&slash;", "/", $thread_name);
                            $thread_name = str_replace("&backSlash;", "\\", $thread_name);
                            $thread_name = str_replace("&hash;", "#", $thread_name);
                        ?>
                        <tr>
                            <td class="table-block">
                                <div class="tablecell-block">
                                    {{ $count++ }}
                                </div>
                            </td>

                            <td style="word-wrap:break-word;" class="font-semibold">
                                {{ $thread_name }}
                                <br>
                                <div class="text-gray-400">
                                    {{ __("Access count") }}：{{ $row["access_logs_count"] }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- weekly access ranking -->
        <div id="dashboard_rankings_weekly_access_ranking" class="tab-pane">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                    <path
                        d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" />
                </svg>
                <div class="ml-4 text-lg leading-7 font-semibold">
                    週間アクセスランキング
                </div>
            </div>

            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <?php
                    $count = 1;
                ?>
                <table style="table-layout:fixed;width:100%;margin-bottom:0px" class="table table-striped">
                    <thead class="table-info">
                        <tr class="text-nowrap">
                            <th style="width:13%;" class="text-center">{{ __("Access Ranking") }}</th>
                            <th style="width:70%;">{{__('Thread name')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- スレッド名は「$row['name']」ではなく「$thread_name」 -->
                        @foreach($weekly_access_ranking as $row)
                        <?php
                            $thread_name = str_replace("&amp;", "&", $row['name']);
                            $thread_name = str_replace("&slash;", "/", $thread_name);
                            $thread_name = str_replace("&backSlash;", "\\", $thread_name);
                            $thread_name = str_replace("&hash;", "#", $thread_name);
                        ?>
                        <tr>
                            <td class="table-block">
                                <div class="tablecell-block">
                                    {{ $count++ }}
                                </div>
                            </td>
                            <td style="word-wrap:break-word;" class="font-semibold">
                                {{ $thread_name }}
                                <br>
                                <div class="text-gray-400">
                                    {{ __("Access count") }}：{{ $row["access_logs_count"] }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
