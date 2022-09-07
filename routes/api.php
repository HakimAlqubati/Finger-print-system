<?php

use App\Http\Controllers\AdvancePaymentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\NotificationControler;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\VacationTypeController;
use App\Http\Controllers\WorkDayController;
use App\Http\Controllers\WorkDayPeriodController;
use App\Models\Attendance;
use App\Models\Period;
use App\Models\User;
use App\Models\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('/get-test', function () {

//     $date = date('Y-m-d');
//     $periods = Period::where('company_id', 1)->get();
//     $countPeriods = count($periods);
//     $work_day_id = WorkDay::where('company_id', 1)->where('code', date('D'))->first()?->id;

//     foreach ($periods as $key => $value) {
//         $periodIds[] = $value->id;
//     }
//     $periodIds = implode(',', $periodIds);
//     $strSelect = "SELECT  users.id as user_id, users.name, users.no_attendance_tracking , users.no_fingerprint_tracking, users.company_id, 
//     users.branch_id , attendances.period_id as 'period_id_register' , attendances.id ,periods.id  as period_id_not_register 
//     from users left join attendances 
//     on attendances.emp_id = users.id and date(attendances.attendance_time) = DATE('2022-08-28')
//     left join work_days
//     on attendances.work_day_id = work_days.id
//     left JOIN work_day_period on work_days.id = work_day_period.work_day_id
//     left join periods on periods.id = work_day_period.period_id and periods.id not in (select period_id from attendances where users.id = attendances.emp_id
//     and date(attendances.attendance_time) = DATE('2022-08-28'))
//     where NOT EXISTS
//     (select * from attendances where users.id = attendances.emp_id
//     and date(attendances.attendance_time) = DATE('2022-08-28') and
//     (select count(id) from attendances where users.id = attendances.emp_id
//     and date(attendances.attendance_time) = DATE('2022-08-28') and attendances.period_id in ($periodIds)) >= $countPeriods)
//     and users.role_id = 3 and users.active =1
//     and !(attendances.period_id is not null and periods.id is  null)";

//     $employees = DB::select($strSelect);

//     // return $employees;
//     foreach ($employees as $key_emp => $emp_value) {
//         $no_attendance_tracking = $emp_value->no_attendance_tracking;
//         $no_fingerprint_tracking = $emp_value->no_fingerprint_tracking;
//         $period_id_not_register = $emp_value->period_id_not_register;
//         if ($period_id_not_register == null) {
//             foreach ($periods as $per_key => $per_value) {
//                 if ($no_fingerprint_tracking == 1) {
//                     Attendance::create([
//                         'emp_id' => $emp_value->user_id,
//                         'attendance_time' => DATE(date('Y-m-d',  strtotime($date)) . ' ' . $per_value->from_time),
//                         'work_day_id' => $work_day_id,
//                         'attendance_type' => Attendance::TYPE_ATTENDING,
//                         'period_id' => $per_value->id,
//                         'company_id' =>  $emp_value->company_id,
//                         'status' => Attendance::STATUS_PRESENT,
//                         'branch_id' => $emp_value->branch_id
//                     ]);
//                     Attendance::create([
//                         'emp_id' => $emp_value->user_id,
//                         'attendance_time' => DATE(date('Y-m-d',  strtotime($date)) . ' ' . $per_value->to_time),
//                         'work_day_id' => $work_day_id,
//                         'attendance_type' => Attendance::TYPE_LEAVING,
//                         'period_id' => $per_value->id,
//                         'company_id' =>  $emp_value->company_id,
//                         'branch_id' => $emp_value->branch_id
//                     ]);
//                 } else if ($no_fingerprint_tracking != 1 && $no_attendance_tracking != 1) {
//                     Attendance::create([
//                         'emp_id' => $emp_value->user_id,
//                         'attendance_time' =>  DATE(date('Y-m-d',  strtotime($date)) . ' ' . '00:00:00'),
//                         'work_day_id' => $work_day_id,
//                         'attendance_type' => null,
//                         'period_id' => $per_value->id,
//                         'company_id' =>  $emp_value->company_id,
//                         'branch_id' => $emp_value->branch_id,
//                         'status' => Attendance::STATUS_ABSENT,
//                     ]);
//                 }
//             }
//         } else {
//             if ($no_fingerprint_tracking == 1) {
//                 Attendance::create([
//                     'emp_id' => $emp_value->user_id,
//                     'attendance_time' => DATE(date('Y-m-d',  strtotime($date)) . ' ' . Period::find($period_id_not_register)->from_time),
//                     'work_day_id' => $work_day_id,
//                     'attendance_type' => Attendance::TYPE_ATTENDING,
//                     'period_id' => $period_id_not_register,
//                     'company_id' =>  $emp_value->company_id,
//                     'status' => Attendance::STATUS_PRESENT,
//                     'branch_id' => $emp_value->branch_id
//                 ]);
//                 Attendance::create([
//                     'emp_id' => $emp_value->user_id,
//                     'attendance_time' => DATE(date('Y-m-d',  strtotime($date)) . ' ' . Period::find($period_id_not_register)->from_time),
//                     'work_day_id' => $work_day_id,
//                     'attendance_type' => Attendance::TYPE_LEAVING,
//                     'period_id' => $period_id_not_register,
//                     'company_id' =>  $emp_value->company_id,
//                     'branch_id' => $emp_value->branch_id
//                 ]);
//             } else if ($no_fingerprint_tracking != 1 && $no_attendance_tracking != 1) {
//                 Attendance::create([
//                     'emp_id' => $emp_value->user_id,
//                     'attendance_time' =>  DATE(date('Y-m-d',  strtotime($date)) . ' ' . '00:00:00'),
//                     'work_day_id' => $work_day_id,
//                     'attendance_type' => null,
//                     'period_id' => $period_id_not_register,
//                     'company_id' =>  $emp_value->company_id,
//                     'branch_id' => $emp_value->branch_id,
//                     'status' => Attendance::STATUS_ABSENT,
//                 ]);
//             }
//         }
//     }


//     return $employees;
// });

Route::post('/upload', [AuthController::class, 'UploadImage']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('/update-user', [AuthController::class, 'update']);
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});


Route::get('/all-emps', [AuthController::class, 'allEmps']);

Route::resource('device', DeviceController::class);
Route::middleware(['auth:api'])->group(function () {
    Route::get('/work-days', [WorkDayPeriodController::class, 'index']);

    Route::resource('work-day', WorkDayController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('vacation', VacationController::class);
    Route::resource('vacation-type', VacationTypeController::class);
    Route::resource('advance-payment', AdvancePaymentController::class);

    Route::get('/attendance-last', [AttendanceController::class, 'last']);
    Route::get('attendance-settings', [AttendanceSettingController::class, 'index']);
    Route::get('/notifications', [NotificationControler::class, 'index']);
});
