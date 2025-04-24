<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\ArticlesController as Article;
use Intervention\Image\ImageManager;

class ConsoleController extends Controller{

	public function __construct(){
        //
    }

	public function usersList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$users = DB::table('users')->get();
			foreach($users  as $i => $user){
				$return[$i]['id'] = $user->id;
				$return[$i]['email'] = $user->email;
				$return[$i]['name'] = $user->name;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function industryAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$industry = DB::table('industry')->insertGetId([
				'name' => $name
			]);
			$industryid = intval($industry);
			$return['industryid'] = intval($industryid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function industryList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$industrylist = DB::table('industry')->get();
			foreach($industrylist  as $i => $industry){
				$return[$i]['id'] = $industry->id;
				$return[$i]['name'] = $industry->name;
				$return[$i]['link'] = '/console/industry/'.$industry->id;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function industryInfo(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$author = DB::table('industry')->where('id', $id)->first();
			$return['id'] = $author->id;
			$return['name'] = $author->name;
			$tags = DB::table('industry_tag')->where('industry', $id)->get();
			foreach($tags  as $i => $data){
				$return['tags'][] = (string)$data->tag;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function industrySave(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$name = $request->input('name');
			if($name != ''){
				$BDName = DB::table('industry')->where('id', $id)->update([
					'name' => $name
				]);
				$return['name'] = true;
			};

			$tags = $request->input('tags');
			if($tags != ''){
				$del = DB::table('industry_tag')->where('industry', $id)->delete();
				foreach($tags  as $i => $data){
					$BD = DB::table('industry_tag')->insertGetId([
						'industry' => $id,
						'tag' => $data
					]);
				}
				$return['tags'] = true;
			};

		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	// Brand
	public function brandAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$brands = DB::table('brands')->insertGetId([
				'name' => $name
			]);
			$brandid = intval($brand);
			$return['brandid'] = intval($brandid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function brandList(Request $request){
		$getUser = User::getUser($request);

		$return = [];
		if($getUser['admin']){
			$brandlist = DB::table('brands')->get();
			foreach($brandlist  as $i => $brand){
				$return[$i]['id'] = $brand->id;
				$return[$i]['name'] = $brand->name;
				$return[$i]['link'] = '/console/brands/'.$brand->id;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function brandInfo(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$brand = DB::table('brands')->where('id', $id)->first();
			$return['id'] = $brand->id;
			$return['name'] = $brand->name;
			$return['desc'] = $brand->desc;


			$logo = DB::table('brand_logo')->where('brand', $id)->where('status', 1)->first();
			if($logo){
				$filetype = 'jpg';
				if (isset($logo->type)) {
					switch ($logo->type) {
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
                $return['logoext'] = $filetype;
				$return['logo'] = sprintf('%02x', $logo->a).'/'.sprintf('%02x', $logo->b).'/'.sprintf('%08x', $logo->name);
			} else {
				$return['logo'] = 'nophoto.jpg';
			}

		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function brandSave(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		$return['dir'] = __DIR__;
		$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/';
					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
					};

		if($getUser['admin']){

			$id = intval($request->input('id'));
			$name = $request->input('name');
			$desc = $request->input('desc');
			if($name != ''){
				$BDName = DB::table('brands')->where('id', $id)->update([
					'name' => $name,
					'desc' => $desc
				]);
				$return['name'] = true;
				$return['desc'] = true;

			};

			if($request->file('logo')){
				$logoImg = $request->file('logo');
				if ($request->file('logo')->isValid()) {
					$folderA = bin2hex(random_bytes(1));
					$folderB = bin2hex(random_bytes(1));
					$fileName = bin2hex(random_bytes(4));
					$dirName = array('orig', '1200', '600', '200');

					$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/';
					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
					};
					$return['logo'] = true;

					foreach($dirName  as $i => $nd){
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/'.$nd.'/';
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/'.$nd.'/'.$folderA;
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/'.$nd.'/'.$folderA.'/'.$folderB;
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
					}

					$image = $logoImg;
					$picName = $logoImg->getClientOriginalName();
					$guessExtension = $logoImg->guessExtension();
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
					$BDName = DB::table('brand_logo')->where('brand', $id)->where('status', 1)->update([
						'status' => 2
					]);
					$DBLOGO = DB::table('brand_logo')->insertGetId([
						'brand' => $id,
						'a' => hexdec($folderA),
						'b' => hexdec($folderB),
						'name' => hexdec($fileName),
						'type' => $filetype
					]);
					$request->file('logo')->move('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);
					// Векторные типы больше 10 пропускаем.
					if($filetype <= 9){
					$manager = new ImageManager('imagick');

					$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
					$image->scale(width: 1200);

					$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
					$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
					$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

					$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
					$image->scale(width: 600);
					$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
					$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
					$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

					$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
					$image->scale(width: 200);
					$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
					$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
					$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/brandslogo/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');
                    }


					$return['logo'] = true;

				};
			};

		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function tagAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$tag = DB::table('tags')->insertGetId([
				'name' => $name
			]);
			$tagid = intval($tag);
			$return['tagid'] = intval($tagid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function tagList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$tagslist = DB::table('tags')->get();
			foreach($tagslist  as $i => $tag){
				$return[$i]['id'] = $tag->id;
				$return[$i]['name'] = $tag->name;

			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function goalAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$goal = DB::table('goal')->insertGetId([
				'name' => $name
			]);
			$goalid = intval($goal);
			$return['goalid'] = intval($goalid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function goalList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$goallist = DB::table('goal')->get();
			foreach($goallist  as $i => $goal){
				$return[$i]['id'] = $goal->id;
				$return[$i]['name'] = $goal->name;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function socialmediaAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$socialmedia = DB::table('socialmedia')->insertGetId([
				'name' => $name
			]);
			$socialmediaid = intval($socialmedia);
			$return['socialmediaid'] = intval($socialmediaid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function socialmediaList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$socialmedialist = DB::table('socialmedia')->get();
			foreach($socialmedialist  as $i => $socialmedia){
				$return[$i]['id'] = $socialmedia->id;
				$return[$i]['name'] = $socialmedia->name;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function tonesvoiceAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$tonesvoice = DB::table('tonesvoice')->insertGetId([
				'name' => $name
			]);
			$tonesvoiceid = intval($tonesvoice);
			$return['tonesvoiceid'] = intval($tonesvoiceid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function tonesvoiceList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$tonesvoicelist = DB::table('tonesvoice')->get();
			foreach($tonesvoicelist  as $i => $tonesvoice){
				$return[$i]['id'] = $tonesvoice->id;
				$return[$i]['name'] = $tonesvoice->name;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function typeList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$typelist = DB::table('authorsType')->get();
			foreach($typelist  as $i => $type){
				$return[$i]['id'] = $type->id;
				$return[$i]['name'] = $type->name;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function authorAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$name = $request->input('name');
			$author = DB::table('authors')->insertGetId([
				'name' => $name
			]);
			$authorid = intval($author);
			$return['authorid'] = intval($authorid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function authorList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$authorlist = DB::table('authors')->get();
			foreach($authorlist  as $i => $author){
				$return[$i]['id'] = $author->id;
				$return[$i]['name'] = $author->name;
				$return[$i]['link'] = '/console/authors/'.$author->id;

			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function authorInfo(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$author = DB::table('authors')->where('id', $id)->first();
			$return['id'] = $author->id;
			$return['name'] = $author->name;
			$return['biography'] = $author->biography;
			$return['email'] = $author->email;
			$return['site'] = $author->site;
			$return['linkedin'] = $author->linkedin;

			$return['twitter'] = $author->twitter;
			$return['phone'] = $author->phone;
			$return['showlist'] = $author->showlist;
			$return['type'] = $author->type;
			$authorPhoto = DB::table('author_photo')->where('author', $id)->where('status', 1)->first();
			if($authorPhoto){
				$return['photo'] = sprintf('%02x', $authorPhoto->a).'/'.sprintf('%02x', $authorPhoto->b).'/'.sprintf('%08x', $authorPhoto->name);
			} else {
				$return['photo'] = 'nophoto.jpg';
			}

            $authorPhotoBig = DB::table('author_photo_big')->where('author', $id)->where('status', 1)->first();
            if($authorPhotoBig){
                $return['photobig'] = sprintf('%02x', $authorPhotoBig->a).'/'.sprintf('%02x', $authorPhotoBig->b).'/'.sprintf('%08x', $authorPhotoBig->name);
            } else {
                $return['photobig'] = $return['photo'];
            }

			$author_bookcovers = DB::table('author_bookcovers')->where('author', $id)->where('status', 1)->get();
			$return['bookcovers'] = [];
			if($author_bookcovers){
				foreach($author_bookcovers  as $i => $data){
					$return['bookcovers'][$i] = sprintf('%02x', $data->a).'/'.sprintf('%02x', $data->b).'/'.sprintf('%08x', $data->name);
				}
			} else {
				$return['bookcovers'] = false;
			}

			$industry = DB::table('author_industry')->where('authors', $id)->get();
			foreach($industry  as $i => $data){
				$return['industry'][] = (string)$data->industry;
			}
			$goal = DB::table('author_goal')->where('authors', $id)->get();
			foreach($goal  as $i => $data){
				$return['goal'][] = (string)$data->goal;
			}
			$socialmedia = DB::table('author_socialmedia')->where('authors', $id)->get();
			foreach($socialmedia  as $i => $data){
				$return['socialmedia'][] = (string)$data->socialmedia;
			}
			$tonesvoice = DB::table('author_tonesvoice')->where('authors', $id)->get();
			foreach($tonesvoice  as $i => $data){
				$return['tonesvoice'][] = (string)$data->tonesvoice;
			}

			$brand = DB::table('author_brand')->where('authors', $id)->get();
			foreach($brand  as $i => $data){
				$return['brand'][] = (string)$data->brand;
			}

		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function authorSave(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$name = $request->input('name');
			if($name != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'name' => $name
				]);
				$return['name'] = true;
			};

			$showlist = $request->input('showlist');

			if($showlist != ''){
				if(isset($showlist[0])){
					$showlist = intval($showlist[0]);
					$BDName = DB::table('authors')->where('id', $id)->update([
						'showlist' => $showlist
					]);
					$return['showlist'] = true;
				} else {
					$BDName = DB::table('authors')->where('id', $id)->update([
						'showlist' => 0
					]);
					$return['showlist'] = true;
				}

			} else {
				/*$BDName = DB::table('authors')->where('id', $id)->update([
					'showlist' => 0
				]);
				$return['showlist'] = true;
				*/
			};

			$type = $request->input('type');
			if($type != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'type' => intval($type)
				]);
				$return['type'] = true;
			};

			$biography = $request->input('biography');
			if($biography != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'biography' => $biography
				]);
				$return['biography'] = true;
			};
			$email = $request->input('email');
			if($email != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'email' => $email
				]);
				$return['email'] = true;
			};
			$site = $request->input('site');
			if($site != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'site' => $site
				]);
				$return['site'] = true;
			};
			$linkedin = $request->input('linkedin');
			if($linkedin != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'linkedin' => $linkedin
				]);
				$return['linkedin'] = true;
			};

			$phone = $request->input('phone');
			if($phone != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'phone' => $phone
				]);
				$return['phone'] = true;
			};
			$twitter = $request->input('twitter');
			if($twitter != ''){
				$BDName = DB::table('authors')->where('id', $id)->update([
					'twitter' => $twitter
				]);
				$return['twitter'] = true;
			};

			$industry = $request->input('industry');
			if($industry != ''){
				$del = DB::table('author_industry')->where('authors', $id)->delete();
				foreach($industry  as $i => $data){
					$BD = DB::table('author_industry')->insertGetId([
						'authors' => $id,
						'industry' => $data
					]);
				}
				$return['industry'] = true;
			};


			$goal = $request->input('goal');
			if($goal != ''){
				$del = DB::table('author_goal')->where('authors', $id)->delete();
				foreach($goal  as $i => $data){
					$BD = DB::table('author_goal')->insertGetId([
						'authors' => $id,
						'goal' => $data
					]);
				}
				$return['goal'] = true;
			};
			$socialmedia = $request->input('socialmedia');
			if($socialmedia != ''){
				$del = DB::table('author_socialmedia')->where('authors', $id)->delete();
				foreach($socialmedia  as $i => $data){
					$BD = DB::table('author_socialmedia')->insertGetId([
						'authors' => $id,
						'socialmedia' => $data
					]);
				}
				$return['socialmedia'] = true;
			};
			$tonesvoice = $request->input('tonesvoice');
			if($tonesvoice != ''){
				$del = DB::table('author_tonesvoice')->where('authors', $id)->delete();
				foreach($tonesvoice  as $i => $data){
					$BD = DB::table('author_tonesvoice')->insertGetId([
						'authors' => $id,
						'tonesvoice' => $data
					]);
				}
				$return['tonesvoice'] = true;
			};

			$brands = $request->input('brands');
			if($brands != ''){
				$del = DB::table('author_brand')->where('authors', $id)->delete();
				foreach($brands  as $i => $data){
					$BD = DB::table('author_brand')->insertGetId([
						'authors' => $id,
						'brand' => $data
					]);
				}
				$return['brand'] = true;
			};

			if($request->file('photo')){
				$photoImg = $request->file('photo');
				if ($request->file('photo')->isValid()) {
					$folderA = bin2hex(random_bytes(1));
					$folderB = bin2hex(random_bytes(1));
					$fileName = bin2hex(random_bytes(4));
					$dirName = array('orig', '1200', '600', '200');
					$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/';
					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
					};
					$return['photo'] = true;
					foreach($dirName  as $i => $nd){
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/'.$nd.'/';
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/'.$nd.'/'.$folderA;
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/'.$nd.'/'.$folderA.'/'.$folderB;
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
					}
					$image = $photoImg;
					$picName = $photoImg->getClientOriginalName();
					$guessExtension = $photoImg->guessExtension();
					$picName = uniqid() . '_' . $picName;
					$filetype = 0;
					if (isset($guessExtension)) {
						switch ($guessExtension) {
							case 'jpg':
								$filetype = 1;
							break;
							case 'png':
								$filetype = 2;
							break;
						}
					}
					$BDName = DB::table('author_photo')->where('author', $id)->where('status', 1)->update([
						'status' => 2
					]);
					$DBLOGO = DB::table('author_photo')->insertGetId([
						'author' => $id,
						'a' => hexdec($folderA),
						'b' => hexdec($folderB),
						'name' => hexdec($fileName),
						'type' => $filetype
					]);
					$request->file('photo')->move('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);

					$manager = new ImageManager('imagick');

					$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
					$image->scale(width: 1200);
					$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
					$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
					$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

					$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
					$image->scale(width: 600);
					$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
					$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
					$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

					$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
					$image->scale(width: 200);
					$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
					$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
					$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphoto/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');
					$return['img'] = true;

				};
			};
            if($request->file('photobig')){
                $photoImg = $request->file('photobig');
                if ($request->file('photobig')->isValid()) {
                    $folderA = bin2hex(random_bytes(1));
                    $folderB = bin2hex(random_bytes(1));
                    $fileName = bin2hex(random_bytes(4));
                    $dirName = array('orig', '1200', '600', '200');
                    $dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/';
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    };
                    $return['photo'] = true;
                    foreach($dirName  as $i => $nd){
                        $dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/'.$nd.'/';
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        };
                        $dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/'.$nd.'/'.$folderA;
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        };
                        $dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/'.$nd.'/'.$folderA.'/'.$folderB;
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        };
                    }
                    $image = $photoImg;
                    $picName = $photoImg->getClientOriginalName();
                    $guessExtension = $photoImg->guessExtension();
                    $picName = uniqid() . '_' . $picName;
                    $filetype = 0;
                    if (isset($guessExtension)) {
                        switch ($guessExtension) {
                            case 'jpg':
                                $filetype = 1;
                                break;
                            case 'png':
                                $filetype = 2;
                                break;
                        }
                    }
                    $BDName = DB::table('author_photo_big')->where('author', $id)->where('status', 1)->update([
                        'status' => 2
                    ]);
                    $DBLOGO = DB::table('author_photo_big')->insertGetId([
                        'author' => $id,
                        'a' => hexdec($folderA),
                        'b' => hexdec($folderB),
                        'name' => hexdec($fileName),
                        'type' => $filetype
                    ]);
                    $request->file('photobig')->move('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);

                    $manager = new ImageManager('imagick');

                    $image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
                    $image->scale(width: 1200);
                    $image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
                    $image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
                    $image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

                    $image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
                    $image->scale(width: 600);
                    $image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
                    $image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
                    $image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

                    $image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
                    $image->scale(width: 200);
                    $image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
                    $image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
                    $image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/authorsphotobig/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');
                    $return['img'] = true;

                };
            };
			$return['file'] = true;
			$return['request'] = $request;

			if($request->file('bookcovers')){
				$return['bookcovers_load'] = true;
				$bookcovers = $request->file('bookcovers');
				foreach($request->file('bookcovers') as $key => $file){
						$folderA = bin2hex(random_bytes(1));
						$folderB = bin2hex(random_bytes(1));
						$fileName = bin2hex(random_bytes(4));
						$dirName = array('orig', '1200', '600', '200');
						$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/';
						if (!file_exists($dir)) {
							mkdir($dir, 0777, true);
						};
						$return['bookcovers'] = true;
						foreach($dirName  as $i => $nd){
							$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/'.$nd.'/';
							if (!file_exists($dir)) {
								mkdir($dir, 0777, true);
							};
							$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/'.$nd.'/'.$folderA;
							if (!file_exists($dir)) {
								mkdir($dir, 0777, true);
							};
							$dir = '/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/'.$nd.'/'.$folderA.'/'.$folderB;
							if (!file_exists($dir)) {
								mkdir($dir, 0777, true);
							};
						}
						$image = $file;
						$picName = $file->getClientOriginalName();
						$guessExtension = $file->guessExtension();
						$picName = uniqid() . '_' . $picName;
						$filetype = 0;
						if (isset($guessExtension)) {
							switch ($guessExtension) {
								case 'jpg':
									$filetype = 1;
								break;
								case 'png':
									$filetype = 2;
								break;
							}
						}
						$DBLOGO = DB::table('author_bookcovers')->insertGetId([
							'author' => $id,
							'a' => hexdec($folderA),
							'b' => hexdec($folderB),
							'name' => hexdec($fileName),
							'type' => $filetype
						]);
						$file->move('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);

						$manager = new ImageManager('imagick');

						$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
						$image->scale(width: 1200);
						$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
						$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
						$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/1200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

						$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
						$image->scale(width: 600);
						$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
						$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
						$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');

						$image = $manager->make('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
						$image->scale(width: 200);
						$image->toJpeg()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.jpg', 93, 'jpg');
						$image->toWebp()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.webp', 93, 'webp');
						$image->toPng()->save('/var/www/platform_ute_usr/data/www/platform.utempla.com/bookcovers/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.png');
						$return['img'] = true;

				};


			};
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function articlesAdd(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$title = $request->input('title');
			$article = DB::table('articles')->insertGetId([
				'title' => $title
			]);
			$articleid = intval($article);
			$return['articleid'] = intval($articleid);
		} else {
			$return['err'] = 'No access';
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

	}
	public function articlesList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$articleslist = DB::table('articles')->get();
			foreach($articleslist  as $i => $data){
				$return[$i]['id'] = $data->id;
				$return[$i]['title'] = $data->title;
				$return[$i]['status'] = $data->status;

				$return[$i]['context'] = Article::EZClean($data->context);
				$return[$i]['link'] = '/console/articles/'.$data->id;

			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function articlesInfo(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$article = DB::table('articles')->where('id', $id)->first();
			$return['id'] = $article->id;
			$return['title'] = $article->title;
			$return['context'] = $article->context;
			$return['preview'] = Article::EZ($article->context);

			$return['status'] = $article->status;
			$industry = DB::table('article_industry')->where('article', $id)->get();
			foreach($industry  as $i => $data){
				$return['industry'][] = (string)$data->industry;
			}
			$goal = DB::table('article_goal')->where('article', $id)->get();
			foreach($goal  as $i => $data){
				$return['goal'][] = (string)$data->goal;
			}
			$socialmedia = DB::table('article_socialmedia')->where('article', $id)->get();
			foreach($socialmedia  as $i => $data){
				$return['socialmedia'][] = (string)$data->socialmedia;
			}
			$tonesvoice = DB::table('article_tonesvoice')->where('article', $id)->get();
			foreach($tonesvoice  as $i => $data){
				$return['tonesvoice'][] = (string)$data->tonesvoice;
			}
			$tags = DB::table('article_tags')->where('article', $id)->get();
			foreach($tags  as $i => $data){
				$return['tags'][] = (string)$data->tag;
			}
			$authors = DB::table('article_authors')->where('article', $id)->get();
			foreach($authors  as $i => $data){
				$return['authors'][] = (string)$data->author;
			}
		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function articlesInfoSave(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));
			$title = $request->input('title');
			if($title != ''){
				$BD = DB::table('articles')->where('id', $id)->update([
					'title' => $title
				]);
				$return['title'] = true;
			};
			$context = $request->input('context');

			$context = strip_tags($context, '<p><a><div>');
			//$context = htmlentities($context);
			$context = str_replace("&nbsp;",'',$context);
			if($context != ''){
				$BDN = DB::table('articles')->where('id', $id)->update([
					'context' => $context
				]);
				$return['context'] = true;
			};
			$authors = $request->input('authors');
			if($authors != ''){
				$del = DB::table('article_authors')->where('article', $id)->delete();
				foreach($authors  as $i => $data){
					$BD = DB::table('article_authors')->insertGetId([
						'article' => $id,
						'author' => $data
					]);
				}
				$return['authors'] = true;
			};
			$industry = $request->input('industry');
			if($industry != ''){
				$del = DB::table('article_industry')->where('article', $id)->delete();
				foreach($industry  as $i => $data){
					$BD = DB::table('article_industry')->insertGetId([
						'article' => $id,
						'industry' => $data
					]);
				}
				$return['industry'] = true;
			};
			$goal = $request->input('goal');
			if($goal != ''){
				$del = DB::table('article_goal')->where('article', $id)->delete();
				foreach($goal  as $i => $data){
					$BD = DB::table('article_goal')->insertGetId([
						'article' => $id,
						'goal' => $data
					]);
				}
				$return['goal'] = true;
			};
			$socialmedia = $request->input('socialmedia');
			if($socialmedia != ''){
				$del = DB::table('article_socialmedia')->where('article', $id)->delete();
				foreach($socialmedia  as $i => $data){
					$BD = DB::table('article_socialmedia')->insertGetId([
						'article' => $id,
						'socialmedia' => $data
					]);
				}
				$return['socialmedia'] = true;
			};
			$tonesvoice = $request->input('tonesvoice');
			if($tonesvoice != ''){
				$del = DB::table('article_tonesvoice')->where('article', $id)->delete();
				foreach($tonesvoice  as $i => $data){
					$BD = DB::table('article_tonesvoice')->insertGetId([
						'article' => $id,
						'tonesvoice' => $data
					]);
				}
				$return['tonesvoice'] = true;
			};

			$tags = $request->input('tags');
			if($tags != ''){
				$del = DB::table('article_tags')->where('article', $id)->delete();
				foreach($tags  as $i => $data){
					$BD = DB::table('article_tags')->insertGetId([
						'article' => $id,
						'tag' => $data
					]);
				}
				$return['tag'] = true;
			};


		} else {
			$return['err'] = 'No access';

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function importCsvArticle(Request $request){
		$return = [];
		if($request->file('csv')){
			$csv = $request->file('csv');

			$filename = $_FILES["csv"]["tmp_name"];
			$file = fopen($filename, "r");
			$i = 0;
			while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
				if($i >= 1){
					$double = DB::table('articles')->where('context', 'like', $getData[0])->count();
					$return['data'][$i]['double'] = $double;

					$cleantext = Article::EZClean($getData[0]);
					$cleantext = mb_strimwidth($cleantext, 0, 60);
					if($double == 0){

					//0 - Text
					$ArticleID = DB::table('articles')->insertGetId([
						'title' => $cleantext,
						'context' => $getData[0]
					]);
					//1 - indystry
					$industrylist = explode(', ', $getData[1]);
					foreach ($industrylist as $ind_i => $data) {
						$industry = DB::table('industry')->where('name', $data)->first();
						if($industry){
							$AddGoal = DB::table('article_industry')->insertGetId([
								'article' => $ArticleID,
								'industry' => $industry->id
							]);
						}
					}
					//2 - Goal
					$goal = explode(', ', $getData[2]);
					foreach ($goal as $goal_i => $data) {
						$goal = DB::table('goal')->where('name', $data)->first();
						if($goal){
							$AddGoal = DB::table('article_goal')->insertGetId([
								'article' => $ArticleID,
								'goal' => $goal->id
							]);
						}
					}
					//3 - For social media
					$socmedia = explode(', ', $getData[3]);
					foreach ($socmedia as $sm_i => $data) {
						$sm = DB::table('socialmedia')->where('name', $data)->first();
						if($sm){
							$AddSm = DB::table('article_socialmedia')->insertGetId([
								'article' => $ArticleID,
								'socialmedia' => $sm->id
							]);
						}
					}
					//4 - Tone of voice
					$toneofvoice = explode(', ', $getData[4]);
					foreach ($toneofvoice as $tv_i => $data) {
						$tv = DB::table('tonesvoice')->where('name', $data)->first();
						if($tv){
							$AddTv = DB::table('article_tonesvoice')->insertGetId([
								'article' => $ArticleID,
								'tonesvoice' => $tv->id
							]);
						}
					}
					//5 - TAGS
					$tagslist = explode(', ', $getData[5]);
					foreach ($tagslist as $tags_i => $data) {
						$tag = DB::table('tags')->where('name', $data)->first();
						if($tag){
							$AddTv = DB::table('article_tags')->insertGetId([
								'article' => $ArticleID,
								'tag' => $tag->id
							]);
						} else {
							$newTag = DB::table('tags')->insertGetId([
								'name' => $data
							]);
							$AddTv = DB::table('article_tags')->insertGetId([
								'article' => $ArticleID,
								'tag' => $newTag
							]);

						}
					}
					//6 - Authors 1
					$authors = DB::table('authors')->where('name', $getData[6])->first();
					if($authors){
						$AddAuthor = DB::table('article_authors')->insertGetId([
							'article' => $ArticleID,
							'author' => $authors->id
						]);
					}
					//7 - Authors 2
					$authors = DB::table('authors')->where('name', $getData[7])->first();
					if($authors){
						$AddAuthor = DB::table('article_authors')->insertGetId([
							'article' => $ArticleID,
							'author' => $authors->id
						]);
					}


					//$goal = $getData[2];

					} else {
						$return['double'][] = '['.($i + 1).'] '.$getData[0];
					}
					$tagslist = explode(', ', $getData[5]);
					foreach ($tagslist as $tags_i => $data) {
						$tag = DB::table('tags')->where('name', $data)->first();
						if($tag){
							$return['data'][$i]['tags'][$tags_i] = $tag;
						}
					}

					$return['data'][$i]['t'] = $cleantext;
					$return['data'][$i]['c'] = $getData[0];
				}

				$i++;
			}
			$svgArray = fgetcsv($file, 100000, ",");

			fclose($file);
			$return['load'] = true;
			$return['csv'] = $csv;
		} else {
			$return['load'] = false;

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function previewText(Request $request){
		$context = $request->input('context');
		//print_r($var);
		$return['context'] = Article::EZ($context);
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}


	public function alllist(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){

			$industrylist = DB::table('industry')->get();
			foreach($industrylist  as $i => $industry){
				$return['industry'][$i]['id'] = $industry->id;
				$return['industry'][$i]['name'] = $industry->name;
				$return['industry'][$i]['link'] = '/console/industry/'.$industry->id;
			}
			$brandlist = DB::table('brands')->get();
			foreach($brandlist  as $i => $brand){
				$return['brands'][$i]['id'] = $brand->id;
				$return['brands'][$i]['name'] = $brand->name;
				$return['brands'][$i]['link'] = '/console/brands/'.$brand->id;
			}
			$tagslist = DB::table('tags')->get();
			foreach($tagslist  as $i => $tag){
				$return['tags'][$i]['id'] = $tag->id;
				$return['tags'][$i]['name'] = $tag->name;
				$return['tags'][$i]['link'] = '/console/tags/'.$tag->id;

			}
			$goallist = DB::table('goal')->get();
			foreach($goallist  as $i => $goal){
				$return['goal'][$i]['id'] = $goal->id;
				$return['goal'][$i]['name'] = $goal->name;
				$return['goal'][$i]['link'] = '/console/tags/'.$goal->id;
			}
			$socialmedialist = DB::table('socialmedia')->get();
			foreach($socialmedialist  as $i => $socialmedia){
				$return['socialmedia'][$i]['id'] = $socialmedia->id;
				$return['socialmedia'][$i]['name'] = $socialmedia->name;
				$return['socialmedia'][$i]['link'] = '/console/socialmedia/'.$socialmedia->id;
			}
			$tonesvoicelist = DB::table('tonesvoice')->get();
			foreach($tonesvoicelist  as $i => $tonesvoice){
				$return['tonesvoice'][$i]['id'] = $tonesvoice->id;
				$return['tonesvoice'][$i]['name'] = $tonesvoice->name;
				$return['tonesvoice'][$i]['link'] = '/console/tonesvoice/'.$tonesvoice->id;
			}
			$authorlist = DB::table('authors')->get();
			foreach($authorlist  as $i => $author){
				$return['authors'][$i]['id'] = $author->id;
				$return['authors'][$i]['name'] = $author->name;
				$return['authors'][$i]['link'] = '/console/authors/'.$author->id;
			}

			$typelist = DB::table('authorsType')->get();
			foreach($typelist  as $i => $type){
				$return['type'][$i]['id'] = $type->id;
				$return['type'][$i]['name'] = $type->name;
				$return['type'][$i]['link'] = '/console/type/'.$type->id;
			}

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	// DELETE
	public function articleDelete(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$id = intval($request->input('id'));

			$del = DB::table('user_copy')->where('article', $id)->delete();

			$del = DB::table('article_authors')->where('article', $id)->delete();
			$del = DB::table('article_goal')->where('article', $id)->delete();
			$del = DB::table('article_industry')->where('article', $id)->delete();
			$del = DB::table('article_socialmedia')->where('article', $id)->delete();
			$del = DB::table('article_tags')->where('article', $id)->delete();
			$del = DB::table('article_tonesvoice')->where('article', $id)->delete();
			$del = DB::table('articles')->where('id', $id)->delete();
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function clientsSearch(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			//$id = intval($request->input('id'));
			$usersListCount = DB::table('users')->count();
			$usersList = DB::table('users')->get();


			$return['pagination']['count_all'] = $usersListCount;
			foreach($usersList  as $i => $data){
				$userID = $data->id;
				$return['client'][$i]['id'] = $data->id;
				$return['client'][$i]['phone'] = $data->phone;
				$return['client'][$i]['email'] = $data->email;

				$return['client'][$i]['first'] = $data->first;
				$return['client'][$i]['last'] = $data->last;
				$return['client'][$i]['is_blocked'] = $data->is_blocked;


				$checkZooid = DB::table('sub_zooid_user')->where('user', $userID)->where('status', 3)->where('end', '>=', DB::raw('now()'))->first();
				if($checkZooid){
					$return['client'][$i]['zooid']['status'] = true;
					$return['client'][$i]['zooid']['start'] = $checkZooid->start;
					$return['client'][$i]['zooid']['end'] = $checkZooid->end;
				} else {
					$return['client'][$i]['zooid']['status'] = false;
				}

				$checkConcierge = DB::table('sub_concierge_user')->where('user', $userID)->where('end', '>=', DB::raw('now()'))->first();
				if($checkConcierge){
					$return['client'][$i]['concierge']['status'] = true;
					$return['client'][$i]['concierge']['start'] = $checkConcierge->start;
					$return['client'][$i]['concierge']['end'] = $checkConcierge->end;
				} else {
					$return['client'][$i]['concierge']['status'] = false;
				}

				$checkZoopolis = DB::table('sub_zoopolis_user')->where('user', $userID)->where('end', '>=', DB::raw('now()'))->first();
				if($checkZoopolis){
					$return['client'][$i]['zoopolis']['status'] = true;
					$return['client'][$i]['zoopolis']['start'] = $checkZoopolis->start;
					$return['client'][$i]['zoopolis']['end'] = $checkZoopolis->end;
				} else {
					$return['client'][$i]['zoopolis']['status'] = false;
				}

			}
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function clientInfo(Request $request, $clientID){
		$getUser = User::getUser($request);
		$return = [];
		if($getUser['admin']){
			$clientID = intval($clientID);
			//$id = intval($request->input('id'));
			$return = $getUser = User::getUser($request, $clientID);

			$checkZooid = DB::table('sub_zooid_user')->where('user', $clientID)->where('status', 3)->where('end', '>=', DB::raw('now()'))->first();
			if($checkZooid){
				$return['zooid']['status'] = true;
				$return['zooid']['start'] = $checkZooid->start;
				$return['zooid']['end'] = $checkZooid->end;
			} else {
				$return['zooid']['status'] = false;
			}

			$checkConcierge = DB::table('sub_concierge_user')->where('user', $clientID)->where('end', '>=', DB::raw('now()'))->first();
			if($checkConcierge){
				$return['concierge']['status'] = true;
				$return['concierge']['start'] = $checkConcierge->start;
				$return['concierge']['end'] = $checkConcierge->end;
			} else {
				$return['concierge']['status'] = false;
			}

			$checkZoopolis = DB::table('sub_zoopolis_user')->where('user', $clientID)->where('end', '>=', DB::raw('now()'))->first();
			if($checkZoopolis){
				$return['zoopolis']['status'] = true;
				$return['zoopolis']['start'] = $checkZoopolis->start;
				$return['zoopolis']['end'] = $checkZoopolis->end;
			} else {
				$return['zoopolis']['status'] = false;
			}

            $checkZoopolis = DB::table('sub_zoopolis_user')->where('user', $clientID)->where('end', '>=', DB::raw('now()'))->first();
            if($checkZoopolis){
                $return['zoopolis']['status'] = true;
                $return['zoopolis']['start'] = $checkZoopolis->start;
                $return['zoopolis']['end'] = $checkZoopolis->end;
            } else {
                $return['zoopolis']['status'] = false;
            }


		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function createNewUser(Request $request){
		$json = [];
		$getUser = User::getUser($request);
		if($getUser['admin']){

		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		$login = $request->input('login'); // Номер телефона
		$login = preg_replace("/[^0-9]/", "", $login);
		if($login){
		} else {
			$json['err'][] = 'Неверный формат номера телефона.';
		}

		if(isset($json['err'])){
			// Ошибки.
		} else {
			$phoneCheck = DB::table('users')->where('phone', $login)->count();
			if($phoneCheck == 1){
				$json['err'][] = 'Данный номер телефона уже зарегистрирован.';
				$json['login'] = 'Данный номер телефона уже зарегистрирован.';
			} else {
				$createUser = DB::table('users')->insertGetId([
					'phone' => $login
				]);
				$json['userID'] = intval($createUser);
			}
		}
        return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

	public function serviceList(Request $request, $type){
		$json = [];
		$getUser = User::getUser($request);
		if($getUser['admin']){
			if($type){
				if($type == 'zooid'){
					$serviceList = DB::table('zooid')->where('delete', 0)->get();
				}
				if($type == 'concierge'){
					$serviceList = DB::table('concierge')->where('delete', 0)->get();
				}
				if($type == 'zoopolis'){
					$serviceList = DB::table('zoopolis')->where('delete', 0)->get();
				}
				foreach($serviceList  as $i => $data){
					$json[$i]['id'] = $data->id;
					$json[$i]['name'] = $data->name;
					$json[$i]['descshort'] = $data->descshort;
					$json[$i]['desc'] = $data->desc;
					$json[$i]['BYN'] = $data->BYN;
					$json[$i]['RUB'] = $data->RUB;
					if($data->hide == 1){
						$json[$i]['hide'] = $data->hide;
					}
				}
			}

		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
        return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

	public function serviceNew(Request $request, $type){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$name = $request->input('name');
			if($type == 'zooid'){
				$service = DB::table('zooid')->insertGetId([
					'name' => $name
				]);
			}
			if($type == 'concierge'){
				$service = DB::table('concierge')->insertGetId([
					'name' => $name
				]);
			}
			if($type == 'zoopolis'){
				$service = DB::table('zoopolis')->insertGetId([
					'name' => $name
				]);
			}

			$json['service'] = intval($service);
		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}


	public function serviceUpdate(Request $request, $type, $id){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$json = [];

			$promo = [];

			// Название
			$name = $request->input('name');
			if($name != ''){
				$service['name'] = $name;
			};
			// BYN
			$BYN = $request->input('BYN');
			if($BYN != ''){
				$service['BYN'] = $BYN;
			};
			// RUB
			$RUB = $request->input('RUB');
			if($RUB != ''){
				$service['RUB'] = $RUB;
			};

			if($type == 'zooid'){
				$update = DB::table('zooid')->where('id', $id)->update($service);
			}
			if($type == 'concierge'){
				$update = DB::table('concierge')->where('id', $id)->update($service);
			}
			if($type == 'zoopolis'){
				$update = DB::table('zoopolis')->where('id', $id)->update($service);
			}

		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function serviceDelete(Request $request, $type, $id){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$json = [];

			$service['delete'] = 1;
			if($type == 'zooid'){
				$update = DB::table('zooid')->where('id', $id)->update($service);
			}
			if($type == 'concierge'){
				$update = DB::table('concierge')->where('id', $id)->update($service);
			}
			if($type == 'zoopolis'){
				$update = DB::table('zoopolis')->where('id', $id)->update($service);
			}
		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}

	public function serviceHide(Request $request, $type, $id){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$json = [];

			$service['hide'] = 1;
			if($type == 'zooid'){
				$update = DB::table('zooid')->where('id', $id)->update($service);
			}
			if($type == 'concierge'){
				$update = DB::table('concierge')->where('id', $id)->update($service);
			}
			if($type == 'zoopolis'){
				$update = DB::table('zoopolis')->where('id', $id)->update($service);
			}
		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function serviceShow(Request $request, $type, $id){
		$getUser = User::getUser($request);
		if($getUser['admin']){
			$json = [];

			$service['hide'] = 0;
			if($type == 'zooid'){
				$update = DB::table('zooid')->where('id', $id)->update($service);
			}
			if($type == 'concierge'){
				$update = DB::table('concierge')->where('id', $id)->update($service);
			}
			if($type == 'zoopolis'){
				$update = DB::table('zoopolis')->where('id', $id)->update($service);
			}
		} else {
			$json['err'][] = 'У вас нет прав доступа';
		}
		return response()->json($json, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
}
