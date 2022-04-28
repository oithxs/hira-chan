display();
setInterval('display()', 1000);

function display() {
    var displayArea = document.getElementById("displayArea");
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/jQuery.ajax/getRow",
        data: { 'table': table },
        dataType: "json",
    }).done(function (data) { // 成功時
        displayArea.innerHTML = "<br>";
        for (var item in data) {
            displayArea.insertAdjacentHTML("afterbegin", data[item]['no'] + ": " + data[item]['name'] + " " + data[item]['time'] + "<br>" +
                data[item]['message'] + "<hr><br>");
        }
    }).fail(function (XMLHttpRequest, textStatus, errorThrown) { // 失敗時
        console.log(XMLHttpRequest.status);
        console.log(textStatus);
        console.log(errorThrown.message);
    });
}