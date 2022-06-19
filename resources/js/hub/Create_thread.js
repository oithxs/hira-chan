$('#hub_create_thread_btn').click(function () {
    const formElm = document.getElementById("hub_CreateThread_form");
    const threadName = formElm.hub_new_threadName_text.value;
    formElm.hub_new_threadName_text.value = "";

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
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
