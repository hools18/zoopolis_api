<?php

namespace App\Http\Controllers;

use App\Models\MissingAnimal;
use App\Models\PetQrCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Nonstandard\Uuid;
use Validator;

class PetQRCodeController
{
    public function index()
    {
        $codes = PetQrCode::latest()->get()->map(function ($qr) {
            if($qr->user){
                $fullName = $qr->user->first. ' '.$qr->user->last;
            }

            return [
                'uid' => $qr->uid,
                'url' => 'https://lk.sergivanov.ru/qrcode?uid='.$qr->uid,
                'user_name' => $fullName ?? '',
                'status' => $qr->is_active ? 'активен' : 'не активен',
            ];
        });

        return response()->json(['codes' => $codes], 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function create()
    {
        PetQRCode::create([
            'uid' => Uuid::uuid4()
        ]);

        return response()->json([
            'message' => 'QR код успешно создан',
        ], 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function tokenCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|uuid|exists:pet_qr_codes,uid',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error']);
        }

        $qrCode = PetQrCode::where('uid', $request->uid)->first();

        if(empty($qrCode->user_id)){
            return response()->json(['message' => 'error']);
        }

        $pet = DB::table('users_pets')->where('user', $qrCode->user_id)->first();

        if(empty($pet)){
            return response()->json(['message' => 'error']);
        }

        $manager = User::where('level', 2)->first();

        if(empty($manager)){
            return response()->json(['message' => 'error']);
        }

        return response()->json([
            'pet_name' => $pet->name,
            'manager_number' => UserController::formatPhone($manager->phone).' | '.$manager->first.' '.$manager->last,
        ], 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function foundPet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            'comments' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        DB::table('form_missinganimal')->insertGetId([
            'user' => 0,
            'address' => $request->address,
            'comments' => $request->comments,
            'uid' => $request->uid,
            'name_finder' => $request->name,
            'phone_finder' => $request->phone,
            'create' => Carbon::now()->format('Y-m-d H:i'),
        ]);


        return response()->json(['message' => 'Заявка успешно отравлена']);
    }
}
