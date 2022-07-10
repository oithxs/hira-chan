$('#dashboard_sendMessage_btn').click(function () {
    var rows_limit = 20;
    var bytes_limit = 300;
    var formElm = document.getElementById("dashboard_sendMessage_form");
    var message = formElm.dashboard_message_textarea.value;

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
            data: {
                "table": thread_id,
                "message": message,
            },
        }).done(function () {
            if (formElm.dashboard_send_comment_upload_img.value != null) {
                var formData = new FormData();
                formData.append('thread_id', thread_id);
                formData.append('message', message);
                formData.append('img', $('#dashboard_send_comment_upload_img').prop('files')[0]);

                $.ajax({
                    type: "POST",
                    url: url + "/jQuery.ajax/img_upload",
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function () {
                }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest.status);
                    console.log(textStatus);
                    console.log(errorThrown.message);
                });
                $('#dashboard_send_comment_upload_img').val('');
            }
        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(textStatus);
            console.log(errorThrown.message);
        });

        dashboard_sendAlertArea.innerHTML = "";
        formElm.dashboard_message_textarea.value = '';
        $('#dashboard_send_commnet_img_preview').attr('src', '');
    }
});

String.prototype.bytes = function () {
    return (encodeURIComponent(this).replace(/%../g, "x").length);
}

String.prototype.rows = function () {
    if (this.match(/\n/g)) return (this.match(/\n/g).length) + 1; else return (1);
}

$('#dashboard_send_comment_upload_img').change(function (e) {
    var fileset = $(this).val();

    if (fileset !== '' && e.target.files[0].type.indexOf('image') < 0) {
        dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>画像ファイルを指定してください</div>";
        $('#dashboard_send_commnet_img_preview').attr('src', '');
        $(this).val('');
        return false;
    } else if (file_size_check('dashboard_send_comment_upload_img')) {
        dashboard_sendAlertArea.innerHTML = "<div class='alert alert-danger'>ファイルのサイズは1MB以内にしてください</div>";
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
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    }
});

function file_size_check(idname) {
    var fileset = $('#' + idname).prop('files')[0];
    if (fileset) {
        if (1048576 <= fileset.size) {
            return true;
        } else {
            return false;
        }
    }
}
