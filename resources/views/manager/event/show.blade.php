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
                            <div class="mb-4 font-medium text-sm text-center text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                
                        <form method="get" action="{{ route('event.edit', [ 'event' => $event->id ]) }}">
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
                            <div class="pb-4">
                                @if ($event->is_visible)
                                <label class="text-green-600">表示中</label>
                                @else
                                <label class="text-red-600">非表示中</label>
                                @endif
                            </div>
                            @if ($event->eventDate >= $today)
                            <div class="flex pt-3 w-full mx-auto">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">編集</button>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!$event->users->isEmpty())
    <div class="pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="max-w-2xl mx-auto">
                        <div class="w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">予約者名</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">予約人数</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event->users as $user)
                                    @if (is_null($user->pivot->canceled_date))
                                    <tr>
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->pivot->number_of_people }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
    