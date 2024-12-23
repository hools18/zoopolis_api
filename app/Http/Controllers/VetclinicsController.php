<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\MailController as Email;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class VetclinicsController extends Controller{
	
	public function __construct(){
        //
    }
	public function all(Request $request){
		$return = [];
        $getUser = User::getUser($request);
		$userID = $getUser['id'];
		
		//$list = DB::table('veterinaryclinics')->select(DB::raw('*, X(coordinates) AS Latitude, Y("coordinates") AS Longitude'))->where('status', 1)->get();
		
		
		$list = DB::table('veterinaryclinics')
			->select(DB::raw('*, ST_X(coordinates) AS lat, ST_Y(coordinates) AS lng'))
			->get();
		$return['type'] = "FeatureCollection";
		if($list){
			foreach($list as $i => $data){ 
				$return['features'][$i]['id'] = $data->id;
				$return['features'][$i]['coordinates'] = [$data->lat , $data->lng];
				$return['features'][$i]['name'] = $data->name;
				$return['features'][$i]['desc'] = $data->desc;
				$return['features'][$i]['link'] = $data->link;
				$return['features'][$i]['addr'] = $data->addr;
				$return['features'][$i]['phone'] = $data->phone;
				$return['features'][$i]['phone2'] = $data->phone2;
				$return['features'][$i]['timework'] = $data->timework;
				$return['features'][$i]['status'] = $data->status;
				
				$return['features'][$i]['type'] = "Feature";
				$return['features'][$i]['geometry'] = [];
				$return['features'][$i]['geometry']['type'] = "Point";
				$return['features'][$i]['geometry']['coordinates'] = [$data->lat , $data->lng];
				
				$return['features'][$i]['properties'] = [];
				$return['features'][$i]['properties']['balloonContentHeader'] = '';
				$return['features'][$i]['properties']['balloonContentBody'] = '
				<div class="ballonmap">
					<div>
						<div class="nameclinic">'.$data->name.'</div>
					</div>
					<div>
						<div class="time">'.$data->timework.'</div>
					</div>
					<div><div class="addr">'.$data->addr.'</div></div>
					<div><a class="link" target="_blank" href="'.$data->link.'">Перейти на сайт</a></div>
				</div>
				';
				$return['features'][$i]['properties']['balloonContentFooter'] = '';
				$return['features'][$i]['properties']['clusterCaption'] = $data->name;
				$return['features'][$i]['properties']['hintContent'] = $data->name;
			}
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function get(Request $request, $id){
		$return = [];
        $getUser = User::getUser($request);
		$userID = $getUser['id'];
		$id = intval($id);
		
		$data = DB::table('veterinaryclinics')
			->select(DB::raw('*, ST_X(coordinates) AS lat, ST_Y(coordinates) AS lng'))
			->where('id', $id)
			->first();
		$return['id'] = $data->id;
		if($data->lat){
			$return['coordinates'] = [$data->lat , $data->lng];
		}
		$return['name'] = $data->name;
		$return['desc'] = $data->desc;
		$return['link'] = $data->link;
		$return['addr'] = $data->addr;
		$return['phone'] = $data->phone;
		$return['phone2'] = $data->phone2;
		$return['timework'] = $data->timework;
		$return['status'] = $data->status;
		
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function update(Request $request, $id){
		$return = [];
        $getUser = User::getUser($request);
		$userID = $getUser['id'];
		$id = intval($id);
		
		if($getUser['admin']){
			$clinic = [];
			
			$addr = $request->input('addr');
			if($addr != ''){
				$clinic['addr'] = $addr;
			};
			$desc = $request->input('desc');
			if($desc != ''){
				$clinic['desc'] = $desc;
			};
			$link = $request->input('link');
			if($link != ''){
				$clinic['link'] = $link;
			};
			
			$name = $request->input('name');
			if($name != ''){
				$clinic['name'] = $name;
			};
			$phone = $request->input('phone');
			if($phone != ''){
				$clinic['phone'] = $phone;
			};
			$phone2 = $request->input('phone2');
			if($phone2 != ''){
				$clinic['phone2'] = $phone2;
			};
			
			$status = $request->input('status');
			if($status != ''){
				$clinic['status'] = $status;
			};
			$timework = $request->input('timework');
			if($timework != ''){
				$clinic['timework'] = $timework;
			};
			
			$coordinates = $request->input('coordinates');
			if($coordinates != ''){
				$data = [];
				$data['coordinates'] = DB::raw("ST_GeomFromText('POINT(".$coordinates.")')");
				$update = DB::table('veterinaryclinics')->where('id', $id)->update($data);

			};	
			if($clinic){
				$update = DB::table('veterinaryclinics')->where('id', $id)->update($clinic);
			}
			
			
		} else {
			$return['err'][] = 'У вас нет прав доступа';
		}
		
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function newclinic(Request $request){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$name = $request->input('name');
			$id = DB::table('veterinaryclinics')->insertGetId([
				'name' => $name
			]);
			$return['id'] = intval($id);
		} else {
			$return['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
}