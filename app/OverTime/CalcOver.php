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
        $legalsecs_day = 8 * 3600; // 日8時間
        $legalsecs_week = 40 * 3600; // 週40時間
        $overtime_week = $week_hours_sec + $thatday_sec - $legalsecs_week;
        $overtime_day = $thatday_sec - $legalsecs_day;

        // 週４０時間を超えているなら超えている分残業時間に加算
        // そうでないとき、８時間を超えているならその超過分が残業時間
        // どちらでもないなら労働時間は０
        if($overtime_week > 0) {
            $oversec = min($overtime_week, $thatday_sec);
        } 
        elseif ($overtime_day > 0) {
            $oversec = $overtime_day;
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

    //BasicWorktimeの型（曜日番号を含むデータ）から作成する
    public static function for_basicWorktime($thatday_hour, $thatday_WofD, $week_datas) {  // $work = 労働時間(hh:mm:ss)

    //週の労働時間の計算

        // 判定する日まで（判定日を含まない）までの合計
        $sum_work_sec = 0;
        for($i=0; $i < $thatday_WofD; $i++) {

            $sum_work_sec += Self::format_time_toSec($week_datas[$i]->work_hour);

        }
        //dump($sum_work_sec / (60 * 60));

        //判定日の残業時間
        $thatday_sec = Self::format_time_toSec($thatday_hour);

        //基準時間の変数
        $legaltime_week = 40 * 60 * 60; //週４０時間以上は残業.
        $legaltime_day = 8 * 60 * 60;   //法定労働時間は８時間.
        $overtime_week = $sum_work_sec + $thatday_sec - $legaltime_week;
        $overtime_day = $thatday_sec - $legaltime_day;

        //dump($overtime_week / 3600);

        //週の基準を超えていたらその分が残業時間
        //そうでなくて一日の労働時間で８時間を超えた分は残業時間
        //どちらでもなければ０
        if ($overtime_week > 0) {

            $overtime_week = min($overtime_week, $thatday_sec);    //一日あたり取れる残業時間の最大はその日の労働時間.
            $hour = floor($overtime_week / 3600);
            $minute = floor(($overtime_week % 3600) / 60);
            $second = $overtime_week % 60;
            $ans = Carbon::createFromTime($hour, $minute, $second);
            return $ans->format('H:i:s');

        } elseif ($overtime_day > 0) {

            $hour = floor($overtime_day / 3600);
            $minute = floor(($overtime_day % 3600) / 60);
            $second = $overtime_day % 60;
            $ans = Carbon::createFromTime($hour, $minute, $second);
            return $ans->format('H:i:s');

        } else {

            return '00:00:00';

        }
    }
}