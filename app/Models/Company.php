<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'website',
        'avatar',
        'phone',
        'fax',
        'english_name',
        'about_arabic',
        'about_english',
        'address_arabic',
        'address_english',
        'inforation'
    ];
}
