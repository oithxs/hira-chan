if ((location.href).includes('hub/thread_name=')) {
    reload();
    setInterval(reload, 1000);
}

function reload(){
    var displayArea = document.getElementById("displayArea");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/getRow",
        dataType: "json",
        data: {"table" : thread_id}
    }).done(function (data) {
        displayArea.innerHTML = "<br>";
        for (var item in data) {
            if (data[item]['is_validity']) {
                user = data[item]['name'];
                msg = data[item]['message'];
            } else {
                user = "-----";
                msg = "<br>この投稿は管理者によって削除されました";
            }

            if (data[item]['user_like'] == 1) {
                displayArea.insertAdjacentHTML('afterbegin',
                data[item]['no'] + ": " + user + " " + data[item]['time'] + 
                "<br>" +
                "<p style='overflow-wrap: break-word;'>" +
                msg +
                "</p>" +
                "<br>" +
                "<button type='button' class='btn btn-dark' onClick='likes(" + data[item]['no'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'] +
                "<hr>");
            } else {
                displayArea.insertAdjacentHTML('afterbegin',
                data[item]['no'] + ": " + user + " " + data[item]['time'] + 
                "<br>" +
                "<p style='overflow-wrap: break-word;'>" +
                msg +
                "</p>" +
                "<br>" +
                "<button type='button' class='btn btn-light' onClick='likes(" + data[item]['no'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'] +
                "<hr>");
            }
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}


