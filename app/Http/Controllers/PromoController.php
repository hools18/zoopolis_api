<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\MediaController as Media;

use Intervention\Image\ImageManager;

class PromoController extends Controller{

	public function __construct(){
        //
    }


	public function show(Request $request){
		$getUser = User::getUser($request);
		$id = intval($request->input('id'));
		$return = [];

		if($id){
			$data = DB::table('promo')->where('id', $id)->first();
				$id = $data->id;
				$return['id'] = (int)$data->id;
				$return['title'] = (string)$data->title;
				$return['shortdesc'] = (string)$data->shortdesc;
				$return['percent'] = (int)$data->percent;
				$return['summ'] = (int)$data->summ;
				$return['promocode'] = (string)$data->promocode;

				$return['promolink'] = (string)$data->promolink;
				$return['сonditions'] = (string)$data->сonditions;
				$return['minprice'] = (int)$data->minprice;
				$return['currency'] = (string)$data->currency;

				$return['start'] = $data->start;
				$return['stop'] = $data->stop;
				$return['aboutpartner'] = (string)$data->aboutpartner;
				$return['size'] = (int)$data->size;
				$return['type'] = $data->type;
				if($data->media){
					$return['media'] = Media::getMedia((int)$data->media);
				}

		} else {

			$promoIDs = array();
			$tagsIDs = array();
			$tags = $request->input('tags');
			$cities = $request->input('cities');

			if(is_array($tags)){
				if(count($tags) >= 1){
					foreach($tags  as $i => $data){
						array_push($tagsIDs, (int)$data);
					}
					if($tagsIDs){
						$promoGetIDS = DB::table('promo_tags')->whereIn('tag', $tagsIDs)->get();
						foreach($promoGetIDS  as $i => $data){
							array_push($promoIDs, (int)$data->promo);
						}
					}

					if($promoIDs){
						$promolist = DB::table('promo')->whereIn('id', $promoIDs)->get();
						foreach($promolist  as $i => $data){
							$id = $data->id;
							$return[$i]['id'] = (int)$data->id;
							$return[$i]['title'] = (string)$data->title;
							$return[$i]['shortdesc'] = (string)$data->shortdesc;
							$return[$i]['percent'] = (int)$data->percent;
							$return[$i]['summ'] = (int)$data->summ;
							$return[$i]['promocode'] = (string)$data->promocode;

							$return[$i]['promolink'] = (string)$data->promolink;
							$return[$i]['сonditions'] = (string)$data->сonditions;
							$return[$i]['minprice'] = (int)$data->minprice;
							$return[$i]['currency'] = (string)$data->currency;

							$return[$i]['start'] = $data->start;
							$return[$i]['stop'] = $data->stop;
							$return[$i]['aboutpartner'] = (string)$data->aboutpartner;
							$return[$i]['size'] = (int)$data->size;
							$return[$i]['type'] = $data->type;
							if($data->media){
								$return[$i]['media'] = Media::getMedia((int)$data->media);
							}
						}
					}
				} else {
					$promolist = DB::table('promo')->get();
					foreach($promolist  as $i => $data){
						$id = $data->id;
						$return[$i]['id'] = (int)$data->id;
						$return[$i]['title'] = (string)$data->title;
						$return[$i]['shortdesc'] = (string)$data->shortdesc;
						$return[$i]['percent'] = (int)$data->percent;
						$return[$i]['summ'] = (int)$data->summ;
						$return[$i]['promocode'] = (string)$data->promocode;

						$return[$i]['promolink'] = (string)$data->promolink;
						$return[$i]['сonditions'] = (string)$data->сonditions;
						$return[$i]['minprice'] = (int)$data->minprice;
						$return[$i]['currency'] = (string)$data->currency;

						$return[$i]['start'] = $data->start;
						$return[$i]['stop'] = $data->stop;
						$return[$i]['aboutpartner'] = (string)$data->aboutpartner;
						$return[$i]['size'] = (int)$data->size;
						$return[$i]['type'] = $data->type;
						if($data->media){
							$return[$i]['media'] = Media::getMedia((int)$data->media);
						}
					}

				}
			}




		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function getinfo(Request $request, $id){
		$getUser = User::getUser($request);
        $return = [];
		if($getUser['admin']){

			$data = DB::table('promo')->where('id', $id)->first();
			$return['id'] = (int)$data->id;
			$return['title'] = (string)$data->title;
			$return['shortdesc'] = (string)$data->shortdesc;
			$return['percent'] = (int)$data->percent;
			$return['summ'] = (int)$data->summ;
			$return['promocode'] = (string)$data->promocode;

			$return['promolink'] = (string)$data->promolink;
			$return['сonditions'] = (string)$data->сonditions;
			$return['minprice'] = (int)$data->minprice;
			$return['currency'] = (string)$data->currency;

			$return['start'] = $data->start;
			$return['stop'] = $data->stop;
			$return['aboutpartner'] = (string)$data->aboutpartner;
			$return['size'] = (int)$data->size;
			$return['type'] = $data->type;
			if($data->media){
				$return['media'] = Media::getMedia((int)$data->media);
			}

			$tags = DB::table('tags')->get();
			foreach($tags as $i => $data){
				$return['tagslist'][$i]['id'] = (string)$data->id;
				$return['tagslist'][$i]['name'] = $data->name;
			}
			$cities = DB::table('cities')->get();
			foreach($cities as $i => $data){
				$return['citylist'][$i]['id'] = (string)$data->id;
				$return['citylist'][$i]['name'] = $data->name;
			}

			$tags = DB::table('promo_tags')->where('promo', $id)->get();
			foreach($tags  as $i => $data){
				$return['tags'][] = (string)$data->tag;
			}
			$cities = DB::table('promo_city')->where('promo', $id)->get();
			foreach($cities  as $i => $data){
				$return['cities'][] = (string)$data->city;
			}

		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function saveinfo(Request $request, $id){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$json = [];

			$promo = [];

			// Название
			$title = $request->input('title');
			if($title != ''){
				$promo['title'] = $title;
			};

			// Тип Бонус / Промокод

			$type = $request->input('type');
			if($type != ''){
				$promo['type'] = (int)$type[0];
			};

            $size = $request->input('size');
            if($type != ''){
                $promo['size'] = (int)$size[0];
            };

			$BYN = $request->input('BYN');
			if($BYN != ''){
				$promo['currency'] = 'BYN';
			};
			$RUB = $request->input('RUB');
			if($RUB != ''){
				$promo['currency'] = 'RUB';
			};
			// О партнере
			$aboutpartner = $request->input('aboutpartner');
			if($aboutpartner != ''){
				$promo['aboutpartner'] = $aboutpartner;
			};
			// Условия акции
			$conditions = $request->input('conditions');
			if($conditions != ''){
				$promo['conditions'] = $conditions;
			};
			// Промокод
			$promocode = $request->input('promocode');
			if($promocode != ''){
				$promo['promocode'] = $promocode;
			};

			// Начало промо
			$promostart = $request->input('start');
			if($promostart != ''){
				$promo['start'] = $promostart;
			};
			// Заверение промо
			$promoend = $request->input('promoend');
			if($promoend != ''){
				$promo['stop'] = $promoend;
			};
			// Ссылка
			$promolink = $request->input('promolink');
			if($promolink != ''){
				$promo['promolink'] = $promolink;
			};

			// Процент скидки
			$percent = $request->input('percent');
			if($percent != ''){
				$promo['percent'] = $percent;
			};
			// Или бонус на сумму
			$summ = $request->input('summ');
			if($summ != ''){
				$promo['summ'] = $summ;
			};
			// Минимальная сумма
			$minprice = $request->input('minprice');
			if($minprice != ''){
				$promo['minprice'] = $minprice;
			};

			// Описание краткое
			$shortdesc = $request->input('shortdesc');
			if($shortdesc != ''){
				$promo['shortdesc'] = $shortdesc;
			};

			// Описание краткое
			$shortdesc = $request->input('shortdesc');
			if($shortdesc != ''){
				$promo['shortdesc'] = $shortdesc;
			};


			if($request->file('media')){
				$json['requestmedia'] = 1;
				$media = $request->file('media');
				if ($request->file('media')->isValid()) {
					$folderA = bin2hex(random_bytes(1));
					$folderB = bin2hex(random_bytes(1));
					$fileName = bin2hex(random_bytes(4));
					$dirName = array('orig', '2400', '1800', '1200', '600', '300', '150');

					$dir = env('MEDIA_FOLDER');
					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
					};
					$json['media'] = true;

					foreach($dirName  as $i => $nd){
						$dir = env('MEDIA_FOLDER').$nd.'/';
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$dir = env('MEDIA_FOLDER').$nd.'/'.$folderA;
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$dir = env('MEDIA_FOLDER').$nd.'/'.$folderA.'/'.$folderB;
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
					}

					$image = $media;
					$picName = $media->getClientOriginalName();
					$guessExtension = $media->guessExtension();
					$picName = uniqid() . '_' . $picName;
					// contest	a	b	name	type	create
					$filetype = 0;
					if (isset($guessExtension)) {
						switch ($guessExtension) {
							case 'jpg':
								$filetype = 1;
							break;
							case 'png':
								$filetype = 2;
							break;
							case 'webp':
								$filetype = 4;
							break;
							case 'svg':
								$filetype = 10;
							break;
						}
					}
					$IDMEDIA = DB::table('media')->insertGetId([
						'a' => hexdec($folderA),
						'b' => hexdec($folderB),
						'name' => hexdec($fileName),
						'type' => $filetype
					]);
					$request->file('media')->move(env('MEDIA_FOLDER').'orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);
					// Векторные типы больше 10 пропускаем.
					if($filetype <= 9){
					$manager = new ImageManager('imagick');



					foreach($dirName  as $i => $nd){
						$dir = env('MEDIA_FOLDER').$nd.'/';
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						if($nd == 'orig'){
						} else {
							$image = $manager->make(env('MEDIA_FOLDER').'orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
							$image->scale(width: $nd);
							$image->toJpeg()->save(env('MEDIA_FOLDER').$nd.'/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 87, 'jpg');
							$image->toWebp()->save(env('MEDIA_FOLDER').$nd.'/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 87, 'webp');
							$image->toPng()->save(env('MEDIA_FOLDER').$nd.'/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');
						}
					}

                    }

					$promo['media'] = $IDMEDIA;


				};
			};


			if($promo){


				$update = DB::table('promo')->where('id', $id)->update($promo);
			}


			$tags = $request->input('tags');
			if($tags != ''){
				$del = DB::table('promo_tags')->where('promo', $id)->delete();
				foreach($tags  as $i => $data){
					$BD = DB::table('promo_tags')->insertGetId([
						'promo' => $id,
						'tag' => $data
					]);
				}
				$return['tag'] = true;
			};
			$cities = $request->input('cities');
			if($cities != ''){
				$del = DB::table('promo_city')->where('promo', $id)->delete();
				foreach($cities  as $i => $data){
					$BD = DB::table('promo_city')->insertGetId([
						'promo' => $id,
						'city' => $data
					]);
				}
				$return['city'] = true;
			};


		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function promoNew(Request $request){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$title = $request->input('title');
			$promo = DB::table('promo')->insertGetId([
				'title' => $title
			]);
			$json['id'] = intval($promo);
		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}


}
