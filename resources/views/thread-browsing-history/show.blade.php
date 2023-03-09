<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Thread history') }}
        </h2>
    </x-slot>
    <div id="thread_browsing_history" data-history='{{ $history }}'></div>
</x-app-layout>
