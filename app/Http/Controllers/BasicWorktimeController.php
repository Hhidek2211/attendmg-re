<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\BasicWorktime;
use App\Models\User;
use App\Http\Requests\BasicWorktimeRequest;


class BasicWorktimeController extends Controller
{
    public function show_setting(): View
    {
        //Viewに表示するデフォルト値の取得or生成
        if($this->judge_existset()) {
            $values = User::find(Auth::id());
            $values = $values->basic_worktimes()->get()->toArray();
        } else {
            for($i=0; $i<7; $i++) {
                $values[] = [
                    'week_of_day'=> $i,
                    'isleave'=> 0,
                    'work_start_time'=> '08:00:00',
                    'work_end_time'=> '17:00:00',
                    'break_time'=> '01:00:00'
                ];
            }
        }
        //dd($values);
        return view('basicSetting.setting', ['values'=> $values]);
    }

    //デフォルト設定の保存処理
    public function store_setting(BasicWorktimeRequest $requests): RedirectResponse
    {
        $BsWork = new BasicWorktime;

        //updateorcreateで中間テーブルのカラムを条件にする方法がわからんかったので
        //すでにデフォルト設定を保存しているかどうかで作成or更新の処理を分岐させる
        if($this->judge_existset()) {
            $BsWork->update_bsset($requests);
        } else {
            $BsWork->create_bsset($requests);
        }

        return redirect(RouteServiceProvider::HOME);
    }

    //デフォルト設定が保存されているかどうかの判定処理の切り出し -> 保存済みならTRUE
    public function judge_existset() {
        $auth = Auth::user();
        $BsWork = new BasicWorktime;

        if(empty($auth->basic_worktimes()->first())) {
            return False;
        } else {
            return True;
        }
    }
}
