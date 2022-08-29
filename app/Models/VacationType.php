<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'no_of_days_in_year',
        'no_of_days_in_month'
    ];
}
