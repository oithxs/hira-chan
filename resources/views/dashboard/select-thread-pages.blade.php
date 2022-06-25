<?php
    $max_page = ceil($max_thread / 10);
?>

<table class="table table-striped">
    <tr>
        @for ($i = 1; $i <= $max_page; $i++)
        <th> <a href="/dashboard/{{ $i }}">{{ $i }}</a></td>
        @endfor
    </tr>
</table>
