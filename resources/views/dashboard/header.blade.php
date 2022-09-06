<!--
    ヘッダ部分
    カテゴリへのリンクを載せる予定
 -->

 <div>
    <table style="margin-bottom:0px" class="table table-borderless">
        <thead>
            <tr class="">
                @foreach ($category_types as $category_type)
                <th class="col-md-1">
                    <label></label>
                    <select onChange="location.href=value;">
                        <option>{{ $category_type->category_type }}</option>
                        @foreach ($categorys as $category)
                        @if ($category->category_type == $category_type->category_type)
                        <option value="dashboard?category={{ $category->category_name }}">{{ $category->category_name
                            }}
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
