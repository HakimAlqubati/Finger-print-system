<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'period_type',
        'from_time',
        'to_time',
        'company_id',
        'allowed_delay',
    ];
    public function workDays()
    {
        return $this->belongsToMany(WorkDay::class, 'work_day_period');
    }
}
