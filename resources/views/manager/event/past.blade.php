<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去のイベント一覧
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                <section class="text-gray-600 body-font">
                    <div class="container mx-auto">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-center text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント名</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">参加人数</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">定員</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">ステータス</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                <td class="px-4 py-3text-lg text-indigo-600">
                                    <a href="{{ route('event.show', [ "event" => $event->id ]) }}" class="hover:underline">{{ $event->name }}</a>
                                </td>
                                <td class="px-4 py-3">{{ $event->start_date }}</td>
                                <td class="px-4 py-3">{{ $event->end_date }}</td>
                                <td class="px-4 py-3">30</td>
                                <td class="px-4 py-3">{{ $event->max_people }}</td>
                                <td class="px-4 py-3 {{ $event->is_visible == 1 ? 'text-green-600' : 'text-red-600' }}">{{ $event->is_visible == 1 ? 'ON' : 'OFF' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                            <div class="px-4 py-3">
                                {{ $events->links() }}
                            </div>
                            <div class="flex px-4 py-3 w-full mx-auto flex-row-reverse">
                                <button onclick="location.href='{{ route('event.index') }}'" class="flex text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded">戻る</button>
                            </div>
                        </div>
                    </div>
                </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    