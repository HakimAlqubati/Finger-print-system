<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
    use HasFactory;

    public const STATUS_ORDERED = 'ordered';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_DECLINED = 'declined';
    public const STATUS_PENDING = 'pending';

    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id');
    }
    
    protected $fillable = [
        'emp_id',
        'date',
        'amount',
        'reason',
        'status',
    ];
}
