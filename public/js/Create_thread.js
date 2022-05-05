/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
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
/******/ })()
;