<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = ['title','description','start_time','end_time','location','color','created_by'];
    protected $casts = ['start_time' => 'datetime', 'end_time' => 'datetime'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
