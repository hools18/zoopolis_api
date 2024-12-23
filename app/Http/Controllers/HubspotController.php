<?php

namespace App\Http\Controllers;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Models\File;
use Intervention\Image\ImageManagerStatic as Image;

use Rossjcooper\LaravelHubSpot\Facades\HubSpot as HubSpot;

$MailChimp = new MailChimp();

class HubspotController extends Controller{
	
	public function __construct(){
        //
    }

	function test(){
		$return = [];

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }
	

	
}