<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\File;

class AuthController extends Controller
{


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'job_number' => 'required|string|max:255',
            'password' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('job_number', $request->job_number)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->active != 1) {
                    return [
                        'error' => 'user is deactive',
                    ];
                }

                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = [

                    'token' => $token,
                    'user' => $user
                ];
                if (isset($request->device_token)) {
                    $user->device_token = $request->device_token;
                }
                $user->save();
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if (isset($request->comparing_image) && $request->comparing_image != null) {
            $name =   Str::random(15) . '.jpg';
            // decode the base64 file 
            $file = base64_decode(
                $request->comparing_image
            );
            Storage::put('public/users/'  .  $name,   $file);
            file_put_contents(public_path() . '/storage/users/' . $name, $file);
            $user->comparing_image = 'users/' . $name;
        }


        if (isset($request->licence_image) && $request->licence_image != null) {
            $name =   Str::random(15) . '.jpg';
            // decode the base64 file 
            $file = base64_decode(
                $request->licence_image
            );
            Storage::put('public/users/'  .  $name,   $file);
            file_put_contents(public_path() . '/storage/users/' . $name, $file);
            $user->licence_image = 'users/' . $name;
        }

        if (isset($request->id_image) && $request->id_image != null) {
            $name =   Str::random(15) . '.jpg';
            // decode the base64 file 
            $file = base64_decode(
                $request->id_image
            );
            Storage::put('public/users/'  .  $name,   $file);
            file_put_contents(public_path() . '/storage/users/' . $name, $file);
            $user->id_image = 'users/' . $name;
        }

        if (isset($request->avatar) && $request->avatar != null) {
            $name =   Str::random(15) . '.jpg';
            // decode the base64 file 
            $file = base64_decode(
                $request->avatar
            );
            Storage::put('public/users/'  .  $name,   $file);
            file_put_contents(public_path() . '/storage/users/' . $name, $file);
            $user->avatar = 'users/' . $name;
        }



        if (isset($request->device_token) && $request->device_token != null) {
            $user->device_token = $request->device_token;
        }

        if (isset($request->bank_account_number) && $request->bank_account_number != null) {
            $user->bank_account_number = $request->bank_account_number;
        }

        if (isset($request->identity_number) && $request->identity_number != null) {
            $user->identity_number = $request->identity_number;
        }

        if (isset($request->id_expiration_date) && $request->id_expiration_date != null) {
            $user->id_expiration_date = $request->id_expiration_date;
        }


        if (isset($request->licence_expiration_date) && $request->licence_expiration_date != null) {
            $user->licence_expiration_date = $request->licence_expiration_date;
        }




        $save =  $user->save();

        if ($save) {
            return
                $user;
        }
    }
}
