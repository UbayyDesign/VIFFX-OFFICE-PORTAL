<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name','email','phone','position_applied','status','interview_date','notes','cv_path'];
    protected $casts = ['interview_date' => 'date'];
}
