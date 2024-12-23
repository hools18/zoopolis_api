<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class TagsController extends Controller{
	
	public function __construct(){
        //
    }
	public static function getTag($id){  
		$return = [];
		if(Cache::get('tag_'.$id)){
			$tag = Cache::get('tag_'.$id);
			$tag->cache = true;
		} else {
			$tag = DB::table('tags')->where('id', $id)->first();
			Cache::put('tag_'.$id, $tag, env('CACHE_TIME_TAGS'));
			$tag->cache = false;
		}
		return $tag;
    }
}