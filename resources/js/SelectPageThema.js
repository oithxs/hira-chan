$('#page_thema').change(function () {
    var value = $('option:selected').val();

    if (value == '') {
        return;
    } else if (value == 'default') {
        value = 0;
    } else if (value == 'dark') {
        value = 1;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/page_thema",
        data: {
            "page_thema": value
        },
    }).done(function () {
        window.location.reload();
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
