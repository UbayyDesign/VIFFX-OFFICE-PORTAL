<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'kpi';

    protected $fillable = [
        'user_id',
        'team_id',
        'report_date',
        'total_new_data',
    ];

    protected $with = ['details'];

    public function details()
    {
        return $this->hasMany(ReportDetail::class);
    }
}
