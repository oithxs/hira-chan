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
        if (data['result'] == "NO") {
            displayArea.innerHTML = `
            <div class="mt-4">
                <h1 class="text-danger">※スレッドが存在しません</h1>
            </div>`;
        } else {
            displayArea.innerHTML = "<br>";
            for (var item in data) {
                displayArea.insertAdjacentHTML('afterbegin',
                data[item]['no'] + ": " + data[item]['name'] + " " + data[item]['time'] + 
                "<br>" +
                "<p style='overflow-wrap: break-word;'>" +
                data[item]['message'] +
                "</p>" +
                "<br>" +
                "<button type='button' class='btn btn-secondary' onClick='like(" + data[item]['no'] + ")'>like</button> " + data[item]['count_user'] +
                "<hr>");
            }
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}


