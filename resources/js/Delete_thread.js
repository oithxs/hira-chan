$('#delete_threadBtn').click(function () {
    var formElm = document.getElementById("thread_actions_form");
    var thread_id = formElm.thread_id.value;

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
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
})
