$('#create_threadBtn').click(function () {
	const formElm = document.getElementById("createThread");
	const threadName = formElm.threadName.value;
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
		},
	}).done(function () {
	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		console.log(XMLHttpRequest.status);
		console.log(textStatus);
		console.log(errorThrown.message);
	});
})