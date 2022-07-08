$('#dashboard_threads_search_thread').keyup(function () {
    var input = $(this).val();
    $('#dashboard_threads_threads_table tbody tr').each(function () {
        var text = $(this).find("td:eq(0)").html();
        if (text.match(input) != null) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

$('#dashboard_threads_show_all_threads_button').click(function () {
    $('#dashboard_threads_search_thread').val('');
    $('#dashboard_threads_threads_table tr').show();
});
