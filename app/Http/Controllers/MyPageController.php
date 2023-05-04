<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use App\Services\MyPageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index()
    {
        // ユーザーが予約したイベントを取得
        $user = User::findOrFail(Auth::id());
        $events = $user->events;
        // 過去と未来のイベントに切り分け
        $futureEvents = MyPageService::reservedEvents($events, 'future');
        $pastEvents = MyPageService::reservedEvents($events, 'past');

        return view('mypage.index', compact('futureEvents', 'pastEvents'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $reservation = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->first();

        $now = Carbon::now()->format('Y-m-d H:i:s');

        return view('mypage.show', compact('event', 'reservation', 'now'));
    }
}
