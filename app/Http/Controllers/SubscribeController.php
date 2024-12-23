<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Controllers\UserController as User;

use App\Http\Controllers\MailController as Email;
use App\Http\Controllers\BepaidController as Bepaid;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller{
	
	public function __construct(){
        //
    }
	public function getPrice(Request $request){
		$return = [];
		$period = $request->input('period')[0];
		$return['period'] = intval($period);
		$type = intval($request->input('type'));
		
		$configZooID = [];
		array_push($configZooID, 1);
		$userZooIDConfigs = $request->input('configZooID')['zooid'];
		foreach($userZooIDConfigs  as $i => $data){
			if(intval($data) > 1){
				array_push($configZooID, intval($data));
			}
		}
		
		$configConcierge = [];		
		array_push($configConcierge, 1);
		$userConciergeConfigs = $request->input('configConcierge')['concierge'];
		foreach($userConciergeConfigs  as $i => $data){
			if(intval($data) > 1){
				array_push($configConcierge, intval($data));
			}
		}
		
		$zooid = DB::table('zooid')->whereIn('id', $configZooID)->where('delete', 0)->get();
		$ZooIDPrice = [];
		$ZooIDPrice['BYN'] = 0;
		$ZooIDPrice['RUB'] = 0;
		if($zooid){
			foreach($zooid as $i => $data){
				$ZooIDPrice['BYN'] += $data->BYN;
				$ZooIDPrice['RUB'] += $data->RUB;
			}
		}

		$concierge = DB::table('concierge')->whereIn('id', $configConcierge)->where('delete', 0)->get();
		$ConciergePrice = [];
		$ConciergePrice['BYN'] = 0;
		$ConciergePrice['RUB'] = 0;
		if($concierge){
			foreach($concierge as $i => $data){
				$ConciergePrice['BYN'] += $data->BYN;
				$ConciergePrice['RUB'] += $data->RUB;
			}
		}
		
		$zoopolis = DB::table('zoopolis')->where('delete', 0)->get();
		$zoopolisPrice = [];
		$zoopolisPrice['BYN'] = 0;
		$zoopolisPrice['RUB'] = 0;
		if($zoopolis){
			foreach($zoopolis as $i => $data){
				$zoopolisPrice['BYN'] += $data->BYN;
				$zoopolisPrice['RUB'] += $data->RUB;
			}
		}
		
		
		if($type == 1){

			$return['pricebase'] = $ZooIDPrice['BYN'] * $period;
			$return['currency'] = 'BYN';
			
			$return['BYN'] = $ZooIDPrice['BYN'] * $period;
			$return['RUB'] = $ZooIDPrice['RUB'] * $period;
		}
		if($type == 2){
			$return['pricebase'] = $ConciergePrice['BYN'] * $period;
			$return['currency'] = 'BYN';
			
			$return['BYN'] = $ConciergePrice['BYN'] * $period;
			$return['RUB'] = $ConciergePrice['RUB'] * $period;
		}
		
		if($type == 3){
			$return['currency'] = 'BYN';
			$return['BYN'] = ($zoopolisPrice['BYN'] * $period);
			$return['RUB'] = ($zoopolisPrice['RUB'] * $period);
			
			$return['pricebase'] = ($zoopolisPrice['BYN'] * $period);
		}
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function bay(Request $request){

		
		$return = [];
        $getUser = User::getUser($request);
		$return['u'] = $getUser;
		$userID = $getUser['id'];
		$sid = intval($request->input('id'));
		$period = $request->input('period');

		$time = intval($request->input('period')['period'][0]);
		if(isset($userID)){

			if(intval($period['type']) == 1){
				
				$check = DB::table('sub_zooid_user')->where('user', $userID)->where('status', 3)->where('end', '>=', DB::raw('now()'))->first();
				if($check){
					$return['err'] = "У вас уже имеется подписка.";
				} else {

					$subscriptionData = DB::table('sub_zooid')->where('id', 1)->first();
					if($subscriptionData){
						$sid = $subscriptionData->id;
						$month = $time;
						$amount = $subscriptionData->pricebase;
						
						$configZooID = [];
						array_push($configZooID, 1);
						$userZooIDConfigs = $request->input('configZooID')['zooid'];
						foreach($userZooIDConfigs  as $i => $data){
							if(intval($data) > 1){
								array_push($configZooID, intval($data));
							}
						}
						$zooid = DB::table('zooid')->whereIn('id', $configZooID)->where('delete', 0)->get();
						$ZooIDPrice = [];
						$ZooIDPrice['BYN'] = 0;
						$ZooIDPrice['RUB'] = 0;
						if($zooid){
							foreach($zooid as $i => $data){
								$ZooIDPrice['BYN'] += $data->BYN;
								$ZooIDPrice['RUB'] += $data->RUB;
							}
						}
						$ZooIDPrice['BYN'] = ($ZooIDPrice['BYN'] * $time) * 100;
						$ZooIDPrice['RUB'] = ($ZooIDPrice['RUB'] * $time) * 100;
						
						$zooid = DB::table('sub_zooid_user')->insertGetId([
							'user' => $userID,
							'sub_zooid' => 1,
							'config' => json_encode($configZooID),
							'BYN' => $ZooIDPrice['BYN'],
							'RUB' => $ZooIDPrice['RUB'],
							'period' => $time,							
							'status' => 1,
							'create' => DB::raw('NOW()'),
							'start' => DB::raw('NOW()'),
							'end' => DB::raw('DATE_ADD(NOW(), INTERVAL '.$time.' MONTH)')
						]);
						
						$return['BD'] = $zooid;
						
						// 1 - zooid, 2 - concierge	
						$Bepaid = Bepaid::genPay([
							'user' => $userID,
							'type' => 1,
							'zooid' => $zooid,
							'currency' => 'byn',
							'setDescription' => 'Test setDescription',
							'description' => 'Test description',
							'sum' => $ZooIDPrice['BYN']
						]);

						$return['bepaid'] = $Bepaid;
						$return['sum'] = $ZooIDPrice['BYN'];
						$return['currency'] = 'BYN';
						$return['sub'] = 0;
					} else {
						$return['err'] = "Подписка такого типа не найдена.";
						
					}

				}
				
			};
			if(intval($period['type']) == 2){
				
				$check = DB::table('sub_concierge_user')->where('user', $userID)->where('status', 3)->where('end', '>=', DB::raw('now()'))->first();
				if($check){
					$return['err'] = "У вас уже имеется подписка на Консьерж.";
				} else {

					$subscriptionData = DB::table('sub_concierge')->where('month', $period['period'][0])->where('status', 1)->first();
					if($subscriptionData){
						$sid = $subscriptionData->id;
						$month = $time;
						$amount = $subscriptionData->pricebase;
						
						
						
						$configConcierge = [];		
						array_push($configConcierge, 1);
						$userConciergeConfigs = $request->input('configConcierge')['concierge'];
						foreach($userConciergeConfigs  as $i => $data){
							if(intval($data) > 1){
								array_push($configConcierge, intval($data));
							}
						}

						$concierge = DB::table('concierge')->whereIn('id', $configConcierge)->where('delete', 0)->get();
						$conciergePrice = [];
						$conciergePrice['BYN'] = 0;
						$conciergePrice['RUB'] = 0;
						if($concierge){
							foreach($concierge as $i => $data){
								$conciergePrice['BYN'] += $data->BYN;
								$conciergePrice['RUB'] += $data->RUB;
							}
						}
						$conciergePrice['BYN'] = ($conciergePrice['BYN'] * $time) * 100;
						$conciergePrice['RUB'] = ($conciergePrice['RUB'] * $time) * 100;
						
						$BD = DB::table('sub_concierge_user')->insertGetId([
							'user' => $userID,
							'sub_concierge' => 1,
							'config' => json_encode($configConcierge),
							'BYN' => $conciergePrice['BYN'],
							'RUB' => $conciergePrice['RUB'],
							'period' => $time,
							'create' => DB::raw('NOW()'),
							'start' => DB::raw('NOW()'),
							'end' => DB::raw('DATE_ADD(NOW(), INTERVAL '.$time.' MONTH)')
						]);
						
						$return['BD'] = $BD;

						// 1 - zooid, 2 - concierge	
						$Bepaid = Bepaid::genPay([
							'user' => $userID,
							'type' => 2,
							'concierge' => $BD,
							'currency' => 'byn',
							'sum' => $conciergePrice['BYN']
						]);

						$return['bepaid'] = $Bepaid;
						$return['sum'] = $conciergePrice['BYN'];
						$return['currency'] = 'BYN';
						$return['sub'] = 0;
					} else {
						$return['err'] = "Подписка такого типа не найдена.";
						
					}

				}
				
			};
			if(intval($period['type']) == 3){
				
				$check = DB::table('sub_zoopolis_user')->where('user', $userID)->where('status', 3)->where('end', '>=', DB::raw('now()'))->first();
				if($check){
					$return['err'] = "У вас уже имеется подписка на Зоополис.";
				} else {

					$subscriptionData = DB::table('sub_zoopolis')->where('month', $period['period'][0])->where('status', 1)->first();
					if($subscriptionData){
						$sid = $subscriptionData->id;
						$month = $time;

						$configZoopolis = [];		
						array_push($configZoopolis, 1);


						$zoopolis = DB::table('zoopolis')->whereIn('id', $configZoopolis)->where('delete', 0)->get();
						$zoopolisPrice = [];
						$zoopolisPrice['BYN'] = 0;
						$zoopolisPrice['RUB'] = 0;
						if($zoopolis){
							foreach($zoopolis as $i => $data){
								$zoopolisPrice['BYN'] += $data->BYN;
								$zoopolisPrice['RUB'] += $data->RUB;
							}
						}
						$zoopolisPrice['BYN'] = ($zoopolisPrice['BYN'] * $time) * 100;
						$zoopolisPrice['RUB'] = ($zoopolisPrice['RUB'] * $time) * 100;
						
						$BD = DB::table('sub_zoopolis_user')->insertGetId([
							'user' => $userID,
							'sub_zoopolis' => 1,
							'config' => json_encode($configZoopolis),
							'BYN' => $zoopolisPrice['BYN'],
							'RUB' => $zoopolisPrice['RUB'],
							'period' => $time,
							'create' => DB::raw('NOW()'),
							'start' => DB::raw('NOW()'),
							'end' => DB::raw('DATE_ADD(NOW(), INTERVAL '.$time.' MONTH)')
						]);
						
						$return['BD'] = $BD;

						// 1 - zooid, 2 - concierge, 2 - Zoopolis	
						$Bepaid = Bepaid::genPay([
							'user' => $userID,
							'type' => 3,
							'concierge' => $BD,
							'currency' => 'byn',
							'sum' => $zoopolisPrice['BYN']
						]);

						$return['bepaid'] = $Bepaid;
						$return['sum'] = $zoopolisPrice['BYN'];
						$return['currency'] = 'BYN';
						$return['sub'] = 0;
					} else {
						$return['err'] = "Подписка такого типа не найдена.";
						
					}

				}	
				
			};
		} else {
			$return['err'] = "Необходима автворизация";
			
		}

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	
	public function status(Request $request){
		$return = [];
        $getUser = User::getUser($request);
		$return['u'] = $getUser;
		$userID = $getUser['id'];
		$type = $request->input('type');
		if(isset($userID)){
			$zooid = DB::table('sub_zooid_user')->where('user', $userID)->where('status', 3)->where('end', '>=', DB::raw('now()'))->first();
			if($zooid){
					// id	user	sub_zooid	pendant	manager	remuneration	delivery	status	create	start	end
					$subscriptionData = DB::table('sub_zooid')->where('id', $zooid->sub_zooid)->first();
					$return['zooid']['sub_zooid'] = $zooid->sub_zooid;
					$return['zooid']['pendant'] = $zooid->pendant;
					$return['zooid']['manager'] = $zooid->manager;
					$return['zooid']['remuneration'] = $zooid->remuneration;
					$return['zooid']['delivery'] = $zooid->delivery;
					$return['zooid']['status'] = $zooid->status;
					$return['zooid']['create'] = $zooid->create;
					$return['zooid']['start'] = $zooid->start;
					$return['zooid']['end'] = $zooid->end;
					$return['zooid']['name'] = $subscriptionData->name;
					
					$return['zooid']['config'] = json_decode($zooid->config);
					$return['zooid']['period'] = $zooid->period;
					
					$return['zooid']['BYN'] = $zooid->BYN / 100;
					$return['zooid']['RUB'] = $zooid->RUB / 100;
					
					$return['zooid']['list'] = [];

					$configZooID = [];
					$userZooIDConfigs = json_decode($zooid->config);
					foreach($userZooIDConfigs  as $i => $data){
						if(intval($data) > 1){
							array_push($configZooID, intval($data));
						}
					}
					$zooidConf = DB::table('zooid')->whereIn('id', $configZooID)->where('delete', 0)->get();
					if($zooidConf){
						foreach($zooidConf as $i => $data){
							$return['zooid']['list'][$i] = $data->name;
						}
					}

					
					// id	status	name	currency	days	month	pricebase	pendant	manager	remuneration	delivery
					$return['zooid']['info']['id'] = $subscriptionData->id;
					$return['zooid']['info']['status'] = $subscriptionData->status;
					$return['zooid']['info']['name'] = $subscriptionData->name;
					$return['zooid']['info']['currency'] = $subscriptionData->currency;
					$return['zooid']['info']['days'] = $subscriptionData->days;
					$return['zooid']['info']['month'] = $subscriptionData->month;
					$return['zooid']['info']['pricebase'] = $subscriptionData->pricebase;
					$return['zooid']['info']['pendant'] = $subscriptionData->pendant;
					$return['zooid']['info']['manager'] = $subscriptionData->manager;
					$return['zooid']['info']['remuneration'] = $subscriptionData->remuneration;
					$return['zooid']['info']['delivery'] = $subscriptionData->delivery;
			} else {
				$return['zooid'] = false;
			}
			$concierge = DB::table('sub_concierge_user')->where('user', $userID)->where('end', '>=', DB::raw('now()'))->first();
			if($concierge){
					// id	user	sub_zooid	pendant	manager	remuneration	delivery	status	create	start	end
					$subscriptionData = DB::table('sub_concierge')->where('id', $concierge->sub_concierge)->first();
					$return['concierge']['sub_concierge'] = $concierge->sub_concierge;
					$return['concierge']['status'] = $concierge->status;
					$return['concierge']['create'] = $concierge->create;
					$return['concierge']['start'] = $concierge->start;
					$return['concierge']['end'] = $concierge->end;
					$return['concierge']['name'] = $subscriptionData->name;
					// id	status	name	currency	days	month	pricebase
					$return['concierge']['info']['id'] = $subscriptionData->id;
					$return['concierge']['info']['status'] = $subscriptionData->status;
					$return['concierge']['info']['name'] = $subscriptionData->name;
					$return['concierge']['info']['currency'] = $subscriptionData->currency;
					$return['concierge']['info']['days'] = $subscriptionData->days;
					$return['concierge']['info']['month'] = $subscriptionData->month;
					$return['concierge']['info']['pricebase'] = $subscriptionData->pricebase;
			} else {
				$return['concierge'] = false;
			}
			
			$zoopolis = DB::table('sub_zoopolis_user')->where('user', $userID)->where('end', '>=', DB::raw('now()'))->first();
			if($zoopolis){
					// id	user	sub_zooid	pendant	manager	remuneration	delivery	status	create	start	end
					$subscriptionData = DB::table('sub_zoopolis')->where('id', $zoopolis->sub_zoopolis)->first();
					$return['zoopolis']['sub_zoopolis'] = $zoopolis->sub_zoopolis;
					$return['zoopolis']['status'] = $zoopolis->status;
					$return['zoopolis']['create'] = $zoopolis->create;
					$return['zoopolis']['start'] = $zoopolis->start;
					$return['zoopolis']['end'] = $zoopolis->end;
					$return['zoopolis']['name'] = $subscriptionData->name;
					// id	status	name	currency	days	month	pricebase
					$return['zoopolis']['info']['id'] = $subscriptionData->id;
					$return['zoopolis']['info']['status'] = $subscriptionData->status;
					$return['zoopolis']['info']['name'] = $subscriptionData->name;
					$return['zoopolis']['info']['currency'] = $subscriptionData->currency;
					$return['zoopolis']['info']['days'] = $subscriptionData->days;
					$return['zoopolis']['info']['month'] = $subscriptionData->month;
					$return['zoopolis']['info']['pricebase'] = $subscriptionData->pricebase;
			} else {
				$return['zoopolis'] = false;
			}
			
			$zooIDConfugs = DB::table('zooid')->where('hide', 0)->where('delete', 0)->get();
			foreach($zooIDConfugs  as $i => $data){
				$return['configs']['zooid'][$i]['id'] = $data->id;
				$return['configs']['zooid'][$i]['name'] = $data->name;
				$return['configs']['zooid'][$i]['BYN'] = $data->BYN;
				$return['configs']['zooid'][$i]['RUB'] = $data->RUB;
				
			}
			$conciergeConfugs = DB::table('concierge')->where('hide', 0)->where('delete', 0)->get();
			foreach($conciergeConfugs  as $i => $data){
				$return['configs']['concierge'][$i]['id'] = $data->id;
				$return['configs']['concierge'][$i]['name'] = $data->name;
				$return['configs']['concierge'][$i]['BYN'] = $data->BYN;
				$return['configs']['concierge'][$i]['RUB'] = $data->RUB;
			}
			
			$zooIDUserConfugs = DB::table('zooid_userconfig')->where('user', $userID)->first();
			if($zooIDUserConfugs){
				$return['configs']['zooiduser'] = json_decode($zooIDUserConfugs->config);
			}


		} else {
			$return['err'] = "Необходима автворизация";
			
		}

		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
	public function configZooid(Request $request){
		$return = [];
        $getUser = User::getUser($request);

		$userID = $getUser['id'];
		
		$delUserConfig = DB::table('zooid_userconfig')->where('user', $userID)->delete();
		$config = [];
		$zooid = $request->input('zooid');
		$save = DB::table('zooid_userconfig')->insertGetId([
			'user' => $userID,
			'config' => json_encode($zooid)
		]);
		
		return response()->json($return, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
	}
}