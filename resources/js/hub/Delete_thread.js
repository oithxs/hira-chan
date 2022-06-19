$('#hub_delete_thread_btn').click(function () {
    var formElm = document.getElementById("hub_thread_actions_form");
    var thread_id = formElm.hub_thread_id_text.value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/admin/delete_thread",
        data: {
            "thread_id": thread_id
        },
    }).done(function () {
        window.location.reload()
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
