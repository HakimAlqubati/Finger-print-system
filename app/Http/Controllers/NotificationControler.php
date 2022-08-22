<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NotifyEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function webSend(Request $request)
    {
        // $customer = User::findMany($request->user_id);
        $customer = User::findMany($request->users);

        // dd($customer);
        $tokens = [];
        $userIds = [];
        foreach ($customer as $key => $value) {

            $tokens[] = $value->device_token;
            $userIds[] = $value->id;
        }

        // $device_token = $customer->device_token;
        // return $tks;
        $SERVER_API_KEY = 'AAAAUPNSpMs:APA91bHNulqLBkgbXAI0JAtuAYTyuG6N6g91z0u4JEdLyR6EHGxYZfWUqiDCzBwkk9_esBZrO2IGo7UIyCMhYlv9PHUY_sgiwt3ZroDeuEsGS6EQKhULv7r29UsyvRq5EmzCSBkI70X1';
        // $token_1 = $device_token;
        $data = [
            "registration_ids" =>
            $tokens,
            "notification" => [
                "title" =>  $request->title,
                "body" => $request->body,
                "sound" => "default" // required for sound on ios
            ],

        ];
        $dataString = json_encode($data);
        // $dataString =  $data;
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response =  json_decode(curl_exec($ch))->success;


        $users = User::whereIn('id', $userIds)->get();
        // dd($users); 

        // dd($users);

        $empNotification = [
            'title' =>   $request->title,
            'body' =>  $request->body,
        ];

        Notification::send($users, new NotifyEmployee($empNotification));


        if ($response == 1) {
            return redirect()->back()->with([
                'message'    =>   "تم",
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message'    =>   "خطأ",
                'alert-type' => 'error',
            ]);
        }

        return $response;
    }



    public function index()
    {
        return DB::table('notifications')->where('notifiable_id', Auth::user()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notifications.create');
    }
    public function topicCreate()
    {
        return view('notifications.topic-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
