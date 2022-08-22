<?php

namespace App\Http\Controllers\Voyager;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerAuthController as BaseVoyagerAuthController;

class VoyagerAuthController extends BaseVoyagerAuthController
{
    public function register()
    {
        return view('voyager::register');
    }

    public function store(Request $request)
    {
        $company = Company::create([
            'name' => $request->company_name,
            'email' => $request->company_email,
            'website' => $request->company_website,
        ]);

        User::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'phone_no' => $request->user_phone,
            'password' => $request->password,
            'company_id' => $company->id
        ]);
    }
    //
}
