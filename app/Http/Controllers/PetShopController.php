<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetShopController
{
    public function list()
    {
        $return = [];
        $list = DB::table('pet_shops')
            ->get();
        $return['type'] = "FeatureCollection";
        if ($list) {
            foreach ($list as $i => $data) {
                $return['features'][$i]['id'] = $data->id;
                $return['features'][$i]['coordinates'] = [$data->lat, $data->lng];
                $return['features'][$i]['lat'] = $data->lat;
                $return['features'][$i]['lng'] = $data->lng;
                $return['features'][$i]['name'] = $data->name;
                $return['features'][$i]['desc'] = $data->desc;
                $return['features'][$i]['link'] = $data->link;
                $return['features'][$i]['address'] = $data->address;
                $return['features'][$i]['phone'] = $data->phone;
                $return['features'][$i]['time_work'] = $data->time_work;
                $return['features'][$i]['type'] = "Feature";
                $return['features'][$i]['geometry'] = [];
                $return['features'][$i]['geometry']['type'] = "Point";
                $return['features'][$i]['geometry']['coordinates'] = [$data->lat, $data->lng];

                $return['features'][$i]['properties'] = [];
                $return['features'][$i]['properties']['balloonContentHeader'] = '';
                $return['features'][$i]['properties']['balloonContentBody'] = '
				<div class="ballonmap">
					<div>
						<div class="nameclinic">' . $data->name . '</div>
					</div>
					<div>
						<div class="time">' . $data->time_work . '</div>
					</div>
					<div><div class="addr">' . $data->address . '</div></div>
					<div><a class="link" target="_blank" href="' . $data->link . '">Перейти на сайт</a></div>
				</div>
				';
                $return['features'][$i]['properties']['balloonContentFooter'] = '';
                $return['features'][$i]['properties']['clusterCaption'] = $data->name;
                $return['features'][$i]['properties']['hintContent'] = $data->name;
            }
        }
        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function edit($id)
    {
        $return = [];
        $id = intval($id);
        $data = DB::table('pet_shops')
            ->where('id', $id)
            ->first();
        $return['id'] = $data->id;
        if ($data->lat) {
            $return['coordinates'] = [$data->lat, $data->lng];
        } else {
            $return['coordinates'] = '';
        }
        $return['lat'] = $data->lat;
        $return['lng'] = $data->lng;
        $return['name'] = $data->name;
        $return['desc'] = $data->desc;
        $return['link'] = $data->link;
        $return['address'] = $data->address;
        $return['phone'] = $data->phone;
        $return['time_work'] = $data->time_work;

        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function create(Request $request)
    {
        $getUser = User::getUser($request);
        if ($getUser['admin']) {
            $name = $request->input('name');
            $id = DB::table('pet_shops')->insertGetId([
                'name' => $name
            ]);
            $return['id'] = intval($id);
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

    public function update(Request $request, $id)
    {
        $return = [];
        $getUser = User::getUser($request);


        if($getUser['admin']){
            $shop = [];

            $addr = $request->input('address');
            if($addr != ''){
                $shop['address'] = $addr;
            };
            $desc = $request->input('desc');
            if($desc != ''){
                $shop['desc'] = $desc;
            };
            $link = $request->input('link');
            if($link != ''){
                $shop['link'] = $link;
            };

            $name = $request->input('name');
            if($name != ''){
                $shop['name'] = $name;
            };
            $phone = $request->input('phone');
            if($phone != ''){
                $shop['phone'] = $phone;
            };

            $timework = $request->input('time_work');
            if($timework != ''){
                $shop['time_work'] = $timework;
            };

            $coordinatesLat = $request->input('lat');
            if($coordinatesLat != ''){
                $shop['lat'] = $coordinatesLat;

            };
            $coordinatesLng= $request->input('lng');
            if($coordinatesLng != ''){
                $shop['lng'] = $coordinatesLng;

            };
            if($shop){
               DB::table('pet_shops')->where('id', $id)->update($shop);
            }


        } else {
            $return['err'][] = 'У вас нет прав доступа';
        }

        return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }
}
