<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
            $record = BasicWorktime::create([
                'week_of_day'=> $i,
                'isleave'=> False,
                'work_start_time'=> '08:00:00',
                'work_end_time'=> '17:00:00',
                'break_time'=> '01:00:00',
                'user_id'=> $userId,
            ]);
        }
    }

    //デフォルト設定レコードの更新
    public function update_bsset($requests) {
        $records = Auth::user()-> basic_worktimes()->get();

        for($i=0; $i<7; $i++) {
            $record = $records->where('week_of_day', $i)->first();
            $record->update([
                    'week_of_day'=> $requests->weekofday[$i],
                    'isleave'=> $requests->isleave[$i],
                    'work_start_time'=> $requests->start[$i],
                    'work_end_time'=> $requests->stop[$i],
                    'break_time'=> $requests->break[$i],
                    'user_id'=> $authid,
                    ]);
        }
    }

    //ここからその他処理
    protected $fillable = [
        'week_of_day',
        'isleave',
        'work_start_time',
        'work_end_time',
        'break_time',
        'user_id',
    ];

    //リレーションについての記述
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
