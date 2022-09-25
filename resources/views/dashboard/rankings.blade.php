<!--
    PVランキング部分のファイイル
 -->

<div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="#dashboard_rankings_access_ranking" class="nav-link active" data-bs-toggle="tab">アクセスランキング</a>
        </li>
        <li class="nav-item">
            <a href="#dashboard_rankings_weekly_access_ranking" class="nav-link" data-bs-toggle="tab">週間アクセスランキング</a>
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

        <div class="ml-12">
            <?php
            $count = 1;
            ?>
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __("Access Ranking") }}</th>
                            <th>{{ __("Access count") }}</th>
                            <th>{{__('Thread name')}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- スレッド名は「$row['thread_name']」ではなく「$title」 -->
                        @foreach($access_ranking as $row)
                        <?php
                        $title = str_replace("&amp;", "&", $row['name']);
                        $title = str_replace("&slash;", "/", $title);
                        $title = str_replace("&backSlash;", "\\", $title);
                        $title = str_replace("&hash;", "#", $title);
                        ?>
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $row["access_logs_count"] }}</td>
                            <td>{{ $title }}</td>
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
                週間アクセスランキング
            </div>
        </div>

        <div class="ml-12">
            <?php
            $count = 1;
            ?>
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __("Access Ranking") }}</th>
                            <th>{{ __("Access count") }}</th>
                            <th>{{__('Thread name')}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- スレッド名は「$row['name']」ではなく「$title」 -->
                        @foreach($weekly_access_ranking as $row)
                        <?php
                        $title = str_replace("&amp;", "&", $row['name']);
                        $title = str_replace("&slash;", "/", $title);
                        $title = str_replace("&backSlash;", "\\", $title);
                        $title = str_replace("&hash;", "#", $title);
                        ?>
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $row["access_logs_count"] }}</td>
                            <td>{{ $title }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </dev>
</dev>
