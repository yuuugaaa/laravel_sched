<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventService
{
    public static function checkEventDuplication($eventDate, $startTime, $endTime, $eventId=0)
    {
        /**
         * ○時間帯が重複しているかどうかチェックする
         *  フォームで選択した時間帯に、
         *  ・既存イベントが存在する場合：既存イベントのモデルを取得
         *  ・既存イベントが存在しない場合：null
         */ 
        $check = DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime) // 既存イベントの終了時間 > 新規イベントの開始時間
            ->whereTime('start_date', '<', $endTime) // 既存イベントの開始時間 < 新規イベントの終了時間
            ->first();

        /**
         * ○新規登録時
         *  ・$eventIdを渡さない（デフォルトで0が入る）
         *  ・時間帯が重複している：true
         */
        if ($eventId === 0) {
            return isset($check);
        }

        /**
         * ○更新時
         *  ・$eventIdには更新するイベントのIDを渡す
         *  ・時間帯が重複している && 重複しているイベントと更新するイベントが同じでない：true
         */
        if ($eventId) {
            return isset($check) && $check->id !== $eventId;
        }
    }

    public static function joinDateAndTime($date, $time)
    {
        // 日付と時間を結合、フォーマット統一し、返す
        $join = $date. " ". $time;
        return Carbon::createFromFormat('Y-m-d H:i', $join);
    }
}
