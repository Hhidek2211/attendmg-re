<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OverTimeController;
use App\Models\User;
use App\OverTime\CalcOver;
use App\Leaving\Leaving;
use Carbon\Carbon;

class BasicWorktime extends Model
{
    use HasFactory;

//  <<データに関する処理>>

    //デフォルト設定の有無の確認 -> 存在しないなら初期値を設定する(レコードを作成する)
    //そして作成or存在したデータを返す
    public static function get_userdata($userId) {
        if(empty(BasicWorktime::where('user_id', $userId)->first())) {
            Self::create_bsset($userId);
        }
        $values = Self::where('user_id', $userId)->get();
        return $values;
    }

    //デフォルト設定レコードの作成
    public static function create_bsset($userId) {
        for($i=0; $i<7; $i++) {
            $week_datas = Self::where('user_id', $userId)->get();
            $over = CalcOver::for_basicWorktime('08:00:00', $i, $week_datas);
            if(in_array($i, [0, 6])) {
                $isleave = True;
            } else {
                $isleave = False;
            }

            //休暇にあたるかどうかで代入する値を変更する
            if($isleave) {
                $datas = Leaving::set_values();
            } else {
            $datas = [
                'isleave'=> $isleave,
                'start'=> '08:00:00',
                'end'=> '17:00:00',
                'break'=> '01:00:00',
                'hour'=> '08:00:00',
                'over'=> $over,
                ];
            }

            $record = BasicWorktime::create([
                'week_of_day'=> $i,
                'isleave'=> $isleave,
                'work_start_time'=> $datas['start'],
                'work_end_time'=> $datas['end'],
                'break_time'=> $datas['break'],
                'work_hour'=> $datas['hour'],
                'over_time'=> $datas['over'],
                'user_id'=> $userId,
            ]);
        }

        //残業時間データの初期作成
        $today = Carbon::today()->format('Y-m-d');
        OverTimeController::calc_overtime($today, $userId);
    }

    //デフォルト設定レコードの更新
    public function update_bsset($requests, $userId) {
        $records = Self::where('user_id', $userId)->get();
        for($i=0; $i<7; $i++) {
            $record = $records->where('week_of_day', $i)->first();
            $isleave = $requests->isleave[$i];
            $hour = Self::calc_workhour($requests->start[$i], $requests->stop[$i], $requests->break[$i]);
            $over = CalcOver::for_basicWorktime($hour, $requests->weekofday[$i], $records);

            if($isleave) {
                $datas = Leaving::set_values();
            } else {
                $datas = [
                    'isleave'=> $isleave,
                    'start'=> $requests->start[$i],
                    'end'=> $requests->stop[$i],
                    'break'=> $requests->break[$i],
                    'hour'=> $hour,
                    'over'=> $over,
                ];
            }

            $record->update([
                    'week_of_day'=> $requests->weekofday[$i],
                    'isleave'=> $isleave,
                    'work_start_time'=> $datas['start'],
                    'work_end_time'=> $datas['end'],
                    'break_time'=> $datas['break'],
                    'work_hour'=> $datas['hour'],
                    'over_time'=> $datas['over'],
                    'user_id'=> $userId,
                    ]);
        }
        
        
        //残業時間データの更新
        $today = Carbon::today()->format('Y-m-d');
        OverTimeController::calc_overtime($today, $userId);
    }

    //指定日のデフォルト設定の取得
    public static function get_thatdaySet($userId, $day) {
        $day = new Carbon($day);
        $bsset = Self::where('user_id', $userId)
                     ->where('week_of_day', $day->dayOfWeek)
                     ->first();
        return $bsset;
    }

    //更新時の労働時間を取得する
    public static function calc_workhour($start, $end, $break) {
        $start = new Carbon($start);
        $end = new Carbon($end);
        $break = new Carbon($break);
        $zero = $break->today();

        $sum_sec = $start->diffInSeconds($end);
        $break = $break->diffInSeconds($zero);
        $sum_sec = $sum_sec - $break;

        $hour = floor($sum_sec / 3600);
        $minute = floor(($sum_sec % 3600) / 60);
        $second = $sum_sec % 60;

        $ans = Carbon::createFromTime($hour, $minute, $second);
        return $ans->format("H:i:s");
    }

    //ここからその他処理
    protected $fillable = [
        'week_of_day',
        'isleave',
        'work_start_time',
        'work_end_time',
        'break_time',
        'work_hour',
        'over_time',
        'user_id',
    ];

    //リレーションについての記述
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
