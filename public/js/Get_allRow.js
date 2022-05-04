/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/Get_allRow.js ***!
  \************************************/
setInterval(reload, 1000);

function reload() {
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
    data: {
      "table": table
    }
  }).done(function (data) {
    // 成功時
    displayArea.innerHTML = "<br>";

    for (var item in data) {
      displayArea.insertAdjacentHTML('beforeend', data[item]['no'] + ": " + data[item]['name'] + " " + data[item]['time'] + "<br>" + data[item]['message'] + "<hr><br>");
    }
  }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    // 失敗時
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
}
/******/ })()
;