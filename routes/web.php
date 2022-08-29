<?php


use App\Http\Controllers\NotificationControler;
use App\Http\Controllers\Voyager\AttendanceController;
use App\Http\Controllers\Voyager\AttendanceSettingsController;
use App\Http\Controllers\Voyager\VacationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voyager\VoyagerAuthController;
use App\Http\Controllers\Voyager\WorkDayController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
 
Route::group(['prefix' => 'admin'], function () {
    Route::get('/register', [VoyagerAuthController::class, 'register']);
    Route::get('/report', [AttendanceController::class, 'report']);
    Route::get('/employees-report', [AttendanceController::class, 'reportEmps']);
    Route::get('/employees-report-hours', [AttendanceController::class, 'reportEmpsHours']);

    Route::get('/all-employees-report', [AttendanceController::class, 'allEmployeesReport']);

    Route::get('/one-employees-report', [AttendanceController::class, 'oneEmployeesReport']);

    Route::get('/add-periods-to-days/{id}', [WorkDayController::class, 'createPeriods']);
    Route::post('/save-work-day-periods/{id}', [WorkDayController::class, 'addPeriods']);
    Route::get('/notifications/create', [NotificationControler::class, 'create']);
    Route::get('/topic-notifications/create', [NotificationControler::class, 'topicCreate']);
    Route::get('/print-barcode/{id}', [AttendanceSettingsController::class, 'printBarcode']);

    Route::get('/print-vacation/{id}', [VacationController::class, 'printVacation']);


    Voyager::routes();
});

Route::post('/send-notifi', [NotificationControler::class, 'webSend']);






Route::post('/registeration', [VoyagerAuthController::class, 'store']);
