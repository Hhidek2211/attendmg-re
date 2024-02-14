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
    //デフォルト設定Viewの表示
    public function show_setting(): View
    {
        $bssets = new BasicWorktime;
        $bssets = $bssets->get_userdata(Auth::id());
 
        //dd($values);
        return view('basicSetting.setting', ['values'=> $bssets]);
    }

    //カレンダー等に表示するためのデータを渡す
    //これいらないかも… 直にモデルにアクセスされるの気持ち悪くて作っただけ
    public static function get_bsset($userId) {
        $values = BasicWorktime::get_userdata($userId);
        return $values;
    }

    //デフォルト設定の保存処理 -> 更新しかありえなくなったので更新のみで大丈夫なはず
    public function store_setting(BasicWorktimeRequest $requests): RedirectResponse
    {
        $BsWork = new BasicWorktime;
        $BsWork->update_bsset($requests);

        return redirect(RouteServiceProvider::HOME);
    }

    //デフォルト設定が存在しているかどうかの判定処理の切り出し -> 保存済みならTRUE
    //恐らく不要　時を見て削除すべき
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
