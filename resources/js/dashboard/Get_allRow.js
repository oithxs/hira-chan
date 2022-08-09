if (show_thread_messages_flag === 1) {
    show_thread_messages_flag = 0;
    reload();
    setInterval(reload, 5000);
}

function reload() {
    var displayArea = document.getElementById("dashboard_displayArea");
    var user;
    var msg;
    var show;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/getRow",
        dataType: "json",
        data: { "table": thread_id }
    }).done(function (data) {
        displayArea.innerHTML = "<br>";
        for (var item in data) {
            if (data[item]['is_validity']) {
                // 通常
                user = data[item]['user_name'];
                msg = data[item]['message'];
            } else {
                // 管理者によって削除されていた場合
                user = "-----";
                msg = "<br>この投稿は管理者によって削除されました";
            }

            show = "" +
                "<a id='thread_message_id_" + data[item]['message_id'] + "' href='#dashboard_send_comment_label' type='button' onClick='reply(" + data[item]['message_id'] + ")'>" + data[item]['message_id'] + "</a>" + ": " + user + " " + data[item]['created_at'] +
                "<br>" +
                "<p style='overflow-wrap: break-word;'>" +
                msg +
                "</p>";
            if (data[item]['img_path'] != null) {
                show += "" +
                    "<p>" +
                    "<img src='" + url + data[item]['img_path'].replace('public', '/storage') + "'>" +
                    "</p>";
            }
            show += "<br>";

            if (data[item]['user_like'] == 0) {
                // いいねが押されていない場合
                show += "<button type='button' class='btn btn-light' onClick='likes(" + data[item]['message_id'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'];
            } else {
                // いいねが押されていた場合
                show += "<button type='button' class='btn btn-dark' onClick='likes(" + data[item]['message_id'] + ", " + 1 + ")'>like</button> " + data[item]['count_user'];
            }

            show += "<hr>";

            displayArea.insertAdjacentHTML('afterbegin', show);
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}
