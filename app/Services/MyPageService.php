<?php

namespace App\Services;

use Carbon\Carbon;

class MyPageService
{
  public static function reservedEvents($events, $string)
  {
    $reservedEvents = [];

    // 未来のイベント
    if ($string === 'future') {
      // 開始時間昇順にforeach
      foreach ($events->sortBy('start_date') as $event) {
        // キャンセルされていない && 終了時間が今以降
        if (is_null($event->pivot->canceled_date) && $event->end_date >= Carbon::now()->format('Y-m-d H:i:s')) {
          // 必要な情報を$reservedEventに格納
          $eventInfo = [
            'id' => $event->id,
            'name' => $event->name,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'number_of_people' => $event->pivot->number_of_people,
          ];
          array_push($reservedEvents, $eventInfo);
        }
      }
    }
    // 過去のイベント
    if ($string === 'past') {
      // 開始時間降順にforeach
      foreach ($events->sortByDesc('start_date') as $event) {
        // キャンセルされていない && 終了時間が今以前
        if (is_null($event->pivot->canceled_date) && $event->end_date < Carbon::now()->format('Y-m-d H:i:s')) {
          // 必要な情報を$reservedEventに格納
          $eventInfo = [
            'id' => $event->id,
            'name' => $event->name,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'number_of_people' => $event->pivot->number_of_people,
          ];
          array_push($reservedEvents, $eventInfo);
        }
      }
    }

    return $reservedEvents;
  }
}