<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Calender\CalenderView;
use App\Http\Controllers\TodayDataController;
use Illuminate\View\View;

class CalenderController extends Controller
{
    // ダッシュボードへの移動
    public function dashboard(): View
    {
        //ダッシュボード画面に必要な情報の収集
        $calender = new CalenderView(time());
        $today = TodayDataController::show_todayDatas();
        $attend = TodayDataController::render_attendbutton(Auth::id());

        return view('calender', ["calender" => $calender, "today"=> $today, "attend"=> $attend]);

    }

}
