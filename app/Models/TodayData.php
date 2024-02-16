<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodayData extends Model
{
    use HasFactory;

/**
 *  ダッシュボード右側、今日の出勤履歴に必要なデータの取得及び、出退処理を担当するクラス（モデル）
 *  退勤時に退勤したユーザーのデータをbasic_worktimesまたはexceptional_daysに保存し、その日のデータは削除する
 *  レコードは一日ごとにリセットしたほうが良いかも？
 */


//  << 定義づけ以外の処理 >>
    //最新の一件を取得
    public static function get_latest($userId) {
        if(Self::exist_records($userId)) {
            $record = TodayData::where('user_id', $userId)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->first();
        } else {
            $record = new TodayData;
            $record->data_type = 0;
        }
        return $record;
    }

    //ダッシュボード用データ取得(10件取得)
    public static function get_userdata($userId) {
        if(Self::exist_records($userId)) {
            $records = TodayData::where('user_id', $userId)->orderby('created_at', 'DESC')->limit(10)->get();
            $records = $records->sortBy('created_at');
        } else {
            $records = [];
        }
        return $records;
      }

    public static function exist_records($userId) {
        if(empty(TodayData::where('user_id', $userId)->first())) {
            return false;
        } else {
            return true;
        }
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
