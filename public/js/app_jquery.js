/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*************************************************!*\
  !*** ./resources/js/dashboard/Create_thread.js ***!
  \*************************************************/
$('#dashboard_create_thread_btn').click(create_thread);
$('#dashboard_create_thread_text').keydown(function (e) {
  if (e.keyCode === 13) {
    create_thread();
  }
});
function create_thread() {
  var formElm = document.getElementById("dashboard_create_thread_form");
  var thread_name = formElm.dashboard_create_thread_text.value;
  var thread_category = formElm.dashboard_thread_category_select.value;
  formElm.dashboard_create_thread_text.value = "";
  if (thread_name == '') {
    return;
  }
  if (thread_category == '') {
    return;
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/create_thread",
    data: {
      "thread_name": thread_name,
      'thread_category': thread_category
    }
  }).done(function () {
    window.location.reload();
  }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
}
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************************!*\
  !*** ./resources/js/dashboard/Get_allRow.js ***!
  \**********************************************/
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
      show = "" + "<a " + "id='thread_message_id_" + data[item]['message_id'] + "' " + "href='#dashboard_send_comment_label' " + "type='button' " + "onClick='reply(" + data[item]['message_id'] + ")'>" + data[item]['message_id'] + "</a>" + ": " + user + " " + data[item]['created_at'] + "<br>" + "<p style='overflow-wrap: break-word;'>" + msg + "</p>";
      if (data[item]['thread_image_path'] !== null) {
        show += "" + "<p>" + "<img src='" + url + data[item]['thread_image_path']['img_path'].replace('public', '/storage') + "'>" + "</p>";
      }
      show += "" + "<br>" + "<button " + "id='js_dashboard_Get_allRow_button_" + data[item]['message_id'] + "' " + "type='button' ";
      if (data[item]['likes']['length'] === 0) {
        // いいねが押されていない場合
        show += "class='btn btn-light' onClick='likes(" + data[item]['message_id'] + ", " + 0 + ")'>";
      } else {
        // いいねが押されていた場合
        show += "class='btn btn-dark' onClick='likes(" + data[item]['message_id'] + ", " + 1 + ")'>";
      }
      show += "" + "like" + "</button> " + "<dev id='js_dashboard_Get_allRow_dev_" + data[item]['message_id'] + "'>" + data[item]['likes_count'] + "</dev>" + "<hr>";
      displayArea.insertAdjacentHTML('afterbegin', show);
      max_message_id = data[item]['message_id'];
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
/*!*************************************************!*\
  !*** ./resources/js/dashboard/Reply_message.js ***!
  \*************************************************/
