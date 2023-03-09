$('#dashboard_threads_search_thread').keyup(search_thread);

function search_thread() {
    var input = $('#dashboard_threads_search_thread').val();
    var thread_primary_category = $('#dashboard_threads_primary_category_select').val();
    var thread_secondary_category = $('#dashboard_threads_secondary_category_select').val();

    if (input == '') {
        $('#dashboard_threads_threads_table tr').show();
        return;
    }

    $('#dashboard_threads_threads_table tbody tr').each(function () {
        var text = $(this).find("td:eq(0)").html();
        var tb_thread_secondary_category = $(this).find("td:eq(3)").html();
        var tb_thread_primary_category = $(this).find("td:eq(4)").html();

        if (text.match(input) != null) {
            if (thread_secondary_category == tb_thread_secondary_category) {
                $(this).show();
            } else if (thread_secondary_category == '' && (thread_primary_category == '' || thread_primary_category == tb_thread_primary_category)) {
                $(this).show();
            } else {
                $('#dashboard_threads_threads_table tr').hide();
            }
        } else {
            $(this).hide();
        }
    });
}

$('#dashboard_threads_show_all_threads_button').click(function () {
    $('#dashboard_threads_primary_category_select').val('');
    $('#dashboard_threads_secondary_category_select').val('');
    $('#dashboard_threads_search_thread').val('');
    $('#dashboard_threads_threads_table tr').show();
});

$('#dashboard_threads_primary_category_select').change(function () {
    var thread_primary_category = $(this).val();
    search_thread()

    $('#dashboard_threads_secondary_category_select').find('option').each(function () {
        var thread_secondary_category = $(this).data('val');

        if (thread_primary_category == '' || thread_primary_category == thread_secondary_category) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    $('#dashboard_threads_secondary_category_select').val('');
});

$('#dashboard_threads_secondary_category_select').change(search_thread);
