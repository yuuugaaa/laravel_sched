<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="max-w-2xl mx-auto">
                        <x-validation-errors class="mb-4" />
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                
                        <form method="post" action="{{ route('event.reserve', [ 'id' => $event->id ]) }}">
                            @csrf
                            <div class="pb-4">
                                <x-label for="event_name" value="イベント名" />
                                <div class="block mt-1 w-full">{{ $event->name }}</div>
                            </div>
                            <div class="sm:flex justify-between">
                                <div class="pb-4">
                                    <x-label for="event_date" value="日付" />
                                    <div class="block mt-1 w-full">{{ $event->eventDate }}</div>
                                </div>
                                <div class="pb-4">
                                    <x-label for="start_time" value="開始時間" />
                                    <div class="block mt-1 w-full">{{ $event->startTime }}</div>
                                </div>
                                <div class="pb-4">
                                    <x-label for="end_time" value="終了時間" />
                                    <div class="block mt-1 w-full">{{ $event->endTime }}</div>
                                </div>
                            </div>
                            <div class="sm:flex">
                                <div class="pb-4">
                                    <x-label for="max_people" value="定員" />
                                    <div class="block mt-1 w-full">{{ $event->max_people }}</div>
                                </div>
                            </div>
                            <div class="pb-4">
                                <x-label for="information" value="イベント詳細" />
                                <div class="block mt-1 w-full">{!! nl2br(e($event->information)) !!}</div>
                            </div>
                            @if ($canBeReservedPeople)
                                <div class="flex">
                                    <div class="pb-4">
                                        <x-label for="reserved_people" value="予約する" />
                                        <select name="reserved_people" id="reserved_people" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @for ($i = 1; $i <= $canBeReservedPeople; $i++)
                                                <option value="{{ $i }}">{{ $i }}人</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="id" value="{{ $event->id }}">
                                <div class="flex pt-3 w-full mx-auto">
                                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">予約</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    