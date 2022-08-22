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
        'no_fingerprint_tracking'
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


    public function getRequestedWorkHoursAttribute()
    {


        $month = 8;
        $year = 2022;
        $sumHours = [];
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {

                $work_day_id = WorkDay::where('company_id', Auth::user()->id)->where('code', date('D', $time))->first()?->id;
                $obj = new stdClass();
                if ($work_day_id != null && WorkDayPeriod::where('work_day_id', $work_day_id)->get()->count() > 0) {
                    $obj->day_code = date('D', $time);
                    $obj->day_id = $work_day_id;
                    $obj->number_of_periods = WorkDayPeriod::where('work_day_id', $work_day_id)->get()->count();
                    $periods = WorkDay::where('code', date('D', $time))->first()->periods;
                    $hours = [];
                    foreach ($periods as $key => $value) {
                        $from_time = new DateTime(date('H:i', strtotime($value->from_time)));
                        $to_time = new DateTime(date('H:i', strtotime($value->to_time)));
                        $interval = $from_time->diff($to_time);
                        $res = date('H:i:s', strtotime($interval->h . ':' . $interval->i));

                        $hours[] = $res;
                    }

                    $sumHours[]  =  $this->getSumHours($hours);
                    $obj->hours = $hours;
                }
            }
        }
        if ($this->number_of_hours != null) {
            $requested_work_hours = $this->number_of_hours;
        } else {
            $requested_work_hours =  $this->getSumHours($sumHours);
        }
        return $requested_work_hours;
    }

    public function  getEmpHoursAttribute()
    {
        $data = Attendance::where('emp_id', $this->id)->get();

        $final_result = [];
        $hours_work_array = [];
        $leaving_early_array = [];
        $hours_delay_array = [];
        foreach ($data as   $value) {
            $obj = new stdClass();

            $attendance_date = date('d-m-Y', strtotime($value->attendance_time));
            $attendance_time = date('H:i', strtotime($value->attendance_time));
            $period_id = $value->period_id;
            $attendance_type = $value->attendance_type;

            $delay_time = $value->delay_time;
            $early_leaving = $value->early_leaving;

            //hours work
            $obj->attendance_type = $attendance_type;
            $obj->period_id = $period_id;
            $obj->attendance_date = $attendance_date;
            $obj->attendance_time = $attendance_time;

            //hours delay
            $delay_time != null  ?   $hours_delay_array[] = $delay_time : '';


            //hours leaving early
            $early_leaving != null  ?   $leaving_early_array[] = $early_leaving : '';

            $hours_work_array[$attendance_date . '-' . $period_id][] = $obj;
        }

        foreach ($hours_work_array as $key => $value) {

            $attending_time = new DateTime($value[0]->attendance_time);
            $leaving_type = new DateTime($value[1]->attendance_time);
            $interval = $attending_time->diff($leaving_type);
            $res = date('H:i:s', strtotime($interval->h . ':' . $interval->i));
            $final_result[] = $res;
        }

        return  [
            'work_hours' => $this->getSumHours($final_result),
            'delay_hours' => $this->getSumHours($hours_delay_array),
            'early_leaving' => $this->getSumHours($leaving_early_array),
        ];
    }

    public function getLateHoursAttribute()
    {
    }
    function getSumHours($times)
    {
        $minutes = 0; //declare minutes either it gives Notice: Undefined variable
        // loop throught all the times
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
