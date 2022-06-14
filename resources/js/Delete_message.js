$('#delete_messageBtn').click(function () {
    var formElm = document.getElementById("message_actions_form");
    var message_id = formElm.message_id.value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/admin/delete_message",
        data: {
            "thread_id": thread_id,
            "message_id": message_id
        },
    }).done(function () {
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
