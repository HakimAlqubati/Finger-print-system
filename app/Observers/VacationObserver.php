<?php

namespace App\Observers;

use App\Models\WorkDay;
use App\Models\Attendance;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;

class VacationObserver
{
    /**
     * Handle the Vacation "created" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function created(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the Vacation "updated" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function updated(Vacation $vacation)
    {
        if ($vacation->status == Vacation::STATUS_APPROVED) {
            $work_day_id = WorkDay::where('company_id', Auth::user()->id)->where('code', date('D', strtotime($vacation->date)))->first()?->id;
            foreach ($vacation->period_ids_exploded as $value) {
                Attendance::create([
                    'emp_id' => $vacation->emp_id,
                    'attendance_time' => date('Y-m-d H:i:s', strtotime($vacation->date . ' 00:00:00')),
                    'work_day_id' => $work_day_id,
                    'attendance_type' => Attendance::STATUS_ON_VOCATION,
                    'company_id' => 1,
                    'branch_id' => 1,
                    'period_id' => $value['period_id'],
                    'vacation_id' => $vacation->id
                ]);
            }
        }
    }

    /**
     * Handle the Vacation "deleted" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function deleted(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the Vacation "restored" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function restored(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the Vacation "force deleted" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function forceDeleted(Vacation $vacation)
    {
        //
    }
}
