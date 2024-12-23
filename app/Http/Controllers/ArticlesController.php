<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\TagsController as Tags;
use App\Http\Controllers\IndustryController as Industry;
use App\Http\Controllers\GoalController as Goal;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\AuthorsController as Authors;

class ArticlesController extends Controller{
	
	public function __construct(){
        //
    }
	public static function EZ($context){
		$text = preg_replace_callback('/\[\[EZ:(?<t>.*?)(?:\|(?<i>.*?))?]]/',
			static function (array $matches): string {
				$return['t'] = $matches['t'];
				$return['i'] = $matches['t'];
				$text = $matches['t'];
				$icon = $matches['i'] ?? 'send';
				return '<editzone data-icon="'.$icon.'"><div class="fr" data-original="'.$text.'"></div></editzone>';
			},
			$context
		);
		return $text;
	}
	public static function EZClean($context){
		$text = preg_replace_callback('/\[\[EZ:(?<t>.*?)(?:\|(?<i>.*?))?]]/',
			static function (array $matches): string {
				$return['t'] = $matches['t'];
				$return['i'] = $matches['t'];
				$text = $matches['t'];
				$icon = $matches['i'] ?? 'send';
				return $text;
			},
			$context
		);
		return $text;
	}
	public static function getAuthor($id){ 
		$return = [];
		$author = DB::table('authors')->where('id', $id)->first();
		$return['id'] = $author->id;
		$return['name'] = $author->name;
		$return['showlist'] = $author->showlist;
		$photo = DB::table('author_photo')->where('author', $id)->where('status', 1)->first();
        if($author->type){
            $type = DB::table('authorsType')->where('id', $author->type)->first();
            $return['type'] = $type->name;
        } else {
            $return['type'] = '';
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
	
	public function testList(Request $request){
		$getUser = User::getUser($request);
		$return = [];
		$articles = DB::table('articles')->get();
		foreach($articles  as $ind_artriicle => $article){
			$id = $article->id;
			$return[$ind_artriicle]['id'] = (int)$article->id;
			$return[$ind_artriicle]['title'] = (string)$article->title;
			$return[$ind_artriicle]['context'] = $article->context;
			$return[$ind_artriicle]['status'] = (int)$article->status;
			
			$authors = DB::table('article_authors')->where('article', $id)->get();
			foreach($authors  as $ind_author => $data){
				$return[$ind_artriicle]['authors'][$ind_author] = ArticlesController::getAuthor($data->author);
			}
				
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
	public function saveCopy(Request $request){
		$return = [];
		$getUser = User::getUser($request);
		
		$id = intval($request->input('id'));

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public static function getArticle($id){
		$article = [];
		if(Cache::get('article_'.$id)){
			$article = Cache::get('article_'.$id);
			$article['cached'] = true;
		} else {
			$articleDB = DB::table('articles')->where('id', $id)->first();
			$article['id'] = (int)$articleDB->id;
			$article['title'] = (string)$articleDB->title;
			$article['status'] = (int)$articleDB->status;
			$article['context'] = ArticlesController::EZ($articleDB->context);
			
			$authors = DB::table('article_authors')->where('article', $id)->get();
			foreach($authors  as $i_author => $data){
				$article['authors'][$i_author] = Authors::getAuthorID($data->author);
			}
			$tags = DB::table('article_tags')->where('article', $id)->get();
			foreach($tags as $i_tags => $data){
				$article['tags'][$i_tags] = Tags::getTag($data->tag)->name;
			}
			
			$industry = DB::table('article_industry')->where('article', $id)->get();
			foreach($industry as $i_industry => $data){
				$article['industry'][$i_industry] = Industry::getIndustry($data->industry)->name;
			}
			$goal = DB::table('article_goal')->where('article', $id)->get();
			foreach($goal as $i_goal => $data){
				$article['goal'][$i_goal] = Goal::getGoal($data->goal)->name;
			}
			$article['cached'] = false;
			Cache::put('article_'.$id, $article, env('CACHE_TIME_ARTICLE'));
		}
		
		return $article;
	}

}