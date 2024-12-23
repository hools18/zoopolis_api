<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use Intervention\Image\ImageManager;

use joshtronic\LoremIpsum;


use Illuminate\Database\Seeder;


use Faker\Factory as Faker;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Internet;



class TestController extends Controller{
	
	public function __construct(){
        //
    }
	protected $faker;
	function checkWithProbability($probability=0.1, $length=10000){
		$test = mt_rand(1, $length);
		return $test<=$probability*$length;
	}
	public function gen(Request $request){

		$return = [];
		$lipsum  = new LoremIpsum();
		
		/*
		$return[] = '1 word: '  . $lipsum->word(); // 1 слово
		$return[] = '5 words: ' . $lipsum->words(5); // 5 слов
		
		$return[] = '1 sentence: '  . $lipsum->sentence(); // 1 предложение
		$return[] = '5 sentences: ' . $lipsum->sentences(5); // 5 предложение
		$return[] = '1 paragraph: '  . $lipsum->paragraph(); // 1 параграф
		*/
		/*
		// Генерируем теги

		$tagscount = 0;
		for ($i = 1; $i <= 10000; $i++) {
			$checkWithProbability = $this->checkWithProbability(1/3);
			if($checkWithProbability == true){
				$name = $lipsum->word(5).' '.$lipsum->word(7);
			} else {
				$name = $lipsum->word(6);
			}
			$check = DB::table('tags')->where('name', $name)->count();
			if($check == 1){
				
			} else {
				$tag = DB::table('tags')->insertGetId([
					'name' => $name
				]);
			}
			
			$tagscount++;
		}
		
		
		$return['tagscount'] = $tagscount;
		*/
		
		// Генерируем Индустрии	
		/*
		$industrycount = 0;
		for ($i = 1; $i <= 1000; $i++) {
			$checkWithProbability = $this->checkWithProbability(1/3);
			if($checkWithProbability == true){
				$name = $lipsum->word(5).' '.$lipsum->word(7);
			} else {
				$name = $lipsum->word(6);
			}
			$check = DB::table('industry')->where('name', $name)->count();
			if($check == 1){
				
			} else {
				$industry = DB::table('industry')->insertGetId([
					'name' => $name
				]);
			}			
			
			$industrycount++;
		}
		$return['industrycount'] = $industrycount;	
		*/
		/*
		// Привяжем рандомно к индустрии по 80 тегов.
		$tagtoind = 0;
		$industryList = DB::table('industry')->where('id', '>', 1088)->get();
		foreach($industryList as $industry){
			
			$tagslist = DB::table('tags')->inRandomOrder()->take(200)->get();
			foreach($tagslist  as $tag){
				$industryTag = DB::table('industry_tag')->insertGetId([
					'industry' => $industry->id,
					'tag' => $tag->id
				]);
				$tagtoind++;
			}
		}
		$return['tagtoind'] = $tagtoind;
		*/
		
		/*
		// Генерируем авторов
		$newauthors = 0;
		$faker = Faker::create();
		for ($i = 1; $i <= 500; $i++) {
			$freeEmail = null;
			$domainName = null;
			$userName = null;
			if(random_int(1, 3) == 1){
				$freeEmail = $faker->freeEmail;
			}
			if(random_int(1, 3) == 2){
				$domainName = $faker->domainName;
			}
			if(random_int(1, 3) == 3){
				$userName = $faker->userName;
			}

			$industry = DB::table('authors')->insertGetId([
				'name' => $faker->name,
				'type' => random_int(1, 3),
				'biography' => $lipsum->paragraphs(random_int(1, 5), 'p'),
				'email' => $faker->freeEmail,
				'site' => $faker->domainName, 
				'linkedin' => $faker->userName
			]);

			$newauthors++;
		}
		$return['newauthors'] = $newauthors;
		*/
		// Генерируем текста
		$newtext = 0;
		for ($i = 1; $i <= 500; $i++) {
			$articleID = DB::table('articles')->insertGetId([
				'title' => $lipsum->words(random_int(3, 7)),
				'context' => $lipsum->sentences(random_int(1, 5)),
				'status' => 1
			]);
			for ($i_a = 1; $i_a <= random_int(1, 3); $i_a++) {
				$author = DB::table('authors')->inRandomOrder()->first();
				$industryTag = DB::table('article_authors')->insertGetId([
					'article' => $articleID,
					'author' => $author->id
				]);
			}
			for ($i_g = 1; $i_g <= random_int(1, 3); $i_g++) {
				$goal = DB::table('goal')->inRandomOrder()->first();
				$industryTag = DB::table('article_goal')->insertGetId([
					'article' => $articleID,
					'goal' => $goal->id
				]);
			}
			for ($i_g = 1; $i_g <= random_int(1, 5); $i_g++) {
				$industry = DB::table('industry')->inRandomOrder()->first();
				$industryTag = DB::table('article_industry')->insertGetId([
					'article' => $articleID,
					'industry' => $industry->id
				]);
			}
			for ($i_cm = 1; $i_cm <= random_int(1, 3); $i_cm++) {
				$socialmedia = DB::table('socialmedia')->inRandomOrder()->first();
				$industryTag = DB::table('article_socialmedia')->insertGetId([
					'article' => $articleID,
					'socialmedia' => $socialmedia->id
				]);
			}
			
			for ($i_tg = 1; $i_tg <= random_int(1, 8); $i_tg++) {
				$tag = DB::table('tags')->inRandomOrder()->first();
				$industryTag = DB::table('article_tags')->insertGetId([
					'article' => $articleID,
					'tag' => $tag->id
				]);
			}
			for ($i_tv = 1; $i_tv <= random_int(1, 2); $i_tv++) {
				$tonesvoice = DB::table('tonesvoice')->inRandomOrder()->first();
				$industryTag = DB::table('article_tonesvoice')->insertGetId([
					'article' => $articleID,
					'tonesvoice' => $tonesvoice->id
				]);
			}
			$newtext++;
			
		}
		$return['newtext'] = $newtext;
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
		
	}
}