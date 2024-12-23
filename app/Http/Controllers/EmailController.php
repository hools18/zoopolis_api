<?php

namespace App\Http\Controllers;

use App\Mail\RegisterConfirmationEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function sendRegisterConfirmationEmail()
    {
        Mail::to('bugsmafia@gmail.com')->send(new EmailController());
    }
}