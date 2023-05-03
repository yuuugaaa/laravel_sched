<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MyPageService;
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
}
