<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\BasicWorktime;
use App\Http\Requests\BasicWorktimeRequest;


class BasicWorktimeController extends Controller
{
    public function show_setting(): View
    {
        return view('basicSetting.setting');
    }

    //デフォルト設定の保存処理
    public function store_setting(BasicWorktimeRequest $requests): RedirectResponse
    {
        //dd($requests);
        $authid = Auth::id();

        for($i=0; $i<7; $i++) {
            $record = BasicWorktime::create([
                'week_of_day'=> $requests->weekofday[$i],
                'isleave'=> $requests->isleave[$i],
                'work_start_time'=> $requests->start[$i],
                'work_end_time'=> $requests->stop[$i],
                'break_time'=> $requests->break[$i]
            ]);

            $record->users()->attach($authid);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
