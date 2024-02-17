<?php

namespace App\Calender;

use Carbon\Carbon;
use App\Http\Controllers\BasicWorktimeController;
use App\Models\ExceptionalDay;

class UserData {

    function __construct($userId, $time) {
        $this->user = $userId;
        $this->carbon = new Carbon($time);
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
            $days[] = [$day, $dayOfWeek, $i->dayOfWeek];

        }
        return $days;
    }

    //指定された日までの週の情報を取得（指定された日は除く）.
    public function get_weekdata_tothatday() {
        $thatday = $this->carbon;
        $sunday = new Carbon($thatday->toDateString());
        $sunday->subDay($thatday->dayOfWeek);
        $basics = BasicWorktimeController::get_bsset($this->user);
        $excepts = ExceptionalDay::get_exceptdays($this->user);

        for($i = $sunday; $i < $thatday; $i->addDay()) {
            if(in_array($i->day, $excepts)) {
                $datas[] = ExceptionalDay::where('day', $i->format('Y-m-d'))->first();
            } else {
                $datas[] = $basics[$i->dayOfWeek];
            }            
        }
        
        return $datas;
    }

    //指定日までのカレンダー情報の取得（指定日を含む）.
    public function get_calender_tothatday() {
        $thatday = $this->carbon;
        $firstday = $this-> carbon-> copy()-> firstOfMonth();
        $basics = BasicWorktimeController::get_bsset($this->user);
        $excepts = ExceptionalDay::get_exceptdays($this->user);

        for($i = $firstday; $i <= $thatday; $i->addDay()) {
            if(in_array($i->day, $excepts)) {
                $datas[] = ExceptionalDay::where('day', $i->format('Y-m-d'))->first();
            } else {
                $datas[] = $basics[$i->dayOfWeek];
            }            
        }

        return $datas;
        
    }
    
    //ユーザーの今月のカレンダーデータを取得
    public function get_usercalender() {
        $days = $this->getDay();
        $month = $this->carbon->format('Y-m');
        $basics = BasicWorktimeController::get_bsset($this->user);
        $excepts = ExceptionalDay::get_exceptdays($this->user);

        foreach($days as $day) {
            if(in_array($day[0], $excepts)) {
                $data = ExceptionalDay::where('day', $month.'-'.$day[0])->first();
            } else {
                $data = $basics[$day[2]];
            }
            $calender[] = [
                'day' => $day[0],
                'dayOfWeek' => $day[1],
                'dayOfWeek_num'=> $day[2],
                'start'=> $data->work_start_time,
                'end'=> $data->work_end_time,
                'over'=> $data->over_time,
                'break'=> $data->break_time,
            ];
        }  

        return $calender;
    }
}