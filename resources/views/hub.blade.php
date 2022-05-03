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
					@foreach($tables as $tableName)
						<li><a href="keiziban?table%5B%5D={{$tableName}}">{{$tableName}}</a></li>
					@endforeach
				</div>
			<!-- my area begin -->
			
            </div>
        </div>
    </div>
</x-app-layout>
