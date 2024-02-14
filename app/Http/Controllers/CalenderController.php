<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calender\CalenderView;
use App\Http\Controllers\TodayDataController;
use Illuminate\View\View;

class CalenderController extends Controller
{
    // ダッシュボードへの移動
    public function dashboard(): View
    {
        $calender = new CalenderView(time());
        $today = TodayDataController::show_todayDatas();

        return view('calender', ["calender" => $calender, "today"=> $today]);

    }

}
