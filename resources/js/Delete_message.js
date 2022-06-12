$('#delete_messageBtn').click(function () {
	var formElm = document.getElementById("message_actions_form");
	var thread_id = formElm.message_id.value;
	console.log(thread_id);
})
