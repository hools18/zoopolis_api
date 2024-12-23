<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\BrandsController as Brands;

class AuthorsController extends Controller{
	
	public function __construct(){
        //
    }


	public function getList(Request $request){
		$return = [];
		$authorlist = DB::table('authors')->where('showlist', 1)->limit(20)->get();
		foreach($authorlist  as $i => $author){
			$id = intval($author->id);
			$return[$i]['id'] = $author->id;
			$return[$i]['name'] = $author->name;
			$return[$i]['biography'] = $author->biography;
			if($author->email){
				$return[$i]['email'] = $author->email;
			}
			if($author->site){
				$return[$i]['site'] = $author->site;
			}
			if($author->linkedin){
				$return[$i]['linkedin'] = $author->linkedin;
			}
			$authorPhoto = DB::table('author_photo')->where('author', $id)->where('status', 1)->first();
			if($authorPhoto){
				$return[$i]['photo'] = sprintf('%02x', $authorPhoto->a).'/'.sprintf('%02x', $authorPhoto->b).'/'.sprintf('%08x', $authorPhoto->name);
			} else {
				$return[$i]['photo'] = 'nophoto.jpg';
			}
            $authorPhotoBig = DB::table('author_photo_big')->where('author', $id)->where('status', 1)->first();
            if($authorPhotoBig){
                $return[$i]['photobig'] = sprintf('%02x', $authorPhotoBig->a).'/'.sprintf('%02x', $authorPhotoBig->b).'/'.sprintf('%08x', $authorPhotoBig->name);
            } else {
                //$return[$i]['photobig'] = $return[$i]['photo'];
            }

			$author_bookcovers = DB::table('author_bookcovers')->where('author', $id)->where('status', 1)->get();
			$return[$i]['bookcovers'] = false;
			if($author_bookcovers){
				foreach($author_bookcovers  as $bc => $data){
					$return[$i]['bookcovers'][$bc] = sprintf('%02x', $data->a).'/'.sprintf('%02x', $data->b).'/'.sprintf('%08x', $data->name);
				}
			} else {
				$return[$i]['bookcovers'] = false;
			}
			
			$industry = DB::table('author_industry')->where('authors', $id)->get();
			foreach($industry  as $data){
				$industry = DB::table('industry')->where('id', $data->industry)->first();
				$return[$i]['industry'][] = $industry->name;
			}
			$goal = DB::table('author_goal')->where('authors', $id)->get();
			foreach($goal  as $data){
				$goal = DB::table('goal')->where('id', $data->goal)->first();
				$return[$i]['goal'][] = $goal->name;
			}
			$socialmedia = DB::table('author_socialmedia')->where('authors', $id)->get();
			foreach($socialmedia  as $data){
				$socialmedia = DB::table('socialmedia')->where('id', $data->socialmedia)->first();
				$return[$i]['socialmedia'][] = $socialmedia->name;
			}
			$tonesvoice = DB::table('author_tonesvoice')->where('authors', $id)->get();
			foreach($tonesvoice  as $data){
				$tonesvoice = DB::table('tonesvoice')->where('id', $data->tonesvoice)->first();
				$return[$i]['tonesvoice'][] = $tonesvoice->name;
			}
			$author_brands = DB::table('author_brand')->where('authors', $id)->get();
			foreach($author_brands as $ib => $data){
				$return[$i]['brands'][$ib] = Brands::getBrand($data->brand);
			}
			
			
			
		}


			

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
    public static function getAuthor(Request $request){
		$return = [];
		$id = intval($request->input('id'));
		$author = DB::table('authors')->where('id', $id)->first();
		
		$id = intval($author->id);
		$return['id'] = $author->id;
		$return['name'] = $author->name;
		$return['biography'] = $author->biography;
		$return['email'] = $author->email;
		$return['site'] = $author->site;
		$return['linkedin'] = $author->linkedin;

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
                //$return['photobig'] = $return['photo'];
            }

			$author_bookcovers = DB::table('author_bookcovers')->where('author', $id)->where('status', 1)->get();
			$return['bookcovers'] = false;
			if($author_bookcovers){
				foreach($author_bookcovers  as $bc => $data){
					$return['bookcovers'][$bc] = sprintf('%02x', $data->a).'/'.sprintf('%02x', $data->b).'/'.sprintf('%08x', $data->name);
				}
			} else {
				$return['bookcovers'] = false;
			}
			
			$industry = DB::table('author_industry')->where('authors', $id)->get();
			foreach($industry  as $data){
				$industry = DB::table('industry')->where('id', $data->industry)->first();
				$return['industry'][] = $industry->name;
			}
			$goal = DB::table('author_goal')->where('authors', $id)->get();
			foreach($goal  as $data){
				$goal = DB::table('goal')->where('id', $data->goal)->first();
				$return['goal'][] = $goal->name;
			}
			$socialmedia = DB::table('author_socialmedia')->where('authors', $id)->get();
			foreach($socialmedia  as $data){
				$socialmedia = DB::table('socialmedia')->where('id', $data->socialmedia)->first();
				$return['socialmedia'][] = $socialmedia->name;
			}
			$tonesvoice = DB::table('author_tonesvoice')->where('authors', $id)->get();
			foreach($tonesvoice  as $data){
				$tonesvoice = DB::table('tonesvoice')->where('id', $data->tonesvoice)->first();
				$return['tonesvoice'][] = $tonesvoice->name;
			}
			$author_brands = DB::table('author_brand')->where('authors', $id)->get();
			foreach($author_brands as $ib => $data){
				$return['brands'][$ib] = Brands::getBrand($data->brand);
			}

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
    public static function getAuthorID($id){
        $return = [];
        $author = DB::table('authors')->where('id', $id)->first();

        $id = intval($author->id);
        $return['id'] = $author->id;
        $return['name'] = $author->name;
        $return['biography'] = $author->biography;
        $return['email'] = $author->email;
        $return['site'] = $author->site;
        $return['linkedin'] = $author->linkedin;
        $return['type'] = '';
        $return['showlist'] = $author->showlist;
        if($author->type){
            $type = DB::table('authorsType')->where('id', $author->type)->first();
            $return['type'] = $type->name;
        } else {
            $return['type'] = '';
        }

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
            //$return['photobig'] = $return['photo'];
        }

        $author_bookcovers = DB::table('author_bookcovers')->where('author', $id)->where('status', 1)->get();
        $return['bookcovers'] = false;
        if($author_bookcovers){
            foreach($author_bookcovers  as $bc => $data){
                $return['bookcovers'][$bc] = sprintf('%02x', $data->a).'/'.sprintf('%02x', $data->b).'/'.sprintf('%08x', $data->name);
            }
        } else {
            $return['bookcovers'] = false;
        }

        $industry = DB::table('author_industry')->where('authors', $id)->get();
        foreach($industry  as $data){
            $industry = DB::table('industry')->where('id', $data->industry)->first();
            $return['industry'][] = $industry->name;
        }
        $goal = DB::table('author_goal')->where('authors', $id)->get();
        foreach($goal  as $data){
            $goal = DB::table('goal')->where('id', $data->goal)->first();
            $return['goal'][] = $goal->name;
        }
        $socialmedia = DB::table('author_socialmedia')->where('authors', $id)->get();
        foreach($socialmedia  as $data){
            $socialmedia = DB::table('socialmedia')->where('id', $data->socialmedia)->first();
            $return['socialmedia'][] = $socialmedia->name;
        }
        $tonesvoice = DB::table('author_tonesvoice')->where('authors', $id)->get();
        foreach($tonesvoice  as $data){
            $tonesvoice = DB::table('tonesvoice')->where('id', $data->tonesvoice)->first();
            $return['tonesvoice'][] = $tonesvoice->name;
        }
        $author_brands = DB::table('author_brand')->where('authors', $id)->get();
        foreach($author_brands as $ib => $data){
            $return['brands'][$ib] = Brands::getBrand($data->brand);
        }

        return $return;
    }
	

}