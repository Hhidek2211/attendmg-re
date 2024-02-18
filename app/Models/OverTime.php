<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OverTime extends Model
{
    use HasFactory;

    //当月分のデータを返す
    public static function get_todaydata($userId) {
        $now = Carbon::today();
        $datas = Self::where('user_id', $userId)
                     ->where('year', $now->format('Y'))
                     ->where('month', $now->format('m'))
                     ->first();
        return $datas;
    }

    protected $fillable = [
        'user_id',
        'year',
        'month',
        'hour',
    ];
}
