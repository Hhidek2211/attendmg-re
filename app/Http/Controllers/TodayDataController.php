<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calender\TodayDataView;
use App\Attendance\AttendButton;

class TodayDataController extends Controller
{
    public static function show_todayDatas() {
        $datas = new TodayDataView();
        return $datas->render();
    }

    public static function render_attendButton($type) {
        $datas = new AttendButton($type);
        return $datas;
    }
}
