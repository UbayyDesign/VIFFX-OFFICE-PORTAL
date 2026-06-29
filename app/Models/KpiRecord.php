<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiRecord extends Model
{
    protected $fillable = ['user_id','metric_name','target','actual','period','notes'];
    public function user() { return $this->belongsTo(User::class); }
    public function getAchievementAttribute(): float {
        return $this->target > 0 ? round(($this->actual / $this->target) * 100, 1) : 0;
    }
}
