<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Mail;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {
    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");

        Mail::send(['text'=>'mail'], $data, function($message) {
            $message->to('bugsmafia@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
            $message->from('no_answer@utempla.com','UTEMPLA');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
    public static function subscribed($user, $sid) {
        $subscriptionData = DB::table('subscriptions')->where('id', $sid)->where('status', 1)->first();
        $data = array(
            'name' => $user['name'],
            'subs_name' => $subscriptionData->name,
            'subs_day' => $subscriptionData->day,
            'subs_price' => $subscriptionData->price
        );
        Mail::send('subscribed', $data, function($message) use ($user){
            $message->to($user['email'], $user['name'])->subject('Subscribed successfully - UTEMPLA');
            $message->from('no_answer@utempla.com', 'UTEMPLA - no answer');
        });
    }
    public function attachment_email() {
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}