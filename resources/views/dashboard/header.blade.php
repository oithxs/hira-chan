<!--
    ヘッダ部分
    カテゴリへのリンクを載せる予定
 -->

<div>
    <table class="table table-striped">
        <thead>
            <tr>
                @foreach ($category_types as $category_type)
                <th>
                    <label></label>
                    <select onChange="location.href=value;">
                        <option>{{ $category_type->category_type }}</option>
                        @foreach ($categorys as $category)
                        @if ($category->category_type == $category_type->category_type)
                        <option value="/dashboard?category={{ $category->category_name }}">{{ $category->category_name
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
