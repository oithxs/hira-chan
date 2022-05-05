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
                <table>
                    <tr><th>{{__('Thread name')}}</th><td>{{__('Create time')}}</td></tr>
                    @foreach($tables as $tableInfo)
                        <tr><th><a href="keiziban?table%5B%5D={{$tableInfo['table_name']}}">{{$tableInfo['table_name']}}</a></th><td>{{$tableInfo['created_at']}}</td></tr>
                    @endforeach
                </table>
            </div>
			<!-- my area begin -->
			
            </div>
        </div>
    </div>
</x-app-layout>
