<?php

namespace App\OverTime;

use App\Calender\UserData;
use Carbon\Carbon;

class CalcOver {

    function __construct($day, $userId) {
        //$this->user = $userId;
        //$this->over = $this->calc_day($day);
    }

    //与えられた日の残業時間を計算する
    //一日８時間以上 or 週４０時間以上の時は残業になる
    public static function for_exceptionalday($data, $userId) {    //day, start, end, break, hourのCarbonインスタンスたちからなる配列を取得（= TimeProcessのフォーマット前データ）
        //dd($data);
        $week_datas = new UserData($userId, $data['day']);
        $week_datas = $week_datas->get_weekdata_tothatday();    //引数$dataの日までの週のデータ($dataの日は除く).

        $week_hours_sec = 0;
        foreach($week_datas as $week_data) {
            //dd($week_data);
            $week_hours_sec += Self::format_time_toSec($week_data->work_hour);
        }
        $thatday_sec = Self::format_time_toSec($data['hour']->format('H:i:s'));
        //dump($data['hour']);
        //dd($thatday_sec);
        $week_work_times = $week_hours_sec + $thatday_sec;
        $legalsecs_day = 8 * 3600; // 日8時間
        $legalsecs_week = 40 * 3600; // 週40時間

        // 週４０時間を超えているなら超えている分残業時間に加算
        // そうでないとき、８時間を超えているならその超過分が残業時間
        // どちらでもないなら労働時間は０
        if($week_work_times > $legalsecs_week) {
            $oversec = $week_work_times - $legalsecs_week;
        } 
        elseif ($thatday_sec > $legalsecs_day) {
            $oversec = $thatday_sec - $legalsecs_day;
        }
        else {
            $oversec = 0;
        }

        $ans_hour = floor($oversec / 3600);
        $ans_minute = floor(($oversec % 3600) / 60);
        $ans_second = $oversec % 60;
        
        //dd($ans_hour, $ans_minute, $ans_second);
        return Carbon::createFromTime($ans_hour, $ans_minute, $ans_second);
    }

    public static function format_time_toSec($hour) {
        $seconds = explode(":", $hour);
        $seconds[0] = (int)$seconds[0] * 60 * 60;
        $seconds[1] = (int)$seconds[1] * 60;
        $seconds[2] = (int)$seconds[2];
        return array_sum($seconds); 
    }

    //その日の労働時間についてのみ考える
    //⇒ 週４０時間を超えたパターンは例外として考えることにする
    public static function for_basicWorktime($work) {
        $work = new Carbon($work);
        $zero = $hour->today();
        $work_sec = $hour->diffInSeconds($zero);

        $legaltime = 8 * 60 * 60;   //法定労働時間は８時間.
        $overtime = $sec - $legaltime;

        if ($overtime > 0) {

            $hour = floor($overtime / 3600);
            $minute = floor(($overtime % 3600) / 60);
            $second = $overtime % 60;
            $ans = Carbon::createFromTime($hour, $minute, $second);
            return $ans->format('H:i:s');

        } else {

            return '00:00:00';

        }
    }
}