<?php

namespace App\Http\Controllers;

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

        $text = $request->input('text');
        $zooid = DB::table('form_missinganimal')->insertGetId([
            'user' => $userID,
            'text' => $text
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

        $id = intval($request->input('id'));
        if ($id >= 1) {
            $missinganimal = DB::table('form_missinganimal')->where('id', $id)->whereIn('user', $userID)->first();

            if ($missinganimal) {
                $return['id'] = $data->id;
                $return['create'] = $data->create;
                $return['text'] = $data->text;
                $return['status'] = $data->status;
            }
        } else {
            $missinganimal = DB::table('form_missinganimal')->where('user', $userID)->orderBy('create', 'DESC')->get();
            if ($missinganimal) {
                foreach ($missinganimal as $i => $data) {
                    $return[$i]['id'] = $data->id;
                    $return[$i]['create'] = $data->create;
                    $return[$i]['text'] = $data->text;
                    $return[$i]['status'] = $data->status;
                }
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
            $user = DB::table('users')->where('id', $missinganimal->user)->first();

            if ($missinganimal) {
                $return['id'] = $missinganimal->id;
                $return['create'] = $missinganimal->create;
                $return['text'] = $missinganimal->text;
                $return['status'] = $missinganimal->status;
                $return['user'] = $missinganimal->user;
				$return['user_name'] = $user->first.' '.$user->last;
				$return['user_phone'] = UserController::formatPhone($user->phone);
				$return['user_email'] = $user->email;
                $return['comments'] = $missinganimal->comments;
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
