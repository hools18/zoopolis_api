<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\TagsController as Tags;
use App\Http\Controllers\ArticlesController as Article;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller{
	
	public function __construct(){
        //
    }
	function getAuthor($id){ 
		$return = [];
		
		if(Cache::get('author_'.$id)){
			$author = Cache::get('author_'.$id);
		} else {
			$author = DB::table('authors')->where('id', $id)->first();
			Cache::put('author_'.$id, $author, env('CACHE_TIME_AUTHOR'));
		}
		
		$return['id'] = $author->id;
		$return['name'] = $author->name;
		$return['type'] = $author->type;

		if($author->type){
			
			$type = DB::table('authorsType')->where('id', $author->type)->first();
			$return['type'] = $type->name;
		} else {
			$return['type'] = '';
		}
		
		if(Cache::get('author_photo_'.$id)){
			$photo = Cache::get('author_photo_'.$id);
		} else {
			$photo = DB::table('author_photo')->where('author', $id)->where('status', 1)->first();
			Cache::put('author_photo_'.$id, $photo, env('CACHE_TIME_AUTHOR_PHOTO'));
		}

		if($photo){
			$filetype = 'jpg';
			if (isset($photo->type)) {
				switch ($photo->type) {
					case 1:
						$filetype = 'jpg';
					break;
					case 2:
						$filetype = 'jpg';
					break;
				}
			}
			$return['photo'] = sprintf('%02x', $photo->a).'/'.sprintf('%02x', $photo->b).'/'.sprintf('%08x', $photo->name);
		} else {
			$return['photo'] = 'nophoto.jpg';
		}
		return $return;
    }
	function getTagName($id){  
		$return = [];

		if(Cache::get('TN'.$id)){
			$tag = Cache::get('TN'.$id);
		} else {
			$tag = DB::table('tags')->where('id', $id)->first();
			Cache::put('T'.$id, $tag, env('CACHE_TIME_TAGS'));
		}
		return $tag->name;
    }
	function getSocialmediaName($id){  
		$return = [];
		$socialmedia = DB::table('socialmedia')->where('id', $id)->first();		
		return $socialmedia;
    }
	
	function getIndustryTags($id){  
		$return = [];
		$dataList = DB::table('industry_tag')->where('industry', $id)->get();
		foreach($dataList  as $i => $data){
			$return[$i]['id'] = $data->tag;
			$return[$i]['name'] = Tags::getTag($data->tag)->name;
		}
		return $return;
    }
	public function configs(Request $request){
		$return = [];
		
		$industryList = DB::table('industry')->get();
		foreach($industryList  as $i => $data){
			$return['industry'][$i]['id'] = $data->id;
			$return['industry'][$i]['name'] = $data->name;
			//$return['industry'][$i]['tags'] = $this->getIndustryTags($data->id);
		}
		$goalList = DB::table('goal')->get();
		foreach($goalList  as $i => $data){
			$return['goal'][$i]['id'] = $data->id;
			$return['goal'][$i]['name'] = $data->name;
		}
		$socialmediaList = DB::table('socialmedia')->get();
		foreach($socialmediaList  as $i => $data){
			$return['socialmedia'][$i]['id'] = $data->id;
			$return['socialmedia'][$i]['name'] = $data->name;
		}
		$tonesvoiceList = DB::table('tonesvoice')->get();
		foreach($tonesvoiceList  as $i => $data){
			$return['tonesvoice'][$i]['id'] = $data->id;
			$return['tonesvoice'][$i]['name'] = $data->name;
		}

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function search(Request $request){
		$start = microtime(true);
		$memory = memory_get_usage();
		$return = [];
        $token = $request->header('Authorization');
        $guest = $request->input('guest');
		$articleIDs = array();
		$industryIDs = array();
		$tagsIDs = array();
		$goalIDs = array();
		$socialmediaIDs = array();
		$tonesvoiceIDs = array();
		
		$page = 1;
		$offset = 0;
		if($request->input('page')){
			$page = (int)$request->input('page');
			$offset = ($page - 1) * 15;
		}
		
		
		$industry = $request->input('industry');
		if($industry != ''){
			foreach($industry  as $i => $data){
				array_push($industryIDs, (int)$data);
				$return['industry'][$i] = (int)$data;
			}
			if($industryIDs){
				$articleGetIDS = DB::table('article_industry')->whereIn('industry', $industryIDs)->get();
				foreach($articleGetIDS  as $i => $data){
					array_push($articleIDs, (int)$data->article);		
				}
			}
		}
		$return['industry_articleIDs'] = $articleIDs;	
		
		$tags = $request->input('tags');
		if($tags != ''){
			foreach($tags  as $i => $data){
				array_push($tagsIDs, (int)$data);
				$return['tags'][$i] = (int)$data;
			}
			if($tagsIDs){
				if($articleIDs){
					$articleGetIDS = DB::table('article_tags')->whereIn('tag', $tagsIDs)->whereIn('article', $articleIDs)->get();
				} else {
					$articleGetIDS = DB::table('article_tags')->whereIn('tag', $tagsIDs)->get();
				}			
				$articleIDs = array();
				foreach($articleGetIDS  as $i => $data){
					array_push($articleIDs, (int)$data->article);		
				}
			}
		}
		

		$return['tags_articleIDs'] = $articleIDs;		
		$goal = $request->input('goal');
		if($goal != ''){
			foreach($goal  as $i => $data){
				array_push($goalIDs, (int)$data);
				$return['goal'][$i] = (int)$data;
			}
			if($goalIDs){
				if($articleIDs){
					$articleGetIDS = DB::table('article_goal')->whereIn('goal', $goalIDs)->whereIn('article', $articleIDs)->get();
				} else {
					$articleGetIDS = DB::table('article_goal')->whereIn('goal', $goalIDs)->get();
				}			
				$articleIDs = array();
				foreach($articleGetIDS  as $i => $data){
					array_push($articleIDs, (int)$data->article);		
				}
			}
		}
		$return['goal_articleIDs'] = $articleIDs;
		
		$socialmedia = $request->input('socialmedia');
		if($socialmedia != ''){
			foreach($socialmedia  as $i => $data){
				array_push($socialmediaIDs, (int)$data);
				$return['socialmedia'][$i] = (int)$data;
			}
			if($socialmediaIDs){
				if($articleIDs){
					$articleGetIDS = DB::table('article_socialmedia')->whereIn('socialmedia', $socialmediaIDs)->whereIn('article', $articleIDs)->get();
				} else {
					$articleGetIDS = DB::table('article_socialmedia')->whereIn('socialmedia', $socialmediaIDs)->get();
				}			
				$articleIDs = array();
				foreach($articleGetIDS  as $i => $data){
					array_push($articleIDs, (int)$data->article);		
				}
			}
		}
		$return['socialmedia_articleIDs'] = $articleIDs;
		
		$tonesvoice = $request->input('tonesvoice');
		if($tonesvoice != ''){
			foreach($tonesvoice  as $i => $data){
				array_push($tonesvoiceIDs, (int)$data);
				$return['tonesvoice'][$i] = (int)$data;
			}
			if($tonesvoiceIDs){
				if($articleIDs){
					$articleGetIDS = DB::table('article_tonesvoice')->whereIn('tonesvoice', $tonesvoiceIDs)->whereIn('article', $articleIDs)->get();
				} else {
					$articleGetIDS = DB::table('article_tonesvoice')->whereIn('tonesvoice', $tonesvoiceIDs)->get();
				}			
				$articleIDs = array();
				foreach($articleGetIDS  as $i => $data){
					array_push($articleIDs, (int)$data->article);		
				}
			}
		}
		$return['tonesvoice_articleIDs'] = $articleIDs;
        $articleIDsNONIN = array();
        if($token) {
            if ($token =! 'false') {
                // Гость
                $getUser = User::getGuest($guest);
                $userID = $getUser['id'];

                $articles = DB::table('user_copy')
                    ->join('articles', 'articles.id', '=', 'user_copy.article')
                    ->select('user_copy.*', 'articles.*')
                    ->where('user_copy.guest', $userID)
                    ->get();
                foreach($articles  as $i => $data){
                    array_push($articleIDsNONIN, (int)$data->article);
                }
            } else {
                if($guest){
                    // Гость
                    $getUser = User::getGuest($guest);
                    $userID = $getUser['id'];

                    $articles = DB::table('user_copy')
                        ->join('articles', 'articles.id', '=', 'user_copy.article')
                        ->select('user_copy.*', 'articles.*')
                        ->where('user_copy.guest', $userID)
                        ->get();

                    foreach($articles  as $i => $data){
                        array_push($articleIDsNONIN, (int)$data->article);
                    }
                } else {
                    // Зарегистрированный
                    /*
                    $getUser = User::getUser($request);
                    $userID = $getUser['id'];

                    $articles = DB::table('user_copy')
                        ->join('articles', 'articles.id', '=', 'user_copy.article')
                        ->select('user_copy.*', 'articles.*')
                        ->where('user_copy.user', $userID)
                        ->get();
                    foreach($articles  as $i => $data){
                        array_push($articleIDsNONIN, (int)$data->article);
                    }
                    */
                }

            }

        }
		
		if($articleIDs){
            if($articleIDsNONIN){
                $articles = DB::table('articles')->offset($offset)->whereIn('id', $articleIDs)->whereNotIn('id', $articleIDsNONIN)->limit(15)->get();
                $articlesCount = DB::table('articles')->whereIn('id', $articleIDs)->whereNotIn('id', $articleIDsNONIN)->count();
            } else {
                $articles = DB::table('articles')->offset($offset)->whereIn('id', $articleIDs)->limit(15)->get();
                $articlesCount = DB::table('articles')->whereIn('id', $articleIDs)->count();
            }

		} else {
            if($articleIDsNONIN){
                $articles = DB::table('articles')->whereNotIn('id', $articleIDsNONIN)->offset($offset)->limit(15)->get();
                $articlesCount = DB::table('articles')->whereNotIn('id', $articleIDsNONIN)->count();
            } else {
                $articles = DB::table('articles')->offset($offset)->limit(15)->get();
                $articlesCount = DB::table('articles')->count();
            }

		}
		$return['count'] = $articlesCount;
		foreach($articles  as $ind_artriicle => $article){
			$id = $article->id;
			$return['articles'][$ind_artriicle] = Article::getArticle($id);			
			
			/*
			$socialmedia = DB::table('article_socialmedia')->where('article', $id)->get();
			foreach($socialmedia  as $i_cm => $data){
				$return['articles'][$ind_artriicle]['socialmedia'][$i_cm] = $this->getSocialmediaName($data->socialmedia);
			}
			*/
		}
		
		// $return['error'] = 'Error loading data from search engine';
		$return['t'] = (microtime(true) - $start);
		$i = 0;
		while (floor($memory / 1024) > 0) {
		  $i++;
		  $memory /= 1024;
		}
		$name = array('байт', 'КБ', 'МБ');
		$return['m'] = round($memory, 2) . ' ' . $name[$i];

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
	public function mytexts(Request $request){
		$start = microtime(true);
		$memory = memory_get_usage();
		$return = [];
		$token = $request->header('Authorization');
		$guest = $request->input('guest');
		$page = 1;
		$offset = 0;
		if($request->input('page')){
			$page = (int)$request->input('page');
			$offset = ($page - 1) * 15;
		}
		$return['count'] = 0;
		if($token){
			if($token =! 'false'){
				// Гость
				$getUser = User::getGuest($guest);
				$userID = $getUser['id'];

				$articles = DB::table('user_copy')
				->join('articles', 'articles.id', '=', 'user_copy.article')
				->select('user_copy.*', 'articles.*')
				->where('user_copy.guest', $userID)
				->offset($offset)
				->limit(15)
				->get();
				
				$articlesCount = DB::table('user_copy')
				->join('articles', 'articles.id', '=', 'user_copy.article')
				->select('user_copy.*', 'articles.*')->where('user_copy.guest', $userID)->count();
				$return['count'] = $articlesCount;
				
				

			} else {
				if($guest){
					// Гость
					$getUser = User::getGuest($guest);
					$userID = $getUser['id'];

					$articles = DB::table('user_copy')
					->join('articles', 'articles.id', '=', 'user_copy.article')
					->select('user_copy.*', 'articles.*')
					->where('user_copy.guest', $userID)
					->offset($offset)
					->limit(15)
					->get();
					
					$articlesCount = DB::table('user_copy')
					->join('articles', 'articles.id', '=', 'user_copy.article')
					->select('user_copy.*', 'articles.*')->where('user_copy.guest', $userID)->count();
					$return['count'] = $articlesCount;
				} else {
					// Зарегистрированный
					$getUser = User::getUser($request);
					$userID = $getUser['id'];

					$articles = DB::table('user_copy')
					->join('articles', 'articles.id', '=', 'user_copy.article')
					->select('user_copy.*', 'articles.*')
					->where('user_copy.user', $userID)
					->offset($offset)
					->limit(15)
					->get();
					
					$articlesCount = DB::table('user_copy')
					->join('articles', 'articles.id', '=', 'user_copy.article')
					->select('user_copy.*', 'articles.*')->where('user_copy.user', $userID)->count();
					$return['count'] = $articlesCount;
				}
				
			}
		};
		foreach($articles  as $ind_artriicle => $article){
			
			$return['data'][$ind_artriicle] = $article;
			$id = $article->id;
            $return['articles'][$ind_artriicle] = Article::getArticle($id);

			$date = date_create($article->data);
			$date = date_format($date, 'M, d');
			$return['articles'][$ind_artriicle]['data'] = $date;

		}

		/*
		if($articleIDs){
			$articles = DB::table('articles')->offset($offset)->whereIn('id', $articleIDs)->limit(15)->get();
			$articlesCount = DB::table('articles')->whereIn('id', $articleIDs)->count();
		} else {
			$articles = DB::table('articles')->offset($offset)->limit(0)->get();
			$articlesCount = DB::table('articles')->count();
		}
		$return['count'] = $articlesCount;
		foreach($articles  as $ind_artriicle => $article){
			$id = $article->id;
			$return['articles'][$ind_artriicle]['id'] = (int)$article->id;
			$return['articles'][$ind_artriicle]['title'] = (string)$article->title;
			$return['articles'][$ind_artriicle]['context'] = $article->context;
			$return['articles'][$ind_artriicle]['status'] = (int)$article->status;
			
			$authors = DB::table('article_authors')->where('article', $id)->get();
			foreach($authors  as $i_author => $data){
				$return['articles'][$ind_artriicle]['authors'][$i_author] = $this->getAuthor($data->author);
			}
			$tags = DB::table('article_tags')->where('article', $id)->get();
			foreach($tags  as $i_tags => $data){
				$return['articles'][$ind_artriicle]['tags'][$i_tags] = Tags::getTag($data->tag)->name;
			}

		}
		*/

		$return['t'] = (microtime(true) - $start);
		$i = 0;
		while (floor($memory / 1024) > 0) {
		  $i++;
		  $memory /= 1024;
		}
		$name = array('байт', 'КБ', 'МБ');
		$return['m'] = round($memory, 2) . ' ' . $name[$i];

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
	public function loadtags(Request $request){
		$return = [];
		$industryIDs = array();
		$tagsIDs = array();
		
		$industry = $request->input('industry');
		if($industry != ''){
			if(count($industry) >= 1){
				foreach($industry  as $i => $data){
					array_push($industryIDs, (int)$data);
				}
				if($industryIDs){
					$industry_tags = DB::table('industry_tag')->whereIn('industry', $industryIDs)->limit(60)->get();
					foreach($industry_tags  as $it => $data){
						if (array_key_exists((int)$data->tag, $tagsIDs)) {
						} else {
							array_push($tagsIDs, (int)$data->tag);
						}
					}

					$tags = DB::table('tags')->whereIn('id', $tagsIDs)->limit(20)->get();
					foreach($tags  as $itg => $data){
						$return['tags'][$itg]['id'] = (int)$data->id;
						$return['tags'][$itg]['name'] = $data->name;
					}
				}
			} else {
				$industry_tags = DB::table('industry_tag')->limit(60)->get();
				foreach($industry_tags  as $it => $data){
					if (array_key_exists((int)$data->tag, $tagsIDs)) {
					} else {
						array_push($tagsIDs, (int)$data->tag);
					}
				}
				$tags = DB::table('tags')->whereIn('id', $tagsIDs)->limit(20)->get();
				foreach($tags  as $itg => $data){
					$return['tags'][$itg]['id'] = (int)$data->id;
					$return['tags'][$itg]['name'] = $data->name;
				}
				
			}
		} else {
			$industry_tags = DB::table('industry_tag')->limit(60)->get();
			foreach($industry_tags  as $it => $data){
				if (array_key_exists((int)$data->tag, $tagsIDs)) {
				} else {
					array_push($tagsIDs, (int)$data->tag);
				}
			}
			$tags = DB::table('tags')->whereIn('id', $tagsIDs)->limit(20)->get();
			foreach($tags  as $itg => $data){
				$return['tags'][$itg]['id'] = (int)$data->id;
				$return['tags'][$itg]['name'] = $data->name;
			}
			
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
}