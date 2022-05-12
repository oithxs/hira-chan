<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{__('Forum Hub')}}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

			<!-- my area begin -->
			<head>
				<meta charset="utf-8">
				<meta name="csrf-token" content="{{ csrf_token() }}">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<!-- Bootstrap CSS -->
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
				rel="stylesheet" 
				integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
				crossorigin="anonymous">
			</head>
			
			<body>
				<div class="container-fluid">
					<form id="createThread" class="col-sm">
						<div class="mb-2">
							<label class="form-label">スレッド名</label>
							<input class="form-control" type="text" name="threadName">
						</div>
						<button id="create_threadBtn" class="btn btn-primary">{{__('Create new thread')}}</button>
					</form>

					<br><br>
					
					<div>
						<table class="table table-striped">
							<thead>
								<tr><th>{{__('Thread name')}}</th><td>{{__('Create time')}}</td></tr>
							</thead>
							<tbody>
								@foreach($tables as $tableInfo)
									<tr><th><a href="hub/{{ $tableInfo['thread_name'] }}/id={{ $tableInfo['thread_id'] }}">{{$tableInfo['thread_name']}}</a></th><td>{{$tableInfo['created_at']}}</td></tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div>
					<!-- Bootstrap用JavaScript -->
					<script
					src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
					integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
					crossorigin="anonymous"
					></script>

					<!-- jQuery -->
					<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>

					<!-- グローバル変数 -->
					<script>
						const url = "{{$url}}";
					</script>

					<!-- others -->
					<script src="{{ mix('js/app_jquery.js') }}"></script>
				</div>
			</body>
			<!-- my area end -->
			
			</div>
		</div>
	</div>
</x-app-layout>
