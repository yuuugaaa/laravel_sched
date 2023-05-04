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
              
                      {{--<form method="get" action="{{ route('event.edit', [ 'event' => $event->id ]) }}">--}}
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
                          <div class="pb-4">
                              <x-label for="information" value="イベント詳細" />
                              <div class="block mt-1 w-full">{!! nl2br(e($event->information)) !!}</div>
                          </div>
                          <div class="sm:flex">
                              <div class="pb-4">
                                  <x-label for="max_people" value="予約人数" />
                                  <div class="block mt-1 w-full">{{ $reservation->number_of_people }}</div>
                              </div>
                          </div>
                          {{--あとで変える--}}
                          @if ($event->start_time < $now)
                          <div class="flex pt-3 w-full mx-auto">
                              <button class="flex mx-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">キャンセル</button>
                          </div>
                          @endif
                      {{--</form>--}}
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
  