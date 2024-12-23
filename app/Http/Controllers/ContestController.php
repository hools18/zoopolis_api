<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;
use Intervention\Image\ImageManagerStatic as Image;

class ContestController extends Controller{
	
	public function __construct(){
        //
    }

	function getContest($id){
		$return = [];
		$contest = DB::table('contest')->where('id', $id)->first();
		
		$return['id'] = $contest->id;		
		$return['name'] = $contest->name;
		
		$return['dayContestStart'] = $contest->dayContestStart;
		$return['dayContestStop'] = $contest->dayContestStop;
		$return['dayContestInviteStart'] = $contest->dayContestInviteStart;
		$return['dayContestInviteStop'] = $contest->dayContestInviteStop;
		
		//$return['dayContestInviteStop'] = date('d.m.Y', strtotime($contest->dayContestInviteStop));
		
		$contestDesc = DB::table('contest_desc')->where('contest', $id)->first();
		
		$return['predesc'] = $contestDesc->predesc;
		$return['desc'] = $contestDesc->desc;
		
		$contestLogo = DB::table('contest_logo')->where('contest', $contest->id)->where('status', 1)->first();
		if($contestLogo){
			$filetype = 'jpg';
			if (isset($contestLogo->type)) {
				switch ($contestLogo->type) {
					case 1:
						$filetype = 'jpg';
					break;
					case 2:
						$filetype = 'png';
					break;
				}
			}
			$return['logo'] = sprintf('%02x', $contestLogo->a).'/'.sprintf('%02x', $contestLogo->b).'/'.sprintf('%08x', $contestLogo->name).'.'.$filetype;
		} else {
			$return['logo'] = 'nologo.png';
		}
		
		$BDGallery = DB::table('contest_gallery')->where('contest', $contest->id)->where('status', 1)->get();
		foreach($BDGallery  as $i => $image){
			$return['gallery'][$i] = sprintf('%02x', $image->a).'/'.sprintf('%02x', $image->b).'/'.sprintf('%08x', $image->name).'.'.$filetype;
			
		}
		return $return;
    }
	
