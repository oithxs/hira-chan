$('#dashboard_sendMessage_btn').click(function () {
    var rows_limit = 20;
    var bytes_limit = 300;
    var sendAlertArea = document.getElementById("dashboard_sendAlertArea");
    var formElm = document.getElementById("dashboard_sendMessage_form");
    var message = formElm.dashboard_message_textarea.value;

    if (message.trim() == 0) {
        dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>書き込みなし・空白・改行のみの投稿は出来ません</div>";
    } else if (message.rows() > rows_limit) {
        dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は" + rows_limit + "行以内にして下さい</div>";
    } else if (message.bytes() > bytes_limit) {
        dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は" + bytes_limit / 3 + "文字(英数字は " + bytes_limit + "文字)以内にして下さい</div>";
    } else {
        dashboard_sendAlertArea.innerHTML = "";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: url + "/jQuery.ajax/sendRow",
            data: {
                "table": thread_id,
                "message": message
            },
        }).done(function () {
        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(textStatus);
            console.log(errorThrown.message);
        });
        formElm.dashboard_message_textarea.value = '';
    }
});

String.prototype.bytes = function () {
    return (encodeURIComponent(this).replace(/%../g, "x").length);
}

String.prototype.rows = function () {
    if (this.match(/\n/g)) return (this.match(/\n/g).length) + 1; else return (1);
}
