<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calender\TodayDataView;

class TodayDataController extends Controller
{
    public static function show_todayDatas() {
        $datas = new TodayDataView();
        return $datas->render();
    }
}
