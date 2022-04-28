<!DOCTYPE html>
<html lang="ja">

<head>
	<meta cahrset="UTF-8">
	<title>掲示板ハブ</title>
</head>

<body>
	<div>
		<h1>HxSコンピュータ部　掲示板</h1>
	</div>

	<div>
		@foreach($tables as $tableName)
			<li><a href="keiziban?table%5B%5D={{$tableName}}">{{$tableName}}</a></li>
		@endforeach
	</div>	
</body>

</html>