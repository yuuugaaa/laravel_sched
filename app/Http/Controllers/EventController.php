<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        // イベントごとの予約人数の合計の取得
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNull('canceled_date')
            ->groupBy('event_id');

        // 今日以降のイベントの取得
        $today = Carbon::today();
        $events = DB::table('events')
            // 予約人数の結合
            ->leftJoinSub($reservedPeople, 'reserved_people', function ($join) {
                $join->on('events.id', '=', 'reserved_people.event_id');
            })
            // 今日以降
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        return view('manager.event.index', compact('events'));
    }

    public function create()
    {
        return view('manager.event.create');
    }

    public function store(StoreEventRequest $request)
    {
        $eventDate = $request['event_date'];
        $startTime = $request['start_time'];
        $endTime = $request['end_time'];
        
        // イベントの重複チェック
        $check = EventService::checkEventDuplication($eventDate, $startTime, $endTime);

        // イベントの重複があればフォームに返す
        if ($check) {
            session()->flash('error', 'この時間帯には既に他の予約が存在します。');
            session()->flashInput($request->input());
            return view('manager.event.create');
        }

        // 日付と時間の結合
        $startDate = EventService::joinDateAndTime($eventDate, $startTime);
        $endDate = EventService::joinDateAndTime($eventDate, $endTime);

        Event::create([
            'name' => $request['event_name'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'information' => $request['information'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status', 'イベントが登録されました。');
        return to_route('event.index');
    }

    public function show(Event $event)
    {
        $today = Carbon::today()->format('Y年m月d日');
        return view('manager.event.show', compact('event', 'today'));
    }

    public function edit(Event $event)
    {
        $today = Carbon::today()->format('Y年m月d日');
        if ($event->eventDate < $today) {
            abort(404);
        }

        return view('manager.event.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $eventDate = $request['event_date'];
        $startTime = $request['start_time'];
        $endTime = $request['end_time'];
        
        // イベントの重複チェック
        $check = EventService::checkEventDuplication($eventDate, $startTime, $endTime, $event->id);
        
        // イベントの重複があればフォームに返す
        if ($check) {
            session()->flash('error', 'この時間帯には既に他の予約が存在します。');
            session()->flashInput($request->input());
            return view('manager.event.edit', compact('event'));
        }

        // 日付と時間の結合
        $startDate = EventService::joinDateAndTime($eventDate, $startTime);
        $endDate = EventService::joinDateAndTime($eventDate, $endTime);

        $target = Event::findOrFail($event->id);
        $target->name = $request['event_name'];
        $target->start_date = $startDate;
        $target->end_date = $endDate;
        $target->max_people = $request['max_people'];
        $target->information = $request['information'];
        $target->is_visible = $request['is_visible'];
        $target->save();

        session()->flash('status', 'イベントが更新されました。');
        return to_route('event.index');
    }

    public function past()
    {
        // イベントごとの予約人数の合計の取得
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNull('canceled_date')
            ->groupBy('event_id');

        // 今日以前のイベントの取得
        $today = Carbon::today();
        $events = DB::table('events')
            // 予約人数の結合
            ->leftJoinSub($reservedPeople, 'reserved_people', function ($join) {
                $join->on('events.id', '=', 'reserved_people.event_id');
            })
            // 今日以前
            ->whereDate('start_date', '<', $today)
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('manager.event.past', compact('events'));

    }

    public function destroy(Event $event)
    {
        //
    }
}
