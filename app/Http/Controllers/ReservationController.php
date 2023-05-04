<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail($id)
    {
        $event = Event::findOrFail($id);

        // イベントの予約済み人数の取得
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNull('canceled_date')
            ->groupBy('event_id')
            ->having('event_id', $id)
            ->first();

        if (isset($reservedPeople)) {
            // 予約可能人数 = 定員 - 予約済み人数
            $canBeReservedPeople = $event->max_people - $reservedPeople->number_of_people;
        } else {
            // 予約可能人数 = 定員
            $canBeReservedPeople = $event->max_people;
        }

        // ログインユーザーのこのイベントに関する予約情報(キャンセルされていない)の取得
        $isReserved = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->where('canceled_date', '=', null)
            ->latest()
            ->first();

        return view('event-detail', compact('event', 'canBeReservedPeople', 'isReserved'));
    }

    public function reserve(Request $request)
    {
        $event = Event::findOrFail($request->id);

        // イベントの予約済み人数の取得
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNull('canceled_date')
            ->groupBy('event_id')
            ->having('event_id', $request->id)
            ->first();

        // 予約済みの人がいない || 定員 >= 予約済み人数 + 予約しようとしている人数
        if (is_null($reservedPeople) || $event->max_people >= $reservedPeople->number_of_people + $request->reserved_people) {
            // 予約人数を登録
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request->id,
                'number_of_people' => $request->reserved_people,
            ]);
    
            session()->flash('status', 'イベントが登録されました。');
            return to_route('dashboard');
        } else {
            session()->flash('error', '予約人数が定員を超過しており予約できませんでした。');
            return to_route('dashboard');
        }

    }
}
