<?php

namespace App\Calender;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BasicWorktimeController;
use App\Models\BasicWorktime;
use App\Models\User;
use App\Models\ExceptionalDay;

class CalenderView {

    function __construct($date, $userId) {
        $this->carbon = new Carbon($date);
        $this->user = $userId;
    }

    public function gettitle() {
        return $this-> carbon-> format('Y年n月');
    }

    //カレンダーの出力情報
    function render() {
        $datas = new UserData($this->user, $this->carbon->format('Y-m-d'));
        $datas = $datas->get_usercalender();
        //dd($datas);

        $html[] = '<table class="min-w-full border border-2 border-gray-700">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th class="px-1 py-1 text-center text-sm font-medium text-gray-500 border">日</th>';
        $html[] = '<th class="px-1 py-1 text-center text-sm font-medium text-gray-500 border">曜日</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">出勤時間</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">退勤時間</th>';
        $html[] = '<th class="px-4 py-1 text-center text-sm font-medium text-gray-500 border">休憩時間数</th>';
        $html[] = '<th class="px-6 py-1 text-center text-sm font-medium text-gray-500 border">残業時間</th>';
        $html[] = "</tr>";
        $html[] = "</thead>";
        $html[] = '<tbody class="divide-y divide-gray-200 dark:divide-gray-700">';

        //各日のデータ書き込み
        //その日の例外データが存在するならExceptionalDayのレコードを、そうでないならデフォルト設定を記述
        foreach($datas as $data) {
                $html[] = '<tr>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$data['day'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$data['dayOfWeek'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$data['start'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$data['end'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 dark:text-gray-200 border">'.$data['break'].'</td>';
                $html[] = '</tr>';
        }
        
        $html[] = "</tbody>";
        $html[] = "</table>";
        return implode("", $html);
    }
}