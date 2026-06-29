<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    protected $connection = 'kpi';

    protected $table = 'report_details';

    protected $fillable = [
        'report_id',
        'nama_afp',
        'nama_nasabah',
        'status',
        'tgl_tf',
        'top_up',
        'progress_terakhir',
        'strategi_closing',
        'note',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