$("#dashboard_send_comment_replay_clear").click(function () {
  $('#dashboard_send_comment_reply_disabled_text').val('');
  $('#dashboard_send_comment_reply_source').attr('href', '#!');
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*************************************************!*\
  !*** ./resources/js/dashboard/Search_thread.js ***!
  \*************************************************/
$('#dashboard_threads_search_thread').keyup(search_thread);
function search_thread() {
  var input = $('#dashboard_threads_search_thread').val();
  var category_type = $('#dashboard_threads_category_type_select').val();
  var category = $('#dashboard_threads_category_select').val();
  if (input == '') {
    $('#dashboard_threads_threads_table tr').show();
    return;
  }
  $('#dashboard_threads_threads_table tbody tr').each(function () {
    var text = $(this).find("td:eq(0)").html();
    var tb_category = $(this).find("td:eq(3)").html();
    var tb_category_type = $(this).find("td:eq(4)").html();
    if (text.match(input) != null) {
      if (category == tb_category) {
        $(this).show();
      } else if (category == '' && (category_type == '' || category_type == tb_category_type)) {
        $(this).show();
      } else {
        $('#dashboard_threads_threads_table tr').hide();
      }
    } else {
      $(this).hide();
    }
  });
}
$('#dashboard_threads_show_all_threads_button').click(function () {
  $('#dashboard_threads_category_type_select').val('');
  $('#dashboard_threads_category_select').val('');
  $('#dashboard_threads_search_thread').val('');
  $('#dashboard_threads_threads_table tr').show();
});
$('#dashboard_threads_category_type_select').change(function () {
  var category_type = $(this).val();
  search_thread();
  $('#dashboard_threads_category_select').find('option').each(function () {
    var category = $(this).data('val');
    if (category_type == '' || category_type == category) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
  $('#dashboard_threads_category_select').val('');
});
$('#dashboard_threads_category_select').change(search_thread);
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!********************************************!*\
  !*** ./resources/js/dashboard/Send_Row.js ***!
  \********************************************/
$('#dashboard_sendMessage_btn').click(send_comment);
$('#dashboard_message_textarea').keydown(function (e) {
  if (event.ctrlKey && e.keyCode === 13) {
    send_comment();
  }
});
function send_comment() {
  var rows_limit = 20;
  var bytes_limit = 300;
  var formElm = document.getElementById("dashboard_sendMessage_form");
  var message = formElm.dashboard_message_textarea.value;
  var reply = formElm.dashboard_send_comment_reply_disabled_text.value;
  var formData = new FormData();
  formData.append('thread_id', thread_id);
  formData.append('message', message);
  formData.append('reply', reply);
  formData.append('img', $('#dashboard_send_comment_upload_img').prop('files')[0]);
  if (message.trim() == 0) {
    dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>書き込みなし・空白・改行のみの投稿は出来ません</div>";
  } else if (message.rows() > rows_limit) {
    dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は" + rows_limit + "行以内にして下さい</div>";
  } else if (message.bytes() > bytes_limit) {
    dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は" + bytes_limit / 3 + "文字(英数字は " + bytes_limit + "文字)以内にして下さい</div>";
  } else {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      url: url + "/jQuery.ajax/sendRow",
      data: formData,
      processData: false,
      contentType: false
    }).done(function () {}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest.status);
      console.log(textStatus);
      console.log(errorThrown.message);
    });
    dashboard_sendAlertArea.innerHTML = "";
    formElm.dashboard_message_textarea.value = '';
    $('#dashboard_send_commnet_img_preview').attr('src', '');
    $('#dashboard_send_comment_upload_img').val('');
    $('#dashboard_send_comment_reply_disabled_text').val('');
    $('#dashboard_send_comment_reply_source').attr('href', '#!');
  }
}
String.prototype.bytes = function () {
  return encodeURIComponent(this).replace(/%../g, "x").length;
};
String.prototype.rows = function () {
  if (this.match(/\n/g)) return this.match(/\n/g).length + 1;else return 1;
};
$('#dashboard_send_comment_upload_img').change(function (e) {
  var fileset = $(this).val();
  if (fileset !== '' && e.target.files[0].type.indexOf('image') < 0) {
    dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>画像ファイルを指定してください</div>";
    $('#dashboard_send_commnet_img_preview').attr('src', '');
    $(this).val('');
    return false;
  } else if (file_size_check('dashboard_send_comment_upload_img')) {
    dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>ファイルのサイズは3MB以内にしてください</div>";
    $('#dashboard_send_commnet_img_preview').attr('src', '');
    $(this).val('');
    return false;
  } else {
    dashboard_sendAlertArea.innerHTML = "";
    if (fileset === '') {
      $('#dashboard_send_commnet_img_preview').attr('src', '');
    } else {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#dashboard_send_commnet_img_preview').attr('src', e.target.result);
      };
      reader.readAsDataURL(e.target.files[0]);
    }
  }
});
function file_size_check(idname) {
  var fileset = $('#' + idname).prop('files')[0];
  if (fileset) {
    // 画像サイズ3MBまで
    if (3145728 <= fileset.size) {
      return true;
    } else {
      return false;
    }
  }
}
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!************************************************!*\
  !*** ./resources/js/mypage/SelectPageThema.js ***!
  \************************************************/
$('#mypage_page_theme_select').change(function () {
  var value = $('option:selected').val();
  if (value == 'default') {
    value = 1;
  } else if (value == 'dark') {
    value = 2;
  } else {
    return;
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: url + "/jQuery.ajax/page_theme",
    data: {
      "page_theme": value
    }
  }).done(function () {
    window.location.reload();
  }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*************************************!*\
  !*** ./resources/js/report/form.js ***!
  \*************************************/
$('#report_form_btn').click(send_report_form);
$('#report_form_textarea').keydown(function (e) {
  if (e.keyCode === 13) {
    send_report_form();
  }
});
function send_report_form() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: "/report/store",
    data: $('#report_form_form').serializeArray()
  }).done(function (data) {
    $('div[name="radio_1_error"]').html('');
    $('div[name="textarea_error"]').html('');
    if (typeof data['errors'] !== 'undefined') {
      if (typeof data['errors']['radio_1'] !== 'undefined') $('div[name="radio_1_error"]').html('<div class="alert alert-danger">' + data['errors']['radio_1'][0] + '</div>');
      if (typeof data['errors']['report_form_textarea'] !== 'undefined') $('div[name="textarea_error"]').html('<div class="alert alert-danger">' + data['errors']['report_form_textarea'][0] + '</div>');
    } else {
      $('input:radio[name="radio_1"]').prop('checked', false);
      $('#report_form_textarea').val('');
    }
  }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown.message);
  });
}
})();

/******/ })()
;