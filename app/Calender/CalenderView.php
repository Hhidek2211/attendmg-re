<?php

namespace App\Calender;

use Carbon\Carbon;

class CalenderView {

    function __construct($date) {
        $this->carbon = new Carbon($date);
    }

    public function gettitle() {
        return $this-> carbon-> format('Y年n月');
    }

    //当月の日数及び曜日情報の取得、配列形式で出力
    protected function getDay() {
        $WeekDays = ["日", "月", "火", "水", "木", "金", "土"];
        $firstday = $this-> carbon-> copy()-> firstOfMonth();
        $lastday = $this-> carbon-> copy()-> lastOfMonth();
        for ($i = $firstday; $i <= $lastday; $i->addDay()){

            $day = $i->day;
            $dayOfWeek = $WeekDays[$i->dayOfWeek];
            //dump($day, $dayOfWeek);
            $days[] = [$day, $dayOfWeek];

        }
        return $days;
    }

    //カレンダーの出力情報
    function render() {
        $days = $this->getDay();

        $html[] = '<table class="min-w-full border border-2 border-gray-700">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th class="px-1 py-1 text-center text-sm font-medium text-gray-500 border">日</th>';
        $html[] = '<th class="px-1 py-1 text-center text-sm font-medium text-gray-500 border">曜日</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">出勤時間</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">退勤時間</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">休憩時間</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">残業時間</th>';
        $html[] = "</tr>";
        $html[] = "</thead>";
        $html[] = '<tbody class="divide-y divide-gray-200 dark:divide-gray-700">';
        foreach($days as $day) {
            $html[] = '<tr>';
            $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$day[0].'</td>';
            $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$day[1].'</td>';
            //$html[] = "<td></td>";
            //$html[] = "<td></td>";
            //$html[] = "<td></td>";
            $html[] = '</tr>';
        }
        $html[] = "</tbody>";
        $html[] = "</table>";
        return implode("", $html);
    }
}