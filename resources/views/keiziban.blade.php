<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$tableName}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

			<!-- my area begin -->
				<div>
					<meta name="csrf-token" content="{{ csrf_token() }}">
					<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
					<script>
						const url = "{{$url}}";
						const table = "{{$tableName}}";
					</script>
				</div>

				<div>					
					<a href="{{ url('/hub') }}">戻る</a>
					<br><br>
					
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
				</div>
			<!-- my area end -->

            </div>
        </div>
    </div>
</x-app-layout>