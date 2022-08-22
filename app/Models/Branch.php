<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'company_id',
        'fax',
        'english_name',
        'phone_number',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id');
    }
}
