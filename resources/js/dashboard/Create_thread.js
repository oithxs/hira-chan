$('#dashboard_create_thread_btn').click(create_thread);
$('#dashboard_create_thread_text').keydown(function (e) {
    if (e.keyCode === 13) {
        create_thread();
    }
});

function create_thread() {
    const formElm = document.getElementById("dashboard_create_thread_form");
    const threadName = formElm.dashboard_create_thread_text.value;
    const thread_category = formElm.dashboard_thread_category_select.value;
    formElm.dashboard_create_thread_text.value = "";

    if (threadName == '') {
        return;
    }
    if (thread_category == '') {
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/create_thread",
        data: {
            "table": threadName,
            'thread_category': thread_category
        },
    }).done(function () {
        window.location.reload()
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}
