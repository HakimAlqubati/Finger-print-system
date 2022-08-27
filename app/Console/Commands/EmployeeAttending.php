<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Period;
use App\Models\WorkDay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeAttending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:attending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To attending employees';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $periods = Period::where('company_id', 1)->get();

        $work_day_id = WorkDay::where('company_id', 1)->where('code', date('D'))->first()?->id;

        foreach ($periods as $key => $value) {
            $periodIds[] = $value->id;
        }
        $periodIds = implode(',', $periodIds);
        $strSelect = "select users.id,users.name, users.no_attendance_tracking , users.no_fingerprint_tracking, users.company_id, users.branch_id
         from users 
        where NOT EXISTS
        (select * from attendances where users.id = attendances.emp_id 
        and date(attendances.attendance_time) = DATE('$date') and attendances.period_id in ($periodIds))
        and users.role_id = 3 and users.active =1";
        $employees = DB::select($strSelect);

        foreach ($employees as $key_emp => $emp_value) {

            $no_attendance_tracking = $emp_value->no_attendance_tracking;
            $no_fingerprint_tracking = $emp_value->no_fingerprint_tracking;
            foreach ($periods as $per_key => $per_value) {
                if ($no_fingerprint_tracking == 1) {
                    Attendance::create([
                        'emp_id' => $emp_value->id,
                        'attendance_time' => DATE(date('Y-m-d',  strtotime($date)) . ' ' . $per_value->from_time),
                        'work_day_id' => $work_day_id,
                        'attendance_type' => Attendance::TYPE_ATTENDING,
                        'period_id' => $per_value->id,
                        'company_id' =>  $emp_value->company_id,
                        'status' => Attendance::STATUS_PRESENT,
                        'branch_id' => $emp_value->branch_id
                    ]);
                    Attendance::create([
                        'emp_id' => $emp_value->id,
                        'attendance_time' => DATE(date('Y-m-d',  strtotime($date)) . ' ' . $per_value->to_time),
                        'work_day_id' => $work_day_id,
                        'attendance_type' => Attendance::TYPE_LEAVING,
                        'period_id' => $per_value->id,
                        'company_id' =>  $emp_value->company_id,
                        'branch_id' => $emp_value->branch_id
                    ]);
                } else if ($no_fingerprint_tracking != 1 && $no_attendance_tracking != 1) {
                    Attendance::create([
                        'emp_id' => $emp_value->id,
                        'attendance_time' =>  DATE(date('Y-m-d',  strtotime($date)) . ' ' . '00:00:00'),
                        'work_day_id' => $work_day_id,
                        'attendance_type' => null,
                        'period_id' => $per_value->id,
                        'company_id' =>  $emp_value->company_id,
                        'branch_id' => $emp_value->branch_id,
                        'status' => Attendance::STATUS_ABSENT,
                    ]);
                }
            }
        }
    }
}
