<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    public const STATUS_ORDERED = 'ordered';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_DECLINED = 'declined';
    public const STATUS_PENDING = 'pending';

    protected $fillable = [
        'emp_id',
        'date',
        'type',
        'no_of_days',
        'from_time',
        'to_time',
        'status',
        'vacation_reason',
        'manager_notes',
        'period_ids'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id');
    }

    public function getPeriodIdsExplodedAttribute()
    {
        $periods = $this->period_ids;

        $final = [];
        foreach (explode(',', $periods)  as $key => $value) {
            $period = Period::find($value);
            $final[] = [
                'period_id' => $period->id,
                'period_name' => $period->name,
                'period_from_time' => $period->from_time,
                'period_to_time' => $period->to_time
            ];
        }
        return $final;
    }
    public function vacationType()
    {
        return $this->belongsTo(VacationType::class, 'type');
    }
}
