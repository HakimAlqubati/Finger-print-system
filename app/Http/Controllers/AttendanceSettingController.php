<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $data = AttendanceSetting::where('branch_id',Auth::user()->branch_id)->where('company_id', Auth::user()->company_id)->get();
        return $data;
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendanceSetting  $attendanceSetting
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceSetting $attendanceSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceSetting  $attendanceSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceSetting $attendanceSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceSetting  $attendanceSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceSetting $attendanceSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceSetting  $attendanceSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceSetting $attendanceSetting)
    {
        //
    }
}
