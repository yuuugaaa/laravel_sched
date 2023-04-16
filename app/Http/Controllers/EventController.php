<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = DB::table('events')
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
        return view('manager.event.show', compact('event'));
    }

    public function edit(Event $event)
    {
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

    public function destroy(Event $event)
    {
        //
    }
}
