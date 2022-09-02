<!--
    PVランキング部分のファイイル
 -->

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


<dev class="tab-content">
    <!-- access ranking -->
    <dev id="dashboard_rankings_access_ranking" class="tab-pane active">
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

    <div class="">
        <?php
        $count = 1;
        ?>
        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            <table style="table-layout:fixed;width:100%;" class="table table-striped">


                <thead class="table-info">
                    <tr class="text-nowrap">
                        <th style="width:13%;" class="text-center">{{ __("Access Ranking") }}</th>
                        <th style="width:70%;">{{__('Thread name')}}</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- スレッド名は「$row['thread_name']」ではなく「$title」 -->
                    @foreach($access_ranking as $row)
                    <?php
                    $title = str_replace("&amp;", "&", $row['thread_name']);
                    $title = str_replace("&slash;", "/", $title);
                    $title = str_replace("&backSlash;", "\\", $title);
                    $title = str_replace("&hash;", "#", $title);
                    ?>
                    <tr>
                        <td class="text-center">{{ $count++ }}</td>
                        <td style="word-wrap:break-word;" class="font-semibold">{{ $title }}<br>
                            <div class="text-gray-400">
                                {{ __("Access count") }}：{{ $row["access_count"] }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </dev>

    <!-- weekly access ranking -->
    <dev id="dashboard_rankings_weekly_access_ranking" class="tab-pane">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                <path
                    d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" />
            </svg>

            <div class="ml-4 text-lg leading-7 font-semibold">
                週間ランキング
            </div>
        </div>

        <div class="">
            <?php
            $count = 1;
            ?>
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <table style="table-layout:fixed;width:100%;" class="table table-striped">
                    <thead class="table-info">
                        <tr class="text-nowrap">
                            <th style="width:13%;" class="text-center">{{ __("Access Ranking") }}</th>
                            <th style="width:70%;">{{__('Thread name')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- スレッド名は「$row['thread_name']」ではなく「$title」 -->
                        @foreach($weekly_access_ranking as $row)
                        <?php
                        $title = str_replace("&amp;", "&", $row['thread_name']);
                        $title = str_replace("&slash;", "/", $title);
                        $title = str_replace("&backSlash;", "\\", $title);
                        $title = str_replace("&hash;", "#", $title);
                        ?>
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td style="word-wrap:break-word;" class="font-semibold">{{ $title }}</br>
                                <div class="text-gray-400">
                                    {{ __("Access count") }}：{{ $row["access_count"] }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </dev>
</dev>
