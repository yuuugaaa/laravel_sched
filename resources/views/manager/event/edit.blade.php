<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント編集
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="max-w-2xl mx-auto">
                        <x-validation-errors class="mb-4" />
                        @if (session('error'))
                            <div class="mb-4 font-medium text-sm text-red-600">
                                {{ session('error') }}
                            </div>
                        @endif
                
                        <form method="POST" action="{{ route('event.update', [ 'event' => $event->id ]) }}">
                            @csrf
                            @method('put')
                            <div class="pb-4">
                                <x-label for="event_name" value="イベント名" />
                                <x-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" value="{{ old('event_name', $event->name) }}" required autofocus />
                            </div>
                            <div class="sm:flex justify-between">
                                <div class="pb-4">
                                    <x-label for="event_date" value="日付" />
                                    <x-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" value="{{ old('event_date', $event->editEventDate) }}" required />
                                </div>
                                <div class="pb-4">
                                    <x-label for="start_time" value="開始時間" />
                                    <x-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" value="{{ old('start_time', $event->startTime) }}" required />
                                </div>
                                <div class="pb-4">
                                    <x-label for="end_time" value="終了時間" />
                                    <x-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" value="{{ old('end_time', $event->endTime) }}" required />
                                </div>
                            </div>
                            <div class="sm:flex">
                                <div class="pb-4">
                                    <x-label for="max_people" value="定員" />
                                    <x-input id="max_people" class="block mt-1 w-full" type="number" min="0" name="max_people" value="{{ old('max_people', $event->max_people) }}" required />
                                </div>
                            </div>
                            <div class="pb-4">
                                <x-label for="information" value="イベント詳細" />
                                <x-textarea id="information" class="block mt-1 w-full" name="information">{{ old('information', $event->information) }}</x-textarea>
                            </div>
                            <div class="pb-4">
                                <label class="mr-4"><input type="radio" class="mr-1" name="is_visible" value="1"
                                    {{ old('is_visible', $event->is_visible) == 1 ? 'checked' : '' }} >表示</label>
                                <label><input type="radio" class="mr-1" name="is_visible" value="0"
                                    {{ old('is_visible', $event->is_visible) == 0 ? 'checked' : '' }} >非表示</label>
                            </div>
                            <div class="flex pt-3 w-full mx-auto">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">更新</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    