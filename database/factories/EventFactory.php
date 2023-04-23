<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $availableHour = $this->faker->numberBetween(10, 18); // 開始時間は10〜18時台で選択可能
        $minutes = [0, 30]; // 30分ごとに指定可能
        $mKey = array_rand($minutes); // $minutesからランダムにキーを取得
        $addHour = $this->faker->numberBetween(1, 3); // 1〜3時間の間でイベント時間を設定

        $dummyDate = $this->faker->dateTimeThisMonth; // 今月から日付を指定
        $startDate = $dummyDate->setTime($availableHour, $minutes[$mKey]); // 開始時間を指定
        $clone = clone $startDate; // 開始時間が書き換えられないようクローン
        $endDate = $clone->modify('+'.$addHour.'hour'); // 終了時間を設定

        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1, 20),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_visible' => $this->faker->boolean,
        ];
    }
}
