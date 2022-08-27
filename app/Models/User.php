<?php

namespace App\Models;

use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use stdClass;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_no',
        'company_id',
        'device_token',
        'role_id',
        'branch_id',
        'number_of_hours',
        'licence_image',
        'licence_number',
        'id_image',
        'id_expiration_date',
        'identity_number',
        'bank_account_number',
        'nationality',
        'salary',
        'gender',
        'comparing_image',
        'licence_expiration_date',
        'no_attendance_tracking',
        'active',
        'no_fingerprint_tracking',
        'job_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attendance()
    {
        // dd($this->hasOne(Attendance::class,  'emp_id'));
        return $this->hasOne(Attendance::class, 'emp_id');
    }

    public function getNameAttrubute()
    {
        return $this->name;
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'emp_id');
    }

    public function scopeAttendances($query)
    {
        return $query->get()->attendaces;
    }
}
