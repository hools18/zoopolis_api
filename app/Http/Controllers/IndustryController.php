<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class IndustryController extends Controller{
	
	public function __construct(){
        //
    }
	public static function getIndustry($id){  
		$return = [];
		if(Cache::get('industry_'.$id)){
			$industry = Cache::get('industry_'.$id);
			$industry->cache = true;
		} else {
			$industry = DB::table('industry')->where('id', $id)->first();
			Cache::put('industry_'.$id, $industry, env('CACHE_TIME_INDUSTRY'));
			$industry->cache = false;
		}
		return $industry;
    }
}