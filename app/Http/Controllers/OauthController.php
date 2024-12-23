<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController as User;
use Laravel\Socialite\Facades\Socialite;


class OauthController extends Controller{

    public function __construct(){
        //
    }
    public function oauth(Request $request){
        $return = [];
        $token = $request->input('token');
        $user = User::userOauth($token);
        $return = $user;
        return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

    }
    public function GoogleToken(Request $request){

        $return = [];
        $return =  Socialite::driver('google');
        return Socialite::driver('google')->stateless()->redirect();
        //return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

    }
    public function GoogleTokenReturn(Request $request){

        $return = [];
        $user = Socialite::driver('google')->stateless()->user();
        /*
        {
        "id":"114367132697834806931",
        "nickname":null,
        "name":"Сергей Осипов",
        "email":"bugsmafia@gmail.com",
        "avatar":"https:\/\/lh3.googleusercontent.com\/a\/AEdFTp5F91NsqaQCAWEuQdq2pW205lYuah7LCGRCalFcSEg=s96-c","user":{"sub":"114367132697834806931","name":"Сергей Осипов","given_name":"Сергей","family_name":"Осипов","picture":"https:\/\/lh3.googleusercontent.com\/a\/AEdFTp5F91NsqaQCAWEuQdq2pW205lYuah7LCGRCalFcSEg=s96-c","email":"bugsmafia@gmail.com","email_verified":true,"locale":"ru","id":"114367132697834806931","verified_email":true,"link":null},"attributes":{"id":"114367132697834806931","nickname":null,"name":"Сергей Осипов","email":"bugsmafia@gmail.com","avatar":"https:\/\/lh3.googleusercontent.com\/a\/AEdFTp5F91NsqaQCAWEuQdq2pW205lYuah7LCGRCalFcSEg=s96-c","avatar_original":"https:\/\/lh3.googleusercontent.com\/a\/AEdFTp5F91NsqaQCAWEuQdq2pW205lYuah7LCGRCalFcSEg=s96-c"},"token":"ya29.a0AVvZVsqfc9OFswbp9AIizLkVUcLMToZyIwC6q5-g2O_S357KfdydLZyHhQQg0IlE2VpXvoe0cLgrSWC3eW7S2D1GcKHSUft6z-ZtnYpukP5vQobMqxzWyVg62dbmjlO3yPwANSja8xqpXz-FnpgM0hIwoZlOaCgYKAUISARASFQGbdwaIzzqmzm3dR1JCajpTByfOiw0163","refreshToken":null,"expiresIn":3599,"approvedScopes":["openid","https:\/\/www.googleapis.com\/auth\/userinfo.profile","https:\/\/www.googleapis.com\/auth\/userinfo.email"]}
        */
        $checkUser = User::getUserEmail($user->email);
        if($checkUser){
            if($checkUser->id){
                $token = User::loginUserOauth($checkUser->id);
                $return['token'] = $token['token'];
                return redirect('https://platform.utempla.com/#!/oauth/'.$token['token']);
            } else {

            }
        } else {
            $token = User::newUserOauth($user->email, $user->name);
            $return['token'] = $token['token'];
            return redirect('https://platform.utempla.com/#!/oauth/'.$token['token']);
        }

        return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

    }





}