	public function getContestsList(Request $request){
		$return = [];
		
		$contests = DB::table('contest')->get();
		foreach($contests  as $i => $contest){

			$return[$i]['id'] = $contest->id;
			$return[$i]['name'] = $contest->name;
			$return[$i]['dayContestStart'] = $contest->dayContestStart;
			$return[$i]['dayContestStop'] = $contest->dayContestStop;
			$return[$i]['dayContestInviteStart'] = $contest->dayContestInviteStart;
			$return[$i]['dayContestInviteStop'] = $contest->dayContestInviteStop;
			$contestDesc = DB::table('contest_desc')->where('contest', $contest->id)->first();
			
			$return[$i]['predesc'] = $contestDesc->predesc;
			
			$contestLogo = DB::table('contest_logo')->where('contest', $contest->id)->where('status', 1)->first();
			if($contestLogo){

				$filetype = 'jpg';
				if (isset($contestLogo->type)) {
					switch ($contestLogo->type) {
						case 1:
							$filetype = 'jpg';
						break;
						case 2:
							$filetype = 'png';
						break;
					}
				}
				$return[$i]['logo'] = dechex($contestLogo->a).'/'.dechex($contestLogo->b).'/'.dechex($contestLogo->name).'.'.$filetype;

				
			} else {
				$return[$i]['logo'] = 'nologo.png';
			}
			
		}
		
		
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	

	public function getContestData(Request $request){
		$return = [];
		$contestID = intval($request->input('id'));
		//$getUserID = User::getUser($request);
		$contest = $this->getContest($contestID);
		$return = $contest;
		
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
	
	public function fastCreateContest(Request $request){
		$return = [];
		$getUserID = User::getUser($request);
		$name = $request->input('name');
		
		$createContest = DB::table('contest')->insertGetId([
			'name' => $name
		]);
		$contestid = intval($createContest);		
		$contestRole = DB::table('contest_user_role')->insertGetId([
			'contest' => $contestid,
			'user' => $getUserID['id'],
			'role' => 1			
		]);
		$contestDesc = DB::table('contest_desc')->insertGetId([
			'contest' => $contestid	
		]);
		$return['contestid'] = intval($createContest);
		
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }
	
	public function managementContest(Request $request){
		// ROLE: 1 - full admin, 2 manager
		$return = [];
		$getUserID = User::getUser($request);		
		$contestIdManager = DB::table('contest_user_role')->where('user', $getUserID['id'])->where('role', '>=', 1)->get();
		foreach($contestIdManager as $i => $contestID){
			$return[$i] = [];
			$return[$i]['id'] = intval($contestID->contest);
			$return[$i]['user'] = [];
			$return[$i]['user']['role'] = intval($contestID->role);
			
			
			$contest = $this->getContest($contestID->contest);
			
			
			$return[$i]['name'] = $contest['name'];
			$return[$i]['dayStart'] = $contest['dayContestStart'];
			$return[$i]['dayStop'] = $contest['dayContestStop'];

			$return[$i]['dayInviteStart'] = $contest['dayContestInviteStart'];
			$return[$i]['dayInviteStop'] = $contest['dayContestInviteStop'];
			
			$contestDesc = DB::table('contest_desc')->where('contest', $contestID->contest)->first();
			
			$return[$i]['predesc'] = $contestDesc->predesc;
			
			$contestLogo = DB::table('contest_logo')->where('contest', $contestID->contest)->where('status', 1)->first();
			if($contestLogo){

				$filetype = 'jpg';
				if (isset($contestLogo->type)) {
					switch ($contestLogo->type) {
						case 1:
							$filetype = 'jpg';
						break;
						case 2:
							$filetype = 'png';
						break;
					}
				}
				$return[$i]['logo'] = sprintf('%02x', $contestLogo->a).'/'.sprintf('%02x', $contestLogo->b).'/'.sprintf('%08x', $contestLogo->name).'.'.$filetype;
			} else {
				$return[$i]['logo'] = 'nologo.png';
			}

		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
	public function getEditContestData(Request $request){
		$contestID = intval($request->input('id'));
		$return = [];
		$getUserID = User::getUser($request);		

		$check = DB::table('contest_user_role')->where('contest',  $contestID)->where('user', $getUserID['id'])->where('role', 1)->first();
		if($check){
			$contest = $this->getContest($contestID);
			$return = $contest;
		} else {
			// Нет прав редактирования
			$return['err'] = 'Нет прав доступа';
		}

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function saveContestData(Request $request){
		$return = [];
		$contestID = intval($request->input('id'));
		$contestName = $request->input('name');
		$contestDays = $request->input('daycontest');
		$contestDaysInvite = $request->input('daycontestinvite');
		$getUserID = User::getUser($request);
		
		$logoImg = $request->file('logo');
		
		$predesc = $request->input('predesc');
		$desc = $request->input('desc');
		
		if($contestName != ''){
			$BDName = DB::table('contest')->where('id', $contestID)->update([
				'name' => $contestName
			]);
			$return['name'] = true;
		};
		if($contestDays != ''){
			$contestDays = explode(" - ", $contestDays);
			$contestDays[0] = date('Y-m-d', strtotime($contestDays[0]));
			if(isset($contestDays[1])){
				$contestDays[1] = date('Y-m-d', strtotime($contestDays[1]));
			} else {
				$contestDays[1] = NULL;
			}
			$BDDays = DB::table('contest')->where('id', $contestID)->update([
				'dayContestStart' => $contestDays[0],
				'dayContestStop' => $contestDays[1]
			]);
			$return['contestDays'] = true;
		};
		if($contestDaysInvite != ''){
			$contestDaysInvite = explode(" - ", $contestDaysInvite);
			$contestDaysInvite[0] = date('Y-m-d', strtotime($contestDaysInvite[0]));
			if(isset($contestDaysInvite[1])){
				$contestDaysInvite[1] = date('Y-m-d', strtotime($contestDaysInvite[1]));
			} else {
				$contestDaysInvite[1] = NULL;
			}
			$BDDays = DB::table('contest')->where('id', $contestID)->update([
				'dayContestInviteStart' => $contestDaysInvite[0],
				'dayContestInviteStop' => $contestDaysInvite[1]
			]);
			$return['contestDaysInvite'] = true;
		};
		
		if($predesc != ''){
			$BDName = DB::table('contest_desc')->where('contest', $contestID)->update([
				'predesc' => $predesc
			]);
			$return['predesc'] = true;
		};
		if($desc != ''){
			$BDName = DB::table('contest_desc')->where('contest', $contestID)->update([
				'desc' => $desc
			]);
			$return['desc'] = true;
		};
		
		if($request->file('logo')){
			if ($request->file('logo')->isValid()) {

				$folderA = bin2hex(random_bytes(1));
				$folderB = bin2hex(random_bytes(1));
				
				$fileName = bin2hex(random_bytes(4));
				$dirName = array('orig', '500', '200');
				
				$dir = '../../dc/public_html/images/logos/';
				if (!file_exists($dir)) { 
					mkdir($dir, 0777, true);
				};
				foreach($dirName  as $i => $nd){
					$dir = '../../dc/public_html/images/logos/'.$nd.'/';
					if (!file_exists($dir)) { 
						mkdir($dir, 0777, true);
					};
					$dir = '../../dc/public_html/images/logos/'.$nd.'/'.$folderA;
					if (!file_exists($dir)) { 
						mkdir($dir, 0777, true);
					};	
					$dir = '../../dc/public_html/images/logos/'.$nd.'/'.$folderA.'/'.$folderB;
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
					}
				}
				$BDName = DB::table('contest_logo')->where('contest', $contestID)->where('status', 1)->update([
					'status' => 2
				]);
				$DBLOGO = DB::table('contest_logo')->insertGetId([
					'contest' => $contestID,
					'user' => $getUserID['id'],
					'a' => hexdec($folderA),
					'b' => hexdec($folderB),
					'name' => hexdec($fileName),
					'type' => $filetype
				]);				
				$request->file('logo')->move('../../dc/public_html/images/logos/orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);
				
				$img = Image::make('../../dc/public_html/images/logos/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
				$img->resize(500, 500);
				$img->save('../../dc/public_html/images/logos/500/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension, 93, $guessExtension);
				$img = Image::make('../../dc/public_html/images/logos/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
				$img->resize(200, 200);
				$img->save('../../dc/public_html/images/logos/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension, 93, $guessExtension);
				$return['img'] = true;
			};
		};

		
		if($request->file('gallery')){
			
			$dirName = array('orig', '1600', '600', '200');
				
			$dir = '../../dc/public_html/images/gallery/';
			if (!file_exists($dir)) { 
				mkdir($dir, 0777, true);
			};
			
			
			foreach($request->file('gallery') as $key => $file){
				$folderA = bin2hex(random_bytes(1));
				$folderB = bin2hex(random_bytes(1));				
				$fileName = bin2hex(random_bytes(4));
				foreach($dirName  as $i => $nd){
					$dir = '../../dc/public_html/images/gallery/'.$nd.'/';
					if (!file_exists($dir)) { 
						mkdir($dir, 0777, true);
					};
					$dir = '../../dc/public_html/images/gallery/'.$nd.'/'.$folderA;
					if (!file_exists($dir)) { 
						mkdir($dir, 0777, true);
					};	
					$dir = '../../dc/public_html/images/gallery/'.$nd.'/'.$folderA.'/'.$folderB;
					if (!file_exists($dir)) { 
						mkdir($dir, 0777, true);
					};
						
				}

				$image = $file;
				$picName = $file->getClientOriginalName();
				$guessExtension = $file->guessExtension();
				$filetype = 1;
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
				$DBLOGO = DB::table('contest_gallery')->insertGetId([
					'contest' => $contestID,
					'user' => $getUserID['id'],
					'a' => hexdec($folderA),
					'b' => hexdec($folderB),
					'name' => hexdec($fileName),
					'type' => $filetype
				]);
				$file->move('../../dc/public_html/images/gallery/orig/'.$folderA.'/'.$folderB, $fileName.'.'.$guessExtension);
				
				$img = Image::make('../../dc/public_html/images/gallery/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
				
				$img->resize(1600, null, function ($constraint) {
					$constraint->aspectRatio();
				});
				
				$img->save('../../dc/public_html/images/gallery/1600/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension, 93, $guessExtension);
				
				
				$img = Image::make('../../dc/public_html/images/gallery/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
				$img->resize(600, null, function ($constraint) {
					$constraint->aspectRatio();
				});
				$img->save('../../dc/public_html/images/gallery/600/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension, 93, $guessExtension);
				
				$img = Image::make('../../dc/public_html/images/gallery/orig/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension);
				$img->resize(200, null, function ($constraint) {
					$constraint->aspectRatio();
				});
				$img->save('../../dc/public_html/images/gallery/200/'.$folderA.'/'.$folderB.'/'.$fileName.'.'.$guessExtension, 93, $guessExtension);

			}
			$return['gallery'] = true;
			
		}


		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
}