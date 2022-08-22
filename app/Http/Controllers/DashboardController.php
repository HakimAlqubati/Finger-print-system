<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        // $firstChart = Product::skip(0)->take(5)->orderBy('count_orders', 'DESC')->get();
        // foreach ($firstChart as $key => $value) {
        //     $finalDataFirstChart[] = [
        //         'label' => $value->name, 'y' => $value->count_orders
        //     ];
        // }

        $branches = Branch::where('company_id', Auth::user()->company_id)->get();
        $firstChart = [];
        foreach ($branches as $key => $value) {
            $firstChart[]  = [
                'y' => $value->users->count(),
                'label' => $value->name
            ];
        }
        // $firstChart = [['y' => 7, 'label' => 'March'], ['y' => 12, 'label' => 'April'], ['y' => 28, 'label' => 'May'], ['y' => 18, 'label' => 'June'], ['y' => 41, 'label' => 'July']];

      


        return view(
            'voyager::dashboard.dashboard',
            compact('firstChart')
        );

        //     return view('voyager::dashboard.dashboard', compact(
        //         'finalDataFirstChart'
        //     ));
    }
}
