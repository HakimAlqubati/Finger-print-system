<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdvancePaymentResource;
use App\Models\AdvancePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvancePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $advancePayment = AdvancePayment::where('emp_id', $request->user()->id);

        if (isset($_GET['id']) && $_GET['id'] != null) {
            $advancePayment->where('id', $_GET['id']);
        }
 

        if (isset($_GET['status']) && $_GET['status'] != null) {
            $advancePayment->where('status', $_GET['status']);
        }

        $advancePayment = $advancePayment->get();

        return AdvancePaymentResource::collection($advancePayment);
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
        return DB::transaction(function () use ($request) {
            $advancePayment = AdvancePayment::create([
                'emp_id' => $request->user()->id,
                'date' =>  date('Y-m-d',  strtotime($request->date)),
                'reason' => $request->reason,
                'amount' => $request->amount,
                'status' => AdvancePayment::STATUS_ORDERED,
            ]);
            return $advancePayment;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function show(AdvancePayment $advancePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvancePayment $advancePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvancePayment $advancePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvancePayment $advancePayment)
    {
        //
    }
}
