if ((location.href).includes('dashboard/thread/name=')) {
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
        data: { "table": thread_id }
    }).done(function (data) {
        displayArea.innerHTML = "<br>";
        for (var item in data) {
            if (data[item]['is_validity']) {
                // 通常
                user = data[item]['name'];
                msg = data[item]['message'];
            } else {
                // 管理者によって削除されていた場合
                user = "-----";
                msg = "<br>この投稿は管理者によって削除されました";
            }

            if (data[item]['user_like'] == 1) {
                // いいねが押されていた場合
                show = "" +
                    data[item]['no'] + ": " + user + " " + data[item]['time'] +
                    "<br>" +
                    "<p style='overflow-wrap: break-word;'>" +
                    msg +
                    "</p>" +
                    "<br>" +
                    "<button type='button' class='btn btn-dark' onClick='likes(" + data[item]['no'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'] +
                    "<hr>"
            } else {
                // いいねが押されていない場合
                show = "" +
                    data[item]['no'] + ": " + user + " " + data[item]['time'] +
                    "<br>" +
                    "<p style='overflow-wrap: break-word;'>" +
                    msg +
                    "</p>" +
                    "<br>" +
                    "<button type='button' class='btn btn-light' onClick='likes(" + data[item]['no'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'] +
                    "<hr>";
            }

            displayArea.insertAdjacentHTML('afterbegin', show);
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}


