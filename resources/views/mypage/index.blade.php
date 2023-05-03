<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      予約イベント
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
            <h3 class="mb-4 font-bold text-center">参加予定のイベント</h3>
            @if ($futureEvents)
            <div class="w-full mx-auto overflow-auto">
              <table class="table-auto w-full text-left whitespace-no-wrap">
              <thead>
                <tr>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント名</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($futureEvents as $event)
                <tr>
                <td class="px-4 py-3text-lg text-indigo-600">
                  <a href="{{ route('mypage.show', [ "id" => $event['id'] ]) }}" class="hover:underline">{{ $event['name'] }}</a>
                </td>
                <td class="px-4 py-3">{{ $event['start_date'] }}</td>
                <td class="px-4 py-3">{{ $event['end_date'] }}</td>
                <td class="px-4 py-3">{{ $event['number_of_people'] }}</td>
                </tr>
                @endforeach
              </tbody>
              </table>
            </div>
            @else
              <p class="text-sm">参加予定のイベントはありません。</p>
            @endif
          </div>
        </section>
        </div>
      </div>
    </div>
  </div>

  <div class="pb-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <section class="text-gray-600 body-font">
          <div class="container mx-auto">
            <h3 class="mb-4 font-bold text-center">過去のイベント</h3>
            @if ($pastEvents)
            <div class="w-full mx-auto overflow-auto">
              <table class="table-auto w-full text-left whitespace-no-wrap">
              <thead>
                <tr>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">イベント名</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pastEvents as $event)
                <tr>
                <td class="px-4 py-3text-lg text-indigo-600">
                  <a href="{{ route('mypage.show', [ "id" => $event['id'] ]) }}" class="hover:underline">{{ $event['name'] }}</a>
                </td>
                <td class="px-4 py-3">{{ $event['start_date'] }}</td>
                <td class="px-4 py-3">{{ $event['end_date'] }}</td>
                <td class="px-4 py-3">{{ $event['number_of_people'] }}</td>
                </tr>
                @endforeach
              </tbody>
              </table>
            </div>
            @else
              <p class="text-sm">過去のイベントはありません。</p>
            @endif
          </div>
        </section>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
  