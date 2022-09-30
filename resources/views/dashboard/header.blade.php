<!--
    ヘッダ部分
    選択することでカテゴリごとにスレッド表示
 -->

<div>
    <table style="margin-bottom:0px" class="table table-borderless">
        <thead>
            <tr>
                @foreach ($category_types as $category_type)
                <th class="col-md-1">
                    <select onChange="location.href=value;">
                        <option>{{ $category_type->category_type }}</option>
                        @foreach ($categorys as $category)
                        @if ($category->category_type == $category_type->category_type)
                        <option value="dashboard?category={{ $category->category_name }}">
                            {{ $category->category_name　}}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
