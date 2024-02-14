<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Calender\CalenderView;
use App\Http\Controllers\TodayDataController;
use Illuminate\View\View;

class CalenderController extends Controller
{
    //カレンダーの取得
    public static function get_calender() {
        $calender = new CalenderView(time());
        return $calender;
    } 

}
