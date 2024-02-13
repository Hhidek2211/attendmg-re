<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calender\CalenderView;
use Illuminate\View\View;

class CalenderController extends Controller
{
    // ダッシュボードへの移動
    public function dashboard(): View
    {
        $calender = new CalenderView(time());

        return view('calender', ["calender" => $calender]);

    }

}
