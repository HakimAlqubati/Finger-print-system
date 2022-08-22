<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Period;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendaces = Attendance::where('emp_id', Auth::user()->id)
            ->whereBetween('attendance_time', [DATE($_GET['from']),  DATE($_GET['to'])])
            ->get();

        $attendanceResult = [];
        foreach ($attendaces as $key => $value) {
            $obj = new stdClass();
            $obj->id = $value->id;
            $obj->emp_id = $value->emp_id;
            $obj->ddd = $value->attendance_time;
            $obj->attendance_date = date('d-m-Y', strtotime($value->attendance_time));
            $obj->attendance_time = date('H:i', strtotime($value->attendance_time));
            $obj->attendance_type = $value->attendance_type;
            $obj->work_day_id = $value->work_day_id;
            $obj->period_id = $value->period_id;
            $obj->avatar = $value->avatar;
            $attendanceResult[$obj->attendance_date][] = $obj;
        }


        return $attendanceResult;
    }


    public function last()
    {


        $last = Attendance::where('emp_id', Auth::user()->id)->get()->last();


        if (is_null($last) == 1) {
            return [
                'error' => 'there is no data',
            ];
        }

        $result = [
            'id' => $last->id,
            'emp_id' => $last->emp_id,
            'attendance_time' => $last->attendance_time,
            'work_day_id' => $last->work_day_id,
            'attendance_type' => $last->attendance_type,
            'period_id' => $last->period_id,
            'created_at' => $last->created_at,
            'updated_at' => $last->updated_at,
            'company_id' => $last->company_id,
            'branch_id' => $last->branch_id,
            'avatar' => $last->avatar,
            'related' => Attendance::where('emp_id', $last->emp_id)->where('work_day_id', $last->work_day_id)->where('emp_id', Auth::user()->id)->whereDate('created_at', $last->created_at)->get(),
        ];
        return $result;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $period = Period::find($request->period_id);


        if ($request->attendance_type == 'attending') {
            if ((date('H:i:s', strtotime($request->attendance_time)) >= $period->from_time) &&
                (date('H:i:s', strtotime($request->attendance_time)) <= $period->allowed_delay)
            ) {
                $status = Attendance::STATUS_PRESENT;
            } else if (date('H:i:s', strtotime($request->attendance_time)) > $period->allowed_delay) {
                $status = Attendance::STATUS_LATE;

                $allowed_delay = new DateTime(date('H:i:s',  strtotime($period->allowed_delay)));
                $attendance_time = new DateTime(date('H:i:s', strtotime($request->attendance_time)));
                $interval = $allowed_delay->diff($attendance_time);
                $delay_time = date('H:i:s',  strtotime($interval->h . ':' . $interval->i));
            } else if (date('H:i:s', strtotime($request->attendance_time)) < $period->from_time) {
                $status = Attendance::STATUS_EARLY;
            }

            if (Auth::user()->no_attendance_tracking == 1) {
                $attendance_time_result = DATE(date('Y-m-d',  strtotime($request->attendance_time)) . ' ' . $period->from_time);
            } else {
                $attendance_time_result = DATE($request->attendance_time);
            }
        } else if ($request->attendance_type == 'leaving') {
            $leaving_time = new DateTime(date('H:i:s',  strtotime($request->attendance_time)));
            $period_leaving_time = new DateTime(date('H:i:s', strtotime($period->to_time)));
            $interval = $period_leaving_time->diff($leaving_time);
            $early_leaving = date('H:i:s',  strtotime($interval->h . ':' . $interval->i));
            $status = null;

            if (Auth::user()->no_attendance_tracking == 1) {
                $attendance_time_result = DATE(date('Y-m-d',  strtotime($request->attendance_time)) . ' ' . $period->to_time);
            } else {
                $attendance_time_result = DATE($request->attendance_time);
            }
        }




        if (isset($request->avatar) && $request->avatar != null) {
            $name =   Str::random(15) . '.jpg';
            // decode the base64 file 
            $file = base64_decode(
                $request->avatar
            );
            Storage::put('public/users/'  .  $name,   $file);
            file_put_contents(public_path() . '/storage/users/' . $name, $file);
            $avatarFileName = 'users/' . $name;
        }

      
        $attendace =   Attendance::create([
            'emp_id' => Auth::user()->id,
            // 'attendance_time' => $request->attendance_time,
            'attendance_time' => $attendance_time_result,
            'work_day_id' => $request->work_day_id,
            'attendance_type' => $request->attendance_type,
            'period_id' => $period->id,
            'company_id' =>  Auth::user()->company_id,
            'status' => $status,
            'branch_id' => Auth::user()->branch_id,
            'delay_time' => isset($delay_time) ? $delay_time : null,
            'early_leaving' => isset($early_leaving) ? $early_leaving : null,
            'avatar' => isset($avatarFileName) ? $avatarFileName : null
        ]);

        return $attendace;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
