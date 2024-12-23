<?php

namespace App\Http\Controllers;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use App\Models\File;


class BepaidController extends Controller{
	public function __construct(){
        //
    }
	public function testpay(Request $request){
		$payid = bin2hex(random_bytes(8));
		return $payid;
	}
	public static function genPay($data){
        $payid = bin2hex(random_bytes(8));

		// 1 - zooid, 2 - concierge	
		if($data['type'] == 1){
			$createPay = DB::table('acquiring')->insertGetId([
				'user' => $data['user'],
				'payid' => $payid,
				'type' => $data['type'],
				'zooid_user' => $data['zooid'],
				'currency' => 'BYN',
				'sum' => $data['sum']
			]);
		}
		if($data['type'] == 2){
			$createPay = DB::table('acquiring')->insertGetId([
				'user' => $data['user'],
				'payid' => $payid,
				'type' => $data['type'],
				'concierge_user' => $data['concierge'],
				'currency' => 'BYN',
				'sum' => $data['sum']
			]);
		}

		

		return $payid;
	}
	
	public function bepaidinfo(Request $request){
		$transaction = $request->input('transaction');
		$transaction['uid'];
		$transaction['status'];
		$amount = $transaction['amount'];
		$currency = $transaction['currency'];
		$transaction['description'];
		$transaction['type'];
		$transaction['payment_method_type'];
		$tracking_id = $transaction['tracking_id'];

		/*
		[uid] => fce896f8-894d-4def-b9bb-facd6d6cb527
                            [status] => successful
                            [amount] => 25000
                            [currency] => BYN
                            [description] => Оформление подписки
                            [type] => payment
                            [payment_method_type] => credit_card
                            [tracking_id] => c3365f84d1530e8f
                            [message] => Successfully processed
                            [test] => 1
                            [created_at] => 2023-04-02T20:15:52.192Z
                            [updated_at] => 2023-04-02T20:15:55.606Z
                            [paid_at] => 2023-04-02T20:15:55.585Z
                            [expired_at] => 
                            [recurring_type] => 
                            [closed_at] => 
                            [settled_at] => 
                            [manually_corrected_at] => 
                            [language] => en
		*/
		if($transaction['status'] == 'successful'){
			$acquiring = DB::table('acquiring')->where('payid', $tracking_id)->where('sum', $amount)->where('currency', $currency)->first();
			// 	1 - zooid, 2 - concierge
			if($acquiring->type == 1){
				$zooid_user = $acquiring->zooid_user;
				$zooid = DB::table('sub_zooid_user')->where('id', $zooid_user)->update([
					'status' => 3
				]);
			}
			if($acquiring->type == 2){
				$concierge_user = $acquiring->concierge_user;
				$zooid = DB::table('sub_concierge_user')->where('id', $concierge_user)->update([
					'status' => 3
				]);
			}
			
		}

		file_put_contents("transaction_".$tracking_id.".txt", print_r($transaction, true));
		return true;
	}
}