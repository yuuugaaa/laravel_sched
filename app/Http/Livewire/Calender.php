<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use Carbon\CarbonImmutable;
use Livewire\Component;

class Calender extends Component
{
    public $currentDate;
    public $currentWeek;
    public $day;
    public $checkDay;
    public $dayOfWeek;
    public $oneWeekLater;
    public $events;

    public function mount()
    {
        // 今日と1週間後の日付を取得
        $this->currentDate = CarbonImmutable::today();
        $this->oneWeekLater = $this->currentDate->addDays(7);

        // 今日から1週間に登録されているイベントの取得
        $this->events = EventService::getWeekEvents($this->currentDate, $this->oneWeekLater);

        $this->currentWeek = [];

        // 今日から1週間の日付、判定用日付、曜日を配列に入れる
        for ($i = 0; $i < 7; $i++) {
            $this->day = $this->currentDate->addDays($i)->format('m月d日');
            $this->checkDay = $this->currentDate->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = $this->currentDate->addDays($i)->isoFormat('ddd');
            array_push($this->currentWeek, [
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
    }

    public function getDate($date)
    {
        // 選択された日とそこから1週間後の日付を取得
        $this->currentDate = CarbonImmutable::parse($date);
        $this->oneWeekLater = $this->currentDate->addDays(7);

        // 選択された日から1週間の間に登録されているイベントの取得
        $this->events = EventService::getWeekEvents($this->currentDate, $this->oneWeekLater);
        
        $this->currentWeek = [];

        // 選択された日付から1週間分の日付を配列に入れる
        for ($i = 0; $i < 7; $i++) {
            $this->day = $this->currentDate->addDays($i)->format('m月d日');
            $this->checkDay = $this->currentDate->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = $this->currentDate->addDays($i)->isoFormat('ddd');
            array_push($this->currentWeek, [
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.calender');
    }
}
