<?php

namespace App\Calender;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BasicWorktimeController;
use App\Models\BasicWorktime;
use App\Models\User;
use App\Models\OverTime;
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
        $today = Carbon::today()->format('d');
        $overtime = OverTime::where('user_id', $this->user)
                            ->where('year', $this->carbon->format('Y'))
                            ->where('month', $this->carbon->format('m'))
                            ->first();

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
        //休日登録されているときは「休日」の表記のみ行う
        //その日の例外データが存在するならExceptionalDayのレコードを、そうでないならデフォルト設定を記述
        foreach($datas as $data) {
            // 文字色の指定
            $bg = "";
            if ($data['day'] > $today) {
                $color = "text-gray-400";
            } else {
                $color = "text-black";
                if ($data['day'] == $today) {
                    $bg = "bg-cyan-100";
                }
            }
            $html[] = '<tr class="'.$bg.'">';
            if($data['isleave'] == True) {
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 border">'.$data['day'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 border">'.$data['dayOfWeek'].'</td>';
                $html[] = '<td colspan="4" class="py-1 whitespace-nowrap text-sm text-center font-medium '.$color.' border">休日</td>';
            } 
            else {
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 border">'.$data['day'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 border">'.$data['dayOfWeek'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium '.$color.' border">'.$data['start'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium '.$color.' border">'.$data['end'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium '.$color.' border">'.$data['break'].'</td>';
                $html[] = '<td class="px-1 py-1 whitespace-nowrap text-sm text-center font-medium '.$color.' border">'.$data['over'].'</td>';
            }
            $html[] = '</tr>';
        }
        
        //カレンダー下の総残業時間
        $html[] = "</tbody>";
        $html[] = "</table>";
        $html[] = '<table class="border-2 mt-2">';
        $html[] = '<tr>';
        $html[] = '<th class="px-2 py-1 whitespace-nowrap text-sm text-center font-medium text-gray-800 border">現在の残業時間</th>';
        $html[] = '<th class="px-2 py-1 whitespace-nowrap text-sm text-center font-medium text-black border">'.$overtime->hour.'</th>';
        $html[] = '</tr>';
        $html[] = '</table>';
        return implode("", $html);
    }
}