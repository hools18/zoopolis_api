<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class GoalController extends Controller{
	
	public function __construct(){
        //
    }
	public static function getGoal($id){  
		$return = [];
		if(Cache::get('goal_'.$id)){
			$goal = Cache::get('goal_'.$id);
			$goal->cache = true;
		} else {
			$goal = DB::table('goal')->where('id', $id)->first();
			Cache::put('goal_'.$id, $goal, env('CACHE_TIME_GOAL'));
			$goal->cache = false;
		}
		return $goal;
    }
}