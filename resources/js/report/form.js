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
        data: $('#report_form_form').serializeArray(),
    }).done(function (data) {
        $('div[name="radio_1_error"]').html('');
        $('div[name="textarea_error"]').html('');

        if (typeof data['errors'] !== 'undefined') {
            if (typeof data['errors']['radio_1'] !== 'undefined')
                $('div[name="radio_1_error"]').html('<div class="alert alert-danger">' + data['errors']['radio_1'][0] + '</div>');
            if (typeof data['errors']['report_form_textarea'] !== 'undefined')
                $('div[name="textarea_error"]').html('<div class="alert alert-danger">' + data['errors']['report_form_textarea'][0] + '</div>');
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
