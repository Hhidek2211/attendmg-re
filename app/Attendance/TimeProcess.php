<?php

namespace App\Attendance;

use Carbon\Carbon;
use App\OverTime\CalcOver;

class TimeProcess {

//  << TodayDataの記録をレコードとして書き込む形に変換する. >>
    function __construct($records) {
        $this->today_data = $records;
        $this->result = $this->format_data();
    }

    //時間のフォーマット
    public function format_data() {
        $first = $this->today_data->first();
        $day = new Carbon($first->time);
        $result = [
            'day'=>$day,
            'start'=> new Carbon,
            'end'=> new Carbon, 
            'break'=> Carbon::createFromTime(0,0,0),
            'hour'=> Carbon::createFromTime(0,0,0),
        ];
        $pre = Carbon::createFromTime(0,0,0);

        //各データを処理
        foreach ($this->today_data as $data) {
            $time = new Carbon($data->time);
            switch($data->data_type) {
                case 0: //退勤.
                    $result['end'] = new Carbon($data->time);
                    $result['hour']->addSeconds($this->culc_sub($work_start, $data->time));
                    break;
                case 1: //出勤 ここで計算してるユーザーのID取得してます.
                    $this->user = $data->user_id;
                    $result['start'] = new Carbon($data->time);
                    $work_start = $data->time;
                    break;
                case 2: //休憩開始
                    $break_start = $data->time;
                    $result['hour']->addSeconds($this->culc_sub($result['start'], $break_start));
                    break;
                case 3: //休憩終了
                    $result['break']->addSeconds($this->culc_sub($break_start, $data->time));
                    $work_start = $data->time;
                    break;
            }
        }

        //その日の残業時間の算出
        $result['over'] = CalcOver::for_exceptionalday($result, $this->user);
        //dd($result);

        //フォーマット処理
        $result_f['day'] = $result['day']->format('Y-m-d');
        $result_f['start'] = $result['start']->format('H:i:s');
        $result_f['end'] = $result['end']->format('H:i:s');
        $result_f['break'] = $result['break']->format('H:i:s');
        $result_f['hour'] = $result['hour']->format('H:i:s');
        $result_f['over'] = $result['over']->format('H:i:s');
        $this->result_f = $result_f;

        return $result;
    }

    //デフォルト設定と比較して一分以上ずれているかチェック
    public function judge_except($bsset) {
        $comp = [
            'start'=> new Carbon($this->result_f['day'].' '.$bsset->work_start_time),
            'end'=> new Carbon($this->result_f['day'].' '.$bsset->work_end_time),
            'break'=> new Carbon($this->result_f['day'].' '.$bsset->break_time),
            'over'=> new Carbon($this->result_f['day'].' '.$bsset->over_time),
        ];
        //dd($comp, $this->result);
        $I = ['start', 'end', 'break', 'over'];
        foreach ($I as $i) {
            $sub = $this->culc_sub($this->result[$i], $bsset[$i]);
            if ($sub > 60) {
                return True;
            }
        }
        return False;
    }

    //時間差の計算
    public function culc_sub($start, $end) {
        $start = new Carbon($start);
        $end = new Carbon($end);

        $diffInSec = $start->diffInSeconds($end);
        $hour = floor($diffInSec / 3600);
        $minute = floor(($diffInSec % 3600) / 60);
        $second = $diffInSec % 60;

        return $diffInSec;
        //return Carbon::createFromTime($hour, $minute, $second);
    }
}