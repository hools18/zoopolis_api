<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
class CityController
{
    public function getList(Request $request)
    {
        $token = $request->header('Authorization');

        $return = [];

        if ($token) {
            $return = DB::table('cities')->get();
        }

        return $return;
    }

    public function cityRequestSave(Request $request)
    {
        $token = $request->header('Authorization');
        $userID = (new UserController())->getUserIDToken($token);
        $userEmail = '';
        $user = DB::table('users')->where('id', $userID)->first();

        if(isset($user)){
            $userEmail = $user->email;
        }

        DB::table('user_request_cities')->insertGetId([
            'city_name' => $request->city,
            'email' => $userEmail,
            'user_id' => $userID,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Данные успешно сохранены'], 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }
}
