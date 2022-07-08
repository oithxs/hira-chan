$('#dashboard_threads_search_thread').keyup(search_thread);

function search_thread() {
    var input = $('#dashboard_threads_search_thread').val();
    var category_type = $('#dashboard_threads_category_type_select').val();
    var category = $('#dashboard_threads_category_select').val();

    $('#dashboard_threads_threads_table tbody tr').each(function () {
        var text = $(this).find("td:eq(0)").html();
        var tb_category = $(this).find("td:eq(3)").html();
        var tb_category_type = $(this).find("td:eq(4)").html();

        if (text.match(input) != null) {
            if (category_type == '' || category_type == tb_category_type) {
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
    $('#dashboard_threads_category_type_select').val('');
    $('#dashboard_threads_category_select').val('');
    $('#dashboard_threads_search_thread').val('');
    $('#dashboard_threads_threads_table tr').show();
});

$('#dashboard_threads_category_type_select').change(function () {
    var category_type = $(this).val();
    search_thread()

    $('#dashboard_threads_category_select').find('option').each(function () {
        var category = $(this).data('val');

        if (category_type == '' || category_type == category) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    $('#dashboard_threads_category_select').val('');
});
