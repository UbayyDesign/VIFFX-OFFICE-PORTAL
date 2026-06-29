<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title','description','icon','icon_bg','is_new','created_by'];
    protected $casts = ['is_new' => 'boolean'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
