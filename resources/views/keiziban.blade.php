<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
	<script>
		const url = "{{$url}}";
		const table = "{{$tableName}}";
	</script>

	<title>掲示板-{{$tableName}}</title>
</head>

<body>
	<h1>{{$tableName}}</h1>

	<a href="{{ url('/hub') }}">戻る</a>

	<br>
	<div>
		<form id="sendMessage">
			<p>名前</p>
			<input type="text" name="name">
			<p>コメント</p>
			<textarea name="message"></textarea>
		</form>
		<button id="sendMessageBtn">書き込み</button>
		<script src="{{ mix('js/Send_Row.js') }}"></script>
	</div>
	
	<br><br><br>
	
	<div id="displayArea">
	<script src="{{ mix('/js/Get_allRow.js') }}"></script>
	</div>

</body>

</html>