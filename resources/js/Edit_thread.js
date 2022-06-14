$('#edit_threadBtn').click(function () {
    var formElm = document.getElementById("thread_actions_form");
    var thread_id = formElm.thread_id.value;

    var formElm = document.getElementById("edit_thread_form");
    var thread_name = formElm.ThreadNameText.value;

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
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
