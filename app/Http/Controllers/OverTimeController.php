<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OverTimeController extends Controller
{
    /**
     * 残業時間の計算、及び月ごとの情報を保存する
     * Exceptionalday, Bsset等に使っているデータ形式を受け取って計算する
     */

    // 残業時間計算にまつわる一連の処理
    // 与えられた日の情報を元に自分が保存すべきデータを算出し保存する
    // 呼び出し元（＝ BasicWorktime or ExceptionalDay）に対してはその日の残業時間を返却する

    //データの更新時に実行し、該当月の残業時間データを更新する
    public function calc_overtime($day, $userId) {

    }
}
