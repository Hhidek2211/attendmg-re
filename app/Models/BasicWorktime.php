<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BasicWorktime extends Model
{
    use HasFactory;

    //データに関する処理

    //デフォルト設定レコードの作成
    public function create_bsset($requests) {
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
                    'break_time'=> $requests->break[$i]
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
    ];

    //リレーションについての記述
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
