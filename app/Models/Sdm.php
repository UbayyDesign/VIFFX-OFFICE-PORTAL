<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sdm extends Model
{
    protected $connection = 'kpi';

    protected $table = 'sdms';

    protected $fillable = [
        'nama',
        'tipe',
        'tanggal_masuk',
        'user_id',
        'team_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
