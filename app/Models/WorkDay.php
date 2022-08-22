<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'company_id'
    ];

    public function periods()
    {
        return $this->belongsToMany(Period::class, 'work_day_period');
    }


    public function workDayPeriods()
    {
        return $this->belongsToMany(Period::class, 'work_day_period');
        // return $this->belongsToMany(Period::class, 'work_day_period');
    }

    public function calHoursOfPeriods()
    {
        return $this->belongsToMany(Period::class, 'work_day_period');
        // return $this->belongsToMany(Period::class, 'work_day_period');
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
