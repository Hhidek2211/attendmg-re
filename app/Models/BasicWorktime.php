<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BasicWorktime extends Model
{
    use HasFactory;

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
