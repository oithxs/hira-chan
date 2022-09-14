if (show_thread_messages_flag === 1) {
    show_thread_messages_flag = 0;
    reload();
    setInterval(reload, 1000);
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
        data: {
            "thread_id": thread_id,
            "max_message_id": max_message_id
        }
    }).done(function (data) {
        for (var item in data) {
            user = data[item]['user']['name'];
            msg = data[item]['message'];

            show = "" +
                "<a " +
                "id='thread_message_id_" + data[item]['message_id'] + "' " +
                "href='#dashboard_send_comment_label' " +
                "type='button' " +
                "onClick='reply(" + data[item]['message_id'] + ")'>" +
                data[item]['message_id'] +
                "</a>" +
                ": " + user + " " + data[item]['created_at'] +
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

            show += "" +
                "<br>" +
                "<button " +
                "id='js_dashboard_Get_allRow_button_" + data[item]['message_id'] + "' " +
                "type='button' ";

            if (data[item]['user_like'] == 0) {
                // いいねが押されていない場合
                show += "class='btn btn-light' onClick='likes(" + data[item]['message_id'] + ", " + 0 + ")'>";
            } else {
                // いいねが押されていた場合
                show += "class='btn btn-dark' onClick='likes(" + data[item]['message_id'] + ", " + 1 + ")'>";
            }

            show += "" +
                "like" +
                "</button> " +
                "<dev id='js_dashboard_Get_allRow_dev_" + data[item]['message_id'] + "'>" +
                data[item]['count_user'] +
                "</dev>" +
                "<hr>";

            displayArea.insertAdjacentHTML('afterbegin', show);
            max_message_id = data[item]['message_id'];
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}
