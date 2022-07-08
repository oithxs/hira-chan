<!--
    ここにいろいろ
 -->

<div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
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
                    <!-- スレッド名は「$row['thread_name']」ではなく「$title」 -->
                    @foreach($week_access_ranking as $row)
                    <?php
                    $title = str_replace("&amp;", "&", $row['thread_name']);
                    $title = str_replace("&slash;", "/", $title);
                    $title = str_replace("&backSlash;", "\\", $title);
                    $title = str_replace("&hash;", "#", $title);
                    ?>
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $row["access_count"] }}</td>
                        <td>{{ $title }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
