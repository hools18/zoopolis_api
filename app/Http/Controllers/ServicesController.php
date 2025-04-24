<?php

namespace App\Http\Controllers;

use App\Models\PetQrCode;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\MailController as Email;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Intervention\Image\ImageManager;

class ServicesController extends Controller
{

    public function __construct()
    {
        //
    }

    public function formMissingAnimal(Request $request)
    {
        $return = [];
        $getUser = User::getUser($request);
        $userID = $getUser['id'];

        DB::table('form_missinganimal')->insertGetId([
            'user' => $userID,
            'text' => $request->input('text'),
            'address' => $request->input('address'),
        ]);
        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function myMissingAnimal(Request $request)
    {
        $return = [];
        $getUser = User::getUser($request);
        $userID = $getUser['id'];
        $missinganimal = DB::table('form_missinganimal')->where('user', $userID)->orderBy('create', 'DESC')->get();
        if ($missinganimal) {
            foreach ($missinganimal as $i => $data) {
                $return[$i]['id'] = $data->id;
                $return[$i]['create'] = $data->create;
                $return[$i]['text'] = $data->text;
                $return[$i]['status'] = $data->status;
            }
        }

        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function missinganimalall(Request $request)
    {
        $return = [];
        $getUser = User::getUser($request);

        if ($getUser['admin']) {
            $missinganimal = DB::table('form_missinganimal')->orderBy('create', 'DESC')->get();
            if ($missinganimal) {
                foreach ($missinganimal as $i => $data) {
                    $return[$i]['id'] = $data->id;
                    $return[$i]['create'] = $data->create;
                    $return[$i]['text'] = $data->text;
                    $return[$i]['status'] = $data->status;
                    $return[$i]['user'] = $data->user;
                }
            }
        } else {
            $return['err'][] = 'У вас нет прав доступа';
        }
        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function getinfo(Request $request, $id)
    {
        $return = [];
        $getUser = User::getUser($request);

        if ($getUser['admin']) {
            $missinganimal = DB::table('form_missinganimal')->where('id', $id)->first();


            if ($missinganimal) {
                $return['id'] = $missinganimal->id;
                $return['create'] = $missinganimal->create;
                $return['text'] = $missinganimal->text;
                $return['status'] = $missinganimal->status;
                $return['user'] = $missinganimal->user;
                $return['comments'] = $missinganimal->comments;
                if ($missinganimal->uid !== null) {
                    $qrCode = PetQrCode::where('uid', $missinganimal->uid)->firstOrFail();
                    $user = DB::table('users')->where('id', $qrCode->user_id)->first();
                    $return['user_name'] = $user->first . ' ' . $user->last;
                    $return['user_phone'] = UserController::formatPhone($user->phone);
                    $return['user_email'] = $user->email;
                    $return['address'] = $missinganimal->address;
                    $return['finder_phone'] = UserController::formatPhone($missinganimal->phone_finder);
                    $return['finder_name'] = $missinganimal->name_finder;
                } else {
                    $user = DB::table('users')->where('id', $missinganimal->user)->first();
                    $return['user_name'] = $user->first . ' ' . $user->last;
                    $return['user_phone'] = UserController::formatPhone($user->phone);
                    $return['user_email'] = $user->email;
                    $return['finder_phone'] = null;
                    $return['finder_name'] = null;
                    $return['address'] = $missinganimal->address;
                }
            }
        } else {
            $return['err'][] = 'У вас нет прав доступа';
        }
        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function missinganimalupd(Request $request, $id)
    {
        $return = [];
        $getUser = User::getUser($request);

        if ($getUser['admin']) {
            $data = [];
            $text = $request->input('text');
            if ($text != '') {
                $data['text'] = $text;
            };
            $status = $request->input('status');
            if ($status != '') {
                $data['status'] = $status;
            };
            $comments = $request->input('comments');
            if ($comments != '') {
                $data['comments'] = $comments;
            };
            if ($data) {
                $update = DB::table('form_missinganimal')->where('id', $id)->update($data);
            }
        } else {
            $return['err'][] = 'У вас нет прав доступа';
        }
        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }


}
