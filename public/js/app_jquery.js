/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!************************************!*\
  !*** ./resources/js/Get_allRow.js ***!
  \************************************/
if (location.href.includes('hub/thread_name=')) {
  reload();
  setInterval(reload, 1000);
}

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
      "table": thread_id
    }
  }).done(function (data) {
    displayArea.innerHTML = "<br>";

    for (var item in data) {
      displayArea.insertAdjacentHTML('afterbegin', data[item]['no'] + ": " + data[item]['name'] + " " + data[item]['time'] + "<br>" + data[item]['message'] + "<br>" + "<button type='button' class='btn btn-secondary' onClick='like(" + data[item]['no'] + ")'>like</button> " + data[item]['count_user'] + "<hr>");
    }
  }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
}
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/js/Send_Row.js ***!
  \**********************************/
$('#sendMessageBtn').click(function () {
  var formElm = document.getElementById("sendMessage");
  var message = formElm.message.value;
  formElm.message.value = '';
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
    }
  }).done(function () {}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***************************************!*\
  !*** ./resources/js/Create_thread.js ***!
  \***************************************/
$('#create_threadBtn').click(function () {
  var formElm = document.getElementById("createThread");
  var threadName = formElm.threadName.value;
  formElm.threadName.value = "";
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/create_thread",
    data: {
      "table": threadName
    }
  }).done(function () {}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
});
})();

/******/ })()
;