<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\TodayDataController;
use App\Calender\CalenderView;


// ダッシュボードに移動するときの処理のあれこれの受け渡し
class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $calender = CalenderController::get_calender();
        $today = TodayDataController::show_todayDatas(Auth::id());
        $attend = TodayDataController::render_attendbutton(Auth::id());

        return view('dashboard', ["calender" => $calender, "today"=> $today, "attend"=> $attend, "name"=> Auth::user()->name]);
    }
}
