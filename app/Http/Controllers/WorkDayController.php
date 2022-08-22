<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkDay as ResourcesWorkDay;
use App\Models\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        
        $workDays = Workday::where('company_id', Auth::user()->company_id)->get();
      
        return ResourcesWorkDay::collection($workDays);
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
        return 'ddddddd';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkDay  $workDay
     * @return \Illuminate\Http\Response
     */
    public function show(WorkDay $workDay)
    {
        return new ResourcesWorkDay($workDay);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkDay  $workDay
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkDay $workDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkDay  $workDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkDay $workDay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkDay  $workDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkDay $workDay)
    {
        //
    }
}
