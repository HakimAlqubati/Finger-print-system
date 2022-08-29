<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public const TYPE_ATTENDING = 'attending';
    public const TYPE_LEAVING = 'leaving';


    public const STATUS_PRESENT = 'present';
    public const STATUS_ABSENT = 'absent';
    public const STATUS_ON_VOCATION = 'on_vocation';
    public const STATUS_LATE = 'late';
    public const STATUS_EARLY = 'early';


    protected $fillable = [
        'emp_id',
        'attendance_time',
        'work_day_id',
        'attendance_type',
        'period_id',
        'company_id',
        'branch_id',
        'status',
        'delay_time',
        'early_leaving',
        'permissions_hours',
        'overtime_hours',
        'holiday_hours',
        'avatar',
        'vacation_id'
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
