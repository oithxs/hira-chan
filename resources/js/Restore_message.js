$('#keiziban_restore_message_btn').click(function () {
    var formElm = document.getElementById("keiziban_message_actions_form");
    var message_id = formElm.keiziban_message_id_number.value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/admin/restore_message",
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
