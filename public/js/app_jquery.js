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
      "table": thread_id
    }
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
        show = "" + data[item]['no'] + ": " + user + " " + data[item]['time'] + "<br>" + "<p style='overflow-wrap: break-word;'>" + msg + "</p>" + "<br>" + "<button type='button' class='btn btn-dark' onClick='likes(" + data[item]['no'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'] + "<hr>";
      } else {
        // いいねが押されていない場合
        show = "" + data[item]['no'] + ": " + user + " " + data[item]['time'] + "<br>" + "<p style='overflow-wrap: break-word;'>" + msg + "</p>" + "<br>" + "<button type='button' class='btn btn-light' onClick='likes(" + data[item]['no'] + ", " + data[item]['user_like'] + ")'>like</button> " + data[item]['count_user'] + "<hr>";
      }

      displayArea.insertAdjacentHTML('afterbegin', show);
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
  var rows_limit = 20;
  var bytes_limit = 300;
  var sendAlertArea = document.getElementById("sendAlertArea");
  var formElm = document.getElementById("sendMessage");
  var message = formElm.message.value;

  if (message.trim() == 0) {
    sendAlertArea.innerHTML = "<div class='alert alert-danger'>書き込みなし・空白・改行のみの投稿は出来ません</div>";
  } else if (message.rows() > rows_limit) {
    sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は" + rows_limit + "行以内にして下さい</div>";
  } else if (message.bytes() > bytes_limit) {
    sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は" + bytes_limit / 3 + "文字(英数字は " + bytes_limit + "文字)以内にして下さい</div>";
  } else {
    sendAlertArea.innerHTML = "";
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
    formElm.message.value = '';
  }
});

String.prototype.bytes = function () {
  return encodeURIComponent(this).replace(/%../g, "x").length;
};

String.prototype.rows = function () {
  if (this.match(/\n/g)) return this.match(/\n/g).length + 1;else return 1;
};
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

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***************************************!*\
  !*** ./resources/js/Delete_thread.js ***!
  \***************************************/
$('#delete_threadBtn').click(function () {
  var formElm = document.getElementById("thread_actions_form");
  var thread_id = formElm.thread_id.value;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/admin/delete_thread",
    data: {
      "thread_id": thread_id
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
/*!*************************************!*\
  !*** ./resources/js/Edit_thread.js ***!
  \*************************************/
$('#edit_threadBtn').click(function () {
  var formElm = document.getElementById("thread_actions_form");
  var thread_id = formElm.thread_id.value;
  var formElm = document.getElementById("edit_thread_form");
  var thread_name = formElm.ThreadNameText.value;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/admin/edit_thread",
    data: {
      "thread_id": thread_id,
      "thread_name": thread_name
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
/*!****************************************!*\
  !*** ./resources/js/Delete_message.js ***!
  \****************************************/
$('#delete_messageBtn').click(function () {
  var formElm = document.getElementById("message_actions_form");
  var message_id = formElm.message_id.value;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/admin/delete_message",
    data: {
      "thread_id": thread_id,
      "message_id": message_id
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
/*!*****************************************!*\
  !*** ./resources/js/Restore_message.js ***!
  \*****************************************/
$('#restore_messageBtn').click(function () {
  var formElm = document.getElementById("message_actions_form");
  var message_id = formElm.message_id.value;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/admin/restore_message",
    data: {
      "thread_id": thread_id,
      "message_id": message_id
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