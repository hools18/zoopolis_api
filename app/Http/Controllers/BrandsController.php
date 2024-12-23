<?php

namespace App\Http\Controllers;
use App\User;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class BrandsController extends Controller{

    public function __construct(){
        //
    }

	public static function getBrand($id){
		$json = [];
		$brand = DB::table('brands')->where('id', $id)->first();
		if($brand){
			$json['id'] = $brand->id;
			$json['name'] = $brand->name;
			$json['desc'] = $brand->desc;
			$json['test'] = 't';
			$brandlogo = DB::table('brand_logo')->where('brand', $id)->where('status', 1)->first();

			if($brandlogo){
				$json['logo'] = sprintf('%02x', $brandlogo->a).'/'.sprintf('%02x', $brandlogo->b).'/'.sprintf('%08x', $brandlogo->name);
                $filetype = 'jpg';
                if (isset($brandlogo->type)) {
                    switch ($brandlogo->type) {
                        case 1:
                            $filetype = 'jpg';
                            break;
                        case 2:
                            $filetype = 'png';
                            break;
                        case 10:
                            $filetype = 'svg';
                            break;
                    }
                }
                $json['logoext'] = $filetype;
			} else {
				$json['logo'] = 'nophoto.jpg';
			}

		} else {
			$json['id'] = 0;
			$json['name'] = false;
			$json['desc'] = false;
			$json['logo'] = 'nophoto.jpg';
		}
		return $json;
	}
}
