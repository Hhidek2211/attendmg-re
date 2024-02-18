<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Calender\TodayDataView;
use App\Attendance\AttendButton;
use App\Attendance\TimeProcess;
use App\Providers\RouteServiceProvider;
use App\Models\TodayData;
use App\Models\BasicWorktime;
use App\Models\ExceptionalDay;
use Carbon\Carbon;

class TodayDataController extends Controller
{
    //TodayData関連処理への引き渡し
    public static function show_todayDatas($userId) {
        $datas = new TodayDataView($userId);
        return $datas->render();
    }

    //タイムカードメニューの作成
    //最新のtoday_datasを取得してそのtypeに応じてタイムカードのレンダリングを決定する
    public static function render_attendButton($userId) {
        $type = TodayData::get_latest($userId)->data_type;
        $datas = new AttendButton($type);
        return $datas;
    }

    //タイムカード処理
    //退勤 or 休日登録ならばデータのリセットに移行
    //休日登録時も同様
    public function save_todaydata(Request $request) { 
        $type = $request->input('type');
        $userId = Auth::id();
        
        $record = TodayData::create([
            'user_id' => $userId,
            'data_type' => $type,
            'time'=> Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        if($type == 0 or $type == 4) {
            $this->leaving_work($userId);
        } 

        return redirect(route('dashboard'));
    }

    //一分以上デフォルト設定とずれがあればexceptional_daysに保存、そうでなければデフォルト設定を流用( = 何も保存しない)
    public function leaving_work($userId) {
        $records = TodayData::where('user_id', $userId)->get();

        $datas = new TimeProcess($records);
        $bsset = BasicWorktime::get_thatdaySet(Auth::id(), $datas->result['day']);
        
        if ($datas->judge_except($bsset)) {
            ExceptionalDay::create([
                'day'=> $datas->result_f['day'],
                'isleave'=> $datas->result_f['isleave'],
                'work_start_time'=> $datas->result_f['start'],
                'work_end_time'=> $datas->result_f['end'],
                'break_time'=> $datas->result_f['break'],
                'work_hour'=> $datas->result_f['hour'],
                'over_time'=> $datas->result_f['over'],
                'user_id'=> $userId
            ]);
        }

        $OverTime = OverTimeController::calc_overtime($datas->result_f['day'], $userId);
        
        //その日のデータを削除
        $records = TodayData::where('user_id', $userId)->delete();

    }
}
