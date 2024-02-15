<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExceptionalDay extends Model
{
    use HasFactory;

// << テーブル定義 >>
    protected $fillable = [
        'day',
        'isleave',
        'work_start_time',
        'work_end_time',
        'break_time',
        'user_id'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
