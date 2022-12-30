<!--
    ヘッダ部分
    選択することでカテゴリごとにスレッド表示
 -->

<div>
    <table style="margin-bottom:0px" class="table table-borderless">
        <thead>
            <tr>
                @foreach ($thread_primary_categorys as $thread_primary_category)
                <th class="col-md-1">
                    <select onChange="location.href=value;">
                        <option>{{ $thread_primary_category->name }}</option>
                        @foreach ($thread_primary_category->thread_secondary_categorys as $thread_secondary_category)
                        <option value="dashboard?category={{ $thread_secondary_category->id }}">
                            {{ $thread_secondary_category->name }}
                        </option>
                        @endforeach
                    </select>
                </th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
