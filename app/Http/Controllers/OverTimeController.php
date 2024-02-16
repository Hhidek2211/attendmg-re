<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calender\UserData;
use App\Models\OverTime;

class OverTimeController extends Controller
{
    /**
     * 残業時間の計算、及び月ごとの情報を保存する
     * Exceptionalday, Bsset等に使っているデータ形式を受け取って計算する
     */

    // 残業時間計算にまつわる一連の処理
    // 与えられた日の情報を元に自分が保存すべきデータを算出し保存する
    // 呼び出し元（＝ BasicWorktime or ExceptionalDay）に対してはその日の残業時間を返却する

    //データの更新時に実行し、該当月の残業時間データを更新する
    public static function calc_overtime($thatday, $userId) {
        $calender = new UserData($userId, $thatday);
        $calender = $calender->get_calender_tothatday();
        
        $sum_overtime_sec = 0;
        foreach ($calender as $day) {
            $time = $day->over_time;
            $time = explode(":", $time);

            //秒数に変換
            $time[0] = $time[0] * 3600;
            $time[1] = $time[1] * 60;

            $sum_overtime_sec += array_sum($time);
        }

        //時間表記に戻す
        $hour = sprintf('%02d', floor($sum_overtime_sec / 3600));
        $minute = sprintf('%02d', floor(($sum_overtime_sec % 3600) / 60));
        $second = sprintf('%02d', $sum_overtime_sec % 60);
        $overtime = $hour.':'.$minute.':'.$second;
        
        $thatday = explode("-", $thatday);

        OverTime::updateOrCreate(
            ['user_id'=> $userId],
            [   
                'user_id'=> $userId,
                'year'=> $thatday[0],
                'month'=> $thatday[1],
                'hour'=> $overtime
                ]
        );
    }
}
