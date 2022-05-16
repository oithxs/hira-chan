$('#sendMessageBtn').click(function () {
	var sendAlertArea = document.getElementById("sendAlertArea");
	var formElm = document.getElementById("sendMessage");
	var message = formElm.message.value;

	if (message.trim() == 0) {
		sendAlertArea.innerHTML = "<div class='alert alert-danger'>書き込みなし・空白・改行のみの投稿は出来ません</div>";
	} else if (message.rows() > 20) {
		sendAlertArea.innerHTML = "<div class='alert alert-danger'>入力は10行以内にして下さい</div>";
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
			},
		}).done(function () {
		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			console.log(XMLHttpRequest.status);
			console.log(textStatus);
			console.log(errorThrown.message);
		});
		formElm.message.value = '';
	}
});

String.prototype.bytes = function () {
	return(encodeURIComponent(this).replace(/%../g,"x").length);
}

String.prototype.rows = function () {
	if (this.match(/\n/g)) return(this.match(/\n/g).length) + 1; else return(1);
}
