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
        // イベント情報と予約情報を取得
        $event = Event::findOrFail($id);
        $reservation = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->latest()
            ->first();
        // 過去未来の判定のため今の時刻を取得
        $now = Carbon::now()->format('Y-m-d H:i:s');

        return view('mypage.show', compact('event', 'reservation', 'now'));
    }

    public function cancel($id)
    {
        // 予約情報を取得
        $reservation = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->latest()
            ->first();
        // DBにキャンセル日時を追加
        $reservation->canceled_date = Carbon::now()->format('Y-m-d H:i:s');
        $reservation->save();

        session()->flash('status', 'キャンセルが完了しました。');
        return to_route('mypage.index');
    }
}
