<?php

namespace App\Http\Controllers;

use App\Http\Resources\VacationResource;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vacations = Vacation::where('emp_id', $request->user()->id);

        if (isset($request->id) && $request->id != null) {
            $vacations->where('id', $request->id);
        }

        if (isset($request->type) && $request->type != null) {
            $vacations->where('type', $request->type);
        }

        if (isset($request->status) && $request->status != null) {
            $vacations->where('status', $request->status);
        }

        $vacations = $vacations->get();

        return VacationResource::collection($vacations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $vacation = Vacation::create([
                'emp_id' => $request->user()->id,
                'date' =>  date('Y-m-d',  strtotime($request->date)),
                'type' => $request->type,
                'vacation_reason' => $request->vacation_reason,
                'status' => Vacation::STATUS_ORDERED,
                'no_of_days' => $request->no_of_days,
                'from_time' =>  date('H:i:s',  strtotime($request->from_time)),
                'to_time' => date('H:i:s',  strtotime($request->to_time))
            ]);
            return $vacation;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function show(Vacation $vacation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacation $vacation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacation $vacation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacation $vacation)
    {
        //
    }
}
