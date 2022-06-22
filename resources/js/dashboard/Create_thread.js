$('#dashboard_create_thread_btn').click(function () {
    const formElm = document.getElementById("dashboard_create_thread_form");
    const threadName = formElm.dashboard_create_thread_text.value;
    formElm.dashboard_create_thread_text.value = "";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/create_thread",
        data: {
            "table": threadName
        },
    }).done(function () {
        window.location.reload()
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
