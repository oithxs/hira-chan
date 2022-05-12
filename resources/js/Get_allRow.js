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
            displayArea.insertAdjacentHTML('afterbegin',
            data[item]['no'] + ": " + data[item]['name'] + " " + data[item]['time'] + 
            "<br>" +
            data[item]['message'] +
            "<br>" +
            "<button type='button' class='btn btn-secondary' onClick='like(" + data[item]['no'] + ")'>like</button>" +
            "<hr>");
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}


