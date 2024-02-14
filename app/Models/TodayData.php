<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodayData extends Model
{
    use HasFactory;

//  << 定義づけ以外の処理 >>
    public static function get_latest($userId) {
        $record = TodayData::where('user_id', $userId)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->first();
        return $record;
    }


//  << モデル・テーブル定義のための処理 >>
    protected $table = 'today_datas';

    protected $fillable = [
        'user_id',
        'data_type',
        'time',
    ];

    //リレーション定義
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
