$('#sendMessageBtn').click(function () {
	const formElm = document.getElementById("sendMessage");
	const name = formElm.name.value;
	const message = formElm.message.value;
	formElm.name.value = '';
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
			"table": table,
			"name": name,
			"message": message
		},
	}).done(function () {
	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		console.log(XMLHttpRequest.status);
		console.log(textStatus);
		console.log(errorThrown.message);
	});
});