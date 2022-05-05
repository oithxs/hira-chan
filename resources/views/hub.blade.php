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
            <div>
                <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
                <script>
                    const url = "{{$url}}";
                </script>
            </div>
            <div>
                <form id="createThread">
                    <p>{{__('Thread name')}}<input type="text" name="threadName"></P>
                </form>
                <button id="create_threadBtn">{{__('Create new thread')}}</button>
                <script src="{{ mix('js/Create_thread.js') }}"></script>
            </div>

                <br><br>
				<div>
					@foreach($tables as $tableName)
						<li><a href="keiziban?table%5B%5D={{$tableName}}">{{$tableName}}</a></li>
					@endforeach
				</div>
			<!-- my area begin -->
			
            </div>
        </div>
    </div>
</x-app-layout>
