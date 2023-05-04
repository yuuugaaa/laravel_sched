<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベントカレンダー
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="max-w-4xl mx-auto">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-center text-green-600">
                                {{ session('status') }}
                            </div>
                        @elseif (session('error'))
                            <div class="mb-4 font-medium text-sm text-center text-red-600">
                                {{ session('error') }}
                            </div>
                        @endif
                        @livewire('calender')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
