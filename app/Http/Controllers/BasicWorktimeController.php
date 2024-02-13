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
        return view('basicSetting.setting');
    }

    //デフォルト設定の保存処理
    public function store_setting(BasicWorktimeRequest $requests): RedirectResponse
    {
        $auth = Auth::user();
        $BsWork = new BasicWorktime;

        //updateorcreateで中間テーブルのカラムを条件にする方法がわからんかったので
        //すでにデフォルト設定を保存しているかどうかで作成or更新の処理を分岐させる
        if(empty($auth->basic_worktimes()->first())) {
            $BsWork->create_bsset($requests);
        } else {
            $BsWork->update_bsset($requests);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
