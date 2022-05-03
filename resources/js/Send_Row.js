$('#sendMessageBtn').click(function () {
	const formElm = document.getElementById("sendMessage");
	formElm.message.value = '';

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$.ajax({
		type: "POST",
		url: url + "/jQuery.ajax/sendRow",
	}).done(function () {
	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		console.log(XMLHttpRequest.status);
		console.log(textStatus);
		console.log(errorThrown.message);
	});
});