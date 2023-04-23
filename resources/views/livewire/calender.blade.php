<div>
    <input id="calender" type="text" name="calender" class="block text-center mb-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        value="{{ $currentDate->format('Y-m-d') }}" wire:change="getDate($event.target.value)" />
    <div class="flex w-full">
        <x-calender-time />
        @for ($i = 0; $i < 7; $i++)
            <div class="w-3/5">
                <div class="py-1 h-8 border border-gray-100 text-center">{{ $currentWeek[$i]['day'] }}</div>
                <div class="py-1 h-8 border border-gray-100 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div>
                @for ($j = 0; $j < 24; $j++)
                    @if ($events->isNotEmpty())
                        @php
                            // 該当の日時と開始時間が同じイベントを取得
                            $event = $events->firstWhere('start_date', $currentWeek[$i]['checkDay']. " ". \Constant::EVENT_TIME[$j]);
                        @endphp
                        @if (!is_null($event))
                            <div class="py-1 h-8 border border-gray-100 text-center text-sm bg-indigo-50">
                                {{ $event->name }}
                            </div>
                            @php
                                // イベントの時間を取得し、30分で割って枠の個数を求め、イベント名が入るdivタグ分の1を引く
                                $eventPeriod = \Carbon\Carbon::parse($event->start_date)->diffInMinutes($event->end_date) / 30 - 1;
                            @endphp
                            @if ($eventPeriod > 0)
                                @for ($k = 0; $k < $eventPeriod; $k++)
                                    <div class="py-1 h-8 border border-gray-100 text-center text-sm bg-indigo-50"></div>
                                @endfor
                                @php
                                    // 増えたdivタグ分$jを増やす
                                    $j += $eventPeriod;
                                @endphp
                            @endif

                        @else
                            <div class="py-1 h-8 border border-gray-100 text-center text-sm"></div>
                        @endif
                    @else
                        <div class="py-1 h-8 border border-gray-100 text-center text-sm"></div>
                    @endif
                @endfor
            </div>
        @endfor
    </div>
</div>
