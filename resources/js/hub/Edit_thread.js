$('#hub_edit_thread_btn').click(function () {
    var formElm = document.getElementById("hub_thread_actions_form");
    var thread_id = formElm.hub_thread_id_text.value;

    var formElm = document.getElementById("hub_edit_thread_form");
    var thread_name = formElm.hub_edit_ThreadName_text.value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/admin/edit_thread",
        data: {
            "thread_id": thread_id,
            "thread_name": thread_name
        },
    }).done(function () {
        window.location.reload()
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
