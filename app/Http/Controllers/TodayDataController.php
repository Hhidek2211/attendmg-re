<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Calender\TodayDataView;
use App\Attendance\AttendButton;
use App\Providers\RouteServiceProvider;
use App\Models\TodayData;
use Carbon\Carbon;

class TodayDataController extends Controller
{
    //TodayData関連処理への引き渡し
    public static function show_todayDatas($userId) {
        $datas = new TodayDataView($userId);
        return $datas->render();
    }

    //タイムカードメニューの作成
    public static function render_attendButton($userId) {
        $type = TodayData::get_latest($userId)->data_type;
        $datas = new AttendButton($type);
        return $datas;
    }

    //タイムカード処理
    public function save_todaydata(Request $request) { 
        $type = $request->input('type');
        $userid = Auth::id();
        
        $record = TodayData::create([
            'user_id' => $userid,
            'data_type' => $type,
        ]);

        return redirect(route('dashboard'));
    }
}
