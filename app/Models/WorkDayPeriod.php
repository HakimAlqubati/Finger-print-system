<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDayPeriod extends Model
{
    use HasFactory;
    protected $table = 'work_day_period';
    protected $fillable = [
        'work_day_id',
        'period_id'
    ];

    public $timestamps = false;
}
