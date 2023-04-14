<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventService
{
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        // 新規イベントの時間帯に、既存イベントが既に存在する:true、存在しない:false
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime) // 既存イベントの終了時間 > 新規イベントの開始時間
            ->whereTime('start_date', '<', $endTime) // 既存イベントの開始時間 < 新規イベントの終了時間
            ->exists();
    }

    public static function joinDateAndTime($date, $time)
    {
        // 日付と時間を結合、フォーマット統一し、返す
        $join = $date. " ". $time;
        return Carbon::createFromFormat('Y-m-d H:i', $join);
    }
}
