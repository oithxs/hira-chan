$('#mypage_page_theme_select').change(function () {
    var value = $('option:selected').val();

    if (value == 'default') {
        value = 1;
    } else if (value == 'dark') {
        value = 2;
    } else {
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/page_theme",
        data: {
            "page_theme": value
        },
    }).done(function () {
        window.location.reload();
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
