<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AttendanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'qr_code',
        'first_location',
        'second_location',
        'third_location',
        'ford_location',
        'branch_id',
        'company_id'
    ]; 

    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}
