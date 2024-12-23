<?php

namespace App\Http\Controllers;
use App\User;
use DB;
use Illuminate\Http\Request; 

use App\Models\File;
use Intervention\Image\ImageManagerStatic as Image;


class MediaController extends Controller{
	public function __construct(){
        //
    }
	
	public static function getMedia($ID = NULL){
		$json = [];
		
		$media = DB::table('media')->where('id', $ID)->first();

		if($media){
			$json = sprintf('%02x', $media->a).'/'.sprintf('%02x', $media->b).'/'.sprintf('%08x', $media->name);
			
			return $json;
		} else {
			
		}

	}
}