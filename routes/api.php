<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationControler;
use App\Http\Controllers\WorkDayController;
use App\Http\Controllers\WorkDayPeriodController;
use Illuminate\Http\Request;
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


Route::post('/upload', [AuthController::class, 'UploadImage']);


Route::middleware(['auth:api'])->group(function () {
    Route::post('/update-user', [AuthController::class, 'update']);
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});
Route::middleware(['auth:api'])->group(function () {
    Route::get('/work-days', [WorkDayPeriodController::class, 'index']);

    Route::resource('work-day', WorkDayController::class);

    Route::resource('attendance', AttendanceController::class);

    Route::get('/attendance-last', [AttendanceController::class, 'last']);

    Route::get('attendance-settings', [AttendanceSettingController::class, 'index']);

    Route::get('/notifications', [NotificationControler::class, 'index']);
});
