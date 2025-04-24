<?php

namespace App\Http\Controllers;

use App\Jobs\SMS as SMS;
use App\Models\File;
use App\Models\PetQrCode;
use App\Models\CheckPhoneNumber;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// use App\Http\Controllers\SmsAssistentBy;


class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public static function getGuest($token)
    {
        $json = [];
        $guest = DB::table('guests')->where('token', $token)->first();
        if ($guest) {
            $json['id'] = $guest->id;
        } else {
            $create = DB::table('guests')->insertGetId([
                'token' => $token
            ]);
            $json['id'] = $create;
        }
        return $json;
    }

    function getUserIDToken($token)
    {
        $user = DB::table('userstoken')->where('token', $token)->first();
        if (isset($user)) {
            if (isset($user->user)) {
                return $user->user;
            } else {
                return false;
            }
        }
        return false;
    }

    function getUserId($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return $user;
    }

    public static function getUserEmail($email)
    {
        $user = DB::table('users')->where('email', $email)->first();
        return $user;
    }

    public static function getUser(Request $request, $getUserID = null)
    {
        $token = $request->header('Authorization');
        $return = [];

        if ($token) {
            if (empty($getUserID)) {
                $user = DB::table('userstoken')->where('token', $token)->first();
            } else {
                $user = new \stdClass();
                $user->user = intval($getUserID);
            }

            if ($user) {
                $return['id'] = $user->user;
                $addrCheck = DB::table('users_address')->where('user', $user->user)->first();
                if ($addrCheck) {
                } else {
                    $create = DB::table('users_address')->insertGetId([
                        'user' => $user->user
                    ]);
                };
                $petsCheck = DB::table('users_pets')->where('user', $user->user)->first();
                if ($petsCheck) {
                } else {
                    $create = DB::table('users_pets')->insertGetId([
                        'user' => $user->user
                    ]);
                }

                $getUser = DB::table('users')->where('id', $user->user)->first();
                $return['email'] = $getUser->email;
                $return['emailCheck'] = intval($getUser->emailCheck);
                $return['phone'] = self::formatPhone($getUser->phone);
                if ($getUser->phoneOther_1) {
                    $return['phone_other_1'] = self::formatPhone($getUser->phoneOther_1);
                };
                if ($getUser->phoneOther_2) {
                    $return['phone_other_2'] = $getUser->phoneOther_2;
                }
                if ($getUser->phoneOther_3) {
                    $return['phone_other_3'] = $getUser->phoneOther_3;
                }


                $return['phoneCheck'] = intval($getUser->phoneCheck);
                $return['first'] = $getUser->first;
                $return['last'] = $getUser->last;
                $return['level'] = intval($getUser->level);
                $return['is_active'] = $getUser->is_active;
                $return['is_blocked'] = $getUser->is_blocked;
                $return['blocked_reason'] = $getUser->blocked_reason;
                $return['pet_uid'] = PetQrCode::where('user_id', $user->user)->where('is_active', 1)->first()?->uid;
                if ($getUser->level == 9) {
                    $return['admin'] = true;
                } else {
                    $return['admin'] = false;
                }

                $address = DB::table('users_address')->where('user', $user->user)->first();
                if ($address->city) {
                    $return['address']['city'] = $address->city;
                };
                if ($address->street) {
                    $return['address']['street'] = $address->street;
                };
                if ($address->entrance) {
                    $return['address']['entrance'] = $address->entrance;
                };
                if ($address->apartment) {
                    $return['address']['apartment'] = $address->apartment;
                };

                if ($address->floor) {
                    $return['address']['floor'] = $address->floor;
                };
                if ($address->comm) {
                    $return['address']['comm'] = $address->comm;
                };

                $pets = DB::table('users_pets')->where('user', $user->user)->first();
                if ($pets->name) {
                    $return['pets']['name'] = $pets->name;
                };
                if ($pets->age) {
                    $return['pets']['age'] = $pets->age;
                };
                if ($pets->gender) {
                    $return['pets']['gender'] = $pets->gender;
                };
                if ($pets->breed) {
                    $return['pets']['breed'] = $pets->breed;
                };
                if ($pets->comm) {
                    $return['pets']['comm'] = $pets->comm;
                };
                if ($pets->commmore) {
                    $return['pets']['commmore'] = $pets->commmore;
                };

                $timeNow = date('Y-m-d H:i:s');

                $hasSubZooId = DB::table('sub_zooid_user')
                    ->where('user', $user->user)
                    ->where('end', '>', $timeNow)
                    ->exists();
                $hasSubConciergeId = DB::table('sub_concierge_user')
                    ->where('user', $user->user)
                    ->where('end', '>', $timeNow)
                    ->exists();
                $hasSubZoopolisId = DB::table('sub_zoopolis_user')
                    ->where('user', $user->user)
                    ->where('end', '>', $timeNow)
                    ->exists();

                $return['hasSubscribe'] = $hasSubZooId || $hasSubConciergeId || $hasSubZoopolisId;

                $return['feedbacks'] = [];
                $missinganimal = DB::table('form_missinganimal')
                    ->where('user', $user->user)
                    ->orderBy('create', 'DESC')->get();
                if ($missinganimal) {
                    foreach ($missinganimal as $i => $data) {
                        $return['feedbacks'][$i]['id'] = $data->id;
                        $return['feedbacks'][$i]['create'] = $data->create;
                        $return['feedbacks'][$i]['text'] = $data->text;
                        $return['feedbacks'][$i]['status'] = $data->status;
                        $return['feedbacks'][$i]['user'] = $data->user;
                    }
                }

                return $return;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function tokenCheck(Request $request)
    {
        $json = [];
        $getUser = $this->getUser($request);

        if (!$getUser) {
            $json['error'] = 'Неверный токен';
        } else {
            $json = $getUser;
        }
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function getProfile(Request $request)
    {
        $return = [];
        $getUser = $this->getUser($request);
        if ($getUser) {
            $user = $getUser['id'];
            $return['id'] = $user;
            $return['email'] = $getUser['email'];
            $return['phone'] = $getUser['phone'];
            $return['name'] = $getUser['name'];
            $return['f'] = $getUser['f'];
            $return['i'] = $getUser['i'];
            $return['o'] = $getUser['o'];
            $return['level'] = $getUser['level'];
            $return['avatar'] = $getUser['avatar'];


            return response()->json(
                $return,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $return['error'] = 'Invalid session token';
            return response()->json(
                $return,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    public function login(Request $request)
    {
        $json = [];
        $login = $request->input('login'); // Номер телефона
        $login = preg_replace("/[^0-9]/", "", $login);
        if ($login) {
        } else {
            $json['err'][] = 'Неверный формат номера телефона.';
        }

        $pass = $request->input('password');

        if (mb_strlen($pass) <= 7) {
            $json['err'][] = 'Минимальная длина пароля 8 символов';
            $json['password'] = 'Минимальная длина пароля 8 символов';
        }

        if (isset($json['err'])) {
            // Ошибки.
        } else {
            $phoneCheck = DB::table('users')->where('phone', $login)->count();
            if ($phoneCheck == 1) {
                $user = DB::table('users')->where('phone', $login)->first();

                if ($user && Hash::check($request->input('password'), $user->pass)) {
                    if ($request->uid) {
                        if (!empty(
                        PetQrCode::where('uid', $request->uid)->whereNull('user_id')->where(
                            'is_active',
                            0
                        )->exists()
                        )) {
                            $qr = PetQrCode::where('uid', $request->uid)->first();
                            $qr->user_id = $user->id;
                            $qr->is_active = 1;
                            $qr->save();
                        }
                    }

                    $this->sendCode($user);
                } else {
                    $json['err'][] = 'Неверный пароль';
                    $json['password'] = 'Неверный пароль';
                }
            } else {
                $json['err'][] = 'Неверный номер телефона';
                $json['login'] = 'Неверный номер телефона';
            }
        }
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function logout(Request $request)
    {
        $json = [];
        $token = $request->header('Authorization');
        $user = DB::table('userstoken')->where('token', $token)->delete();
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function validateNewUser(Request $request)
    {
        $json = [];
        $login = $request->input('login'); // Номер телефона
        $login = preg_replace("/[^0-9]/", "", $login);

        $phoneCheck = DB::table('users')->where('phone', $login)->count();
        if ($phoneCheck == 1) {
            $json['err'][] = 'Данный номер телефона уже зарегистрирован.';
            $json['login'] = 'Данный номер телефона уже зарегистрирован.';
        } else {
            $code = rand(1000, 9999);
            CheckPhoneNumber::updateOrCreate([
                'phone' => $login,
            ], [
                'phone' => $login,
                'code' => $code,
            ]);
            $sms_assistent = new SMS(env('API_USERNAME'), env('API_PASSWORD'));
            $sms_assistent->setSubscribeName('Zoopolis');
            $sms_assistent->sendSms(
                env('API_SENDER'),
                [$login],
                'Ваш код подтверждения: ' . $code
            );
        }
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function validateCode(Request $request)
    {
        $result = CheckPhoneNumber::where('code', $request->code)
            ->where('phone', $request->phone)->first();
        if (empty($result)) {
            $json['err'][] = 'Неверный код';
            $json['code'] = 'Неверный код';
        } else {
            $result->delete();
        }

        return response()->json(
            $json ?? [],
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function newUser(Request $request)
    {
        $json = [];
        $login = $request->input('login');
        $login = preg_replace("/[^0-9]/", "", $login);
        $email = $request->input('email');
        $email = mb_strtolower($email);
        $pass = $request->input('password');
        $phoneCheck = DB::table('users')->where('phone', $login)->count();
        if ($phoneCheck == 1) {
            $json['err'][] = 'Данный номер телефона уже зарегистрирован.';
            $json['login'] = 'Данный номер телефона уже зарегистрирован.';
        } else {
            $createUser = DB::table('users')->insertGetId([
                'phone' => $login,
                'email' => $email,
                'pass' => Hash::make($pass)
            ]);
            if ($request->uid) {
                if (PetQrCode::where('uid', $request->uid)->whereNull('user_id')->where('is_active', 0)->exists()) {
                    $qr = PetQrCode::where('uid', $request->uid)->first();
                    $qr->user_id = $createUser;
                    $qr->is_active = 1;
                    $qr->save();
                }
            }
            $user = DB::table('users')->where('phone', $login)->first();
            $token = random_bytes(16);
            $token = bin2hex($token);
            $json['userID'] = intval($user->id);
            $json['token'] = $token;
            DB::table('userstoken')->insertGetId([
                'user' => $user->id,
                'token' => $token
            ]);
        }

        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function sendCode($user)
    {
        $code = rand(1000, 9999);
        DB::table('users')->where('id', $user->id)->update(['code_verification' => $code]);
        $sms_assistent = new SMS(env('API_USERNAME'), env('API_PASSWORD'));
        $sms_assistent->setSubscribeName('Zoopolis');
        $result = $sms_assistent->sendSms(
            env('API_SENDER'),
            [$user->phone],
            'Ваш код подтверждения: ' . $code
        );

        Log::log('info', 'Отправка смс: ', $result);
    }

    public function sendCodeRegister($phone, $code)
    {
        $sms_assistent = new SMS(env('API_USERNAME'), env('API_PASSWORD'));
        $sms_assistent->setSubscribeName('Zoopolis');
        $result = $sms_assistent->sendSms(
            env('API_SENDER'),
            [$phone],
            'Ваш код подтверждения: ' . $code
        );

        Log::log('info', 'Отправка смс: ', $result);
    }

    public function checkCodeVerification(Request $request)
    {
        $user = User::where('code_verification', $request->code)->first();
        if ($user) {
            DB::table('users')->where('id', $user->id)->update(['code_verification' => null]);
            $token = random_bytes(16);
            $token = bin2hex($token);
            $json['userID'] = intval($user->id);
            $json['token'] = $token;
            DB::table('userstoken')->insertGetId([
                'user' => $user->id,
                'token' => $token
            ]);
        } else {
            $json['err'][] = 'Неверный код';
            $json['code'] = 'Неверный код';
        }

        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public static function recoveryProfile(Request $request)
    {
        $return = [];
        $login = $request->input('login'); // Номер телефона
        $login = preg_replace("/[^0-9]/", "", $login);
        if ($login) {
        } else {
            $return['err'][] = 'Неверный формат номера телефона.';
        }
        if (isset($return['err'])) {
            // Ошибки.
        } else {
            $phoneCheck = DB::table('users')->where('phone', $login)->exists();
            if ($phoneCheck) {
                $newPass = rand(10000000, 99999999);
                $sms_assistent = new SMS(env('API_USERNAME'), env('API_PASSWORD'));
                $sms_assistent->setSubscribeName('Zoopolis');
                $result = $sms_assistent->sendSms(
                    env('API_SENDER'),
                    [$login],
                    'Ваш новый пароль для входа в Личный кабинет: ' . $newPass
                );

                DB::table('users')->where('phone', $login)->update([
                    'pass' => Hash::make($newPass)
                ]);

                Log::log('info', 'Отправка смс: ', $result);
            } else {
                $return['err'][] = 'Номер телефона не зарегистрирован.';
                $return['login'] = 'Номер телефона не зарегистрирован.';
            }
        }
        return response()->json(
            $return,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public static function newUserOauth($email, $name)
    {
        $return = array();

        $createUser = DB::table('users')->insertGetId([
            'email' => $email,
            'name' => $name
        ]);
        $token = random_bytes(8);
        $token = bin2hex($token);
        $saveToken = DB::table('user_one_timetoken')->insertGetId([
            'user' => $createUser,
            'token' => $token
        ]);


        $return['token'] = $token;
        return $return;
    }

    public static function loginUserOauth($id)
    {
        $return = array();
        $token = random_bytes(8);
        $token = bin2hex($token);
        $saveToken = DB::table('user_one_timetoken')->insertGetId([
            'user' => $id,
            'token' => $token
        ]);
        $return['token'] = $token;
        return $return;
    }

    public static function userOauth($oneToken)
    {
        $json = [];
        $ot = DB::table('user_one_timetoken')->where('token', $oneToken)->where('check', 1)->first();
        if ($ot) {
            $user = DB::table('users')->where('id', $ot->user)->first();
            $token = random_bytes(16);
            $token = bin2hex($token);
            $json['userID'] = intval($user->id);
            $json['token'] = $token;
            $saveToken = DB::table('userstoken')->insertGetId([
                'user' => $user->id,
                'token' => $token
            ]);
            $deAct = DB::table('user_one_timetoken')->where('token', $oneToken)->update([
                'check' => 0
            ]);
        } else {
            $json['error'] = 'Invalid session token';
        }
        return $json;
    }

    public function editUser(Request $request)
    {
        $json = [];
        $f = $request->input('f');
        $i = $request->input('i');
        $o = $request->input('o');

        $getUser = $this->getUser($request);
        if ($getUser) {
            $userID = $getUser['id'];
            if ($f != '') {
                $affected = DB::table('users')->where('id', $userID)->update([
                    'f' => $f
                ]);
            }
            if ($i != '') {
                $affected = DB::table('users')->where('id', $userID)->update([
                    'i' => $i
                ]);
            }
            if ($o != '') {
                $affected = DB::table('users')->where('id', $userID)->update([
                    'o' => $o
                ]);
            }
            return response()->json(
                $json,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $json['error'] = 'Invalid session token';
            return response()->json(
                $json,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    public function editpass(Request $request)
    {
        $json = [];
        $сurrent = $request->input('сurrent');
        $newppass = $request->input('newppass');

        $getUser = $this->getUser($request);
        if ($getUser) {
            $userID = $getUser['id'];
            $userEmail = $getUser['email'];
            $HashePass = md5(
                md5(
                    md5('04jhBgl' . $сurrent . 'Jdh49Y4jhO') . md5('J48VjV39tjh' . $userEmail . 'Kdjh(h4b')
                ) . '(3g(4857*&#dfjgh*(7'
            );
            $checkPass = DB::table('users')->where('id', $userID)->where('pass', $HashePass)->first();
            if ($checkPass) {
                $newppass = $request->input('newppass');
                $HashePass = md5(
                    md5(
                        md5('04jhBgl' . $newppass . 'Jdh49Y4jhO') . md5('J48VjV39tjh' . $userEmail . 'Kdjh(h4b')
                    ) . '(3g(4857*&#dfjgh*(7'
                );
                $affected = DB::table('users')->where('id', $userID)->update([
                    'pass' => $HashePass
                ]);
            } else {
                $json['error'] = 'Invalid password';
            }
        } else {
            $json['error'] = 'Invalid session token';
        }
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function editPhoneProfile(Request $request)
    {
        $json = [];
        $phone = $request->input('phone');
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $getUser = $this->getUser($request);
        if ($getUser) {
            $userID = $getUser['id'];
            $affected = DB::table('users')->where('id', $userID)->update([
                'phone' => $phone
            ]);
            return response()->json(
                $json,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $json['error'] = 'Invalid session token';
            return response()->json(
                $json,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    public function saveProfilePhone(Request $request)
    {
        $json = [];
        $token = $request->input('token');
        $phone = $request->input('phone');
        $phone = int($phone);
        if (isset($token)) {
            if ($token == '') {
                $json['err'] = 'Invalid session token';
                return response()->json(
                    $json,
                    200,
                    array('Content-Type' => 'application/json;charset=utf8'),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                $userID = $this->getUserIDToken($token);
                $affected = DB::table('users')->where('id', $userID)->update(
                    ['phone' => $phone]
                );
                return response()->json(
                    $json,
                    200,
                    array('Content-Type' => 'application/json;charset=utf8'),
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            $json['err'] = 'Invalid session token';
            return response()->json(
                $json,
                200,
                array('Content-Type' => 'application/json;charset=utf8'),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    public function show($id)
    {
        //$product = Product::find($id);
        return $id;
    }

    public function actionToken($token)
    {
        return $token;
    }

    public function saveProfileData(Request $request, $clientID = null)
    {
        $json = [];
        $data = [];
        $getUser = $this->getUser($request);
        $userID = $getUser['id'];

        if ($getUser['admin']) {
            if ($clientID) {
                $userID = intval($clientID);
            }
        } else {
        }

        // Базовая о пользователе.
        $first = $request->input('first');
        $last = $request->input('last');
        $phone = $request->input('phone');
        $level = $request->input('level');
        DB::table('users')->where('id', $userID)->update(
            ['first' => $first]
        );
        if ($level != '') {
            DB::table('users')->where('id', $userID)->update(
                ['level' => $level]
            );
        };
        DB::table('users')->where('id', $userID)->update(
            ['last' => $last]
        );
        if ($phone != '') {
            $phone = self::clearPhone($phone);
            if (DB::table('users')->where('id', '!=', $userID)->where('phone', $phone)->exists()) {
                return response()->json(
                    [
                        'error' => 'Данный номер уже зарегистрирован в системе'
                    ],
                    200,
                    array('Content-Type' => 'application/json;charset=utf8'),
                    JSON_UNESCAPED_UNICODE
                );
            }
            DB::table('users')->where('id', $userID)->update(
                ['phone' => $phone]
            );
        };
        $phone_other_1 = $request->input('phone_other_1');
        if ($phone_other_1 != '') {
            $phone_other_1 = self::clearPhone($phone_other_1);
            DB::table('users')->where('id', $userID)->update(
                ['phoneOther_1' => $phone_other_1]
            );
        } else {
            DB::table('users')->where('id', $userID)->update(
                ['phoneOther_1' => null]
            );
        }

        // Адресс
        $addrCheck = DB::table('users_address')->where('user', $userID)->first();
        if ($addrCheck) {
        } else {
            $create = DB::table('users_address')->insertGetId([
                'user' => $userID
            ]);
        }


        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function saveProfileDataAddress(Request $request, $clientID = null)
    {
        $json = [];
        $data = [];
        $getUser = $this->getUser($request);
        $userID = $getUser['id'];


        $dataAddress = [];
        $city = $request->input('city');
        $street = $request->input('street');
        $entrance = $request->input('entrance');
        $apartment = $request->input('apartment');
        $floor = $request->input('floor');
        $comm = $request->input('comm');
        if ($city != '') {
            $dataAddress['city'] = $city;
        };
        if ($street != '') {
            $dataAddress['street'] = $street;
        };
        if ($entrance != '') {
            $dataAddress['entrance'] = $entrance;
        };
        if ($apartment != '') {
            $dataAddress['apartment'] = $apartment;
        };
        if ($floor != '') {
            $dataAddress['floor'] = $floor;
        };
        if ($comm != '') {
            $dataAddress['comm'] = $comm;
        };
        if ($dataAddress) {
            if ($getUser['admin']) {
                if ($clientID) {
                    if ($clientID) {
                        $userID = intval($clientID);
                    }
                }
            } else {
            }
            $update = DB::table('users_address')->where('user', $userID)->update($dataAddress);
        }
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function saveProfileDataPets(Request $request, $clientID = null)
    {
        $json = [];
        $data = [];
        $getUser = $this->getUser($request);
        $userID = $getUser['id'];

        $dataPets = [];
        $name = $request->input('name');
        $age = $request->input('age');

        $male = $request->input('male');
        $female = $request->input('female');
        $breed = $request->input('breed');
        $comm = $request->input('comm');
        $commmore = $request->input('commmore');
        if ($name != '') {
            $dataPets['name'] = $name;
        };
        if ($age != '') {
            $dataPets['age'] = $age;
        };

        if ($male != []) {
            $dataPets['gender'] = 1;
        }
        if ($female != []) {
            $dataPets['gender'] = 2;
        }
        if ($breed != '') {
            $dataPets['breed'] = $breed;
        };
        if ($comm != '') {
            $dataPets['comm'] = $comm;
        };
        if ($commmore != '') {
            $dataPets['commmore'] = $commmore;
        };

        if ($dataPets) {
            if ($getUser['admin']) {
                if ($clientID) {
                    if ($clientID) {
                        $userID = intval($clientID);
                    }
                }
            } else {
            }
            $update = DB::table('users_pets')->where('user', $userID)->update($dataPets);
        }
        return response()->json(
            $json,
            200,
            array('Content-Type' => 'application/json;charset=utf8'),
            JSON_UNESCAPED_UNICODE
        );
    }

    public static function formatPhone($phone = null)
    {
        if (!empty($phone)) {
            $firstSymbol = mb_substr($phone, 0, 1);

            if ($firstSymbol === '3') {
                try {
                    preg_match("/^([0-9]{3})([0-9]{2})([0-9]{3})([0-9]{2})([0-9]{2})$/", $phone, $matches);
                    if (isset($matches[0])) {
                        unset($matches[0]);
                        $phone = vsprintf("+%s (%s) %s-%s-%s", $matches);
                    } else {
                        return $phone;
                    }
                } catch (\Exception $e) {
                }
            } else {
                try {
                    preg_match("/^([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})$/", $phone, $matches);
                    if (isset($matches[0])) {
                        unset($matches[0]);
                        $phone = vsprintf("+%s (%s) %s-%s-%s", $matches);
                    } else {
                        return $phone;
                    }
                } catch (\Exception $e) {
                }
            }
        }

        return $phone;
    }

    public function clearPhone($phone = null)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    public function blockedUser(Request $request, $clientID = null)
    {
        $getUser = $this->getUser($request);

        if ($getUser['level'] == 9) {
            $user = DB::table('users')->where('id', $clientID)->first();

            DB::table('users')->where('id', $clientID)->update([
                'is_blocked' => (int)!$user->is_blocked,
                'blocked_reason' => $request->input('reason'),
            ]);
        }

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

    public function getExportUser(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $sheet = $spreadsheet->getActiveSheet();

//        dd(1);
        $fields = $request->input('fields');
        $users = DB::table('users')->get($fields)->toArray();

//        $i = 0;
//        foreach ($fields as $field) {
//            switch ($field) {
//                case 'phone':
        $sheet->setCellValue('A1', 'Номер телефона');
//                    break;
//                case 'email':
        $sheet->setCellValue('B1', 'Е-mail');
//                    break;
//                case 'first':
        $sheet->setCellValue('C1', 'Имя');
//                    break;
//                case 'last':
        $sheet->setCellValue('D1', 'Фамилия');
//                    break;
//                case 'level':
        $sheet->setCellValue('E1', 'Роль');
//                    break;
//                case 'is_blocked':
        $sheet->setCellValue('F1', 'Статус блокировки');
//                    break;
//            }
//        }
        $i = 1;
        foreach ($users as $user) {
            $i++;
            foreach ((array)$user as $key => $value) {
                switch ($key) {
                    case 'phone':
                        $sheet->setCellValueExplicit('A' . $i, (string)$value, DataType::TYPE_STRING);
                        break;
                    case 'email':
                        $sheet->setCellValue('B' . $i, $value);
                        break;
                    case 'first':
                        $sheet->setCellValue('C' . $i, $value);
                        break;
                    case 'last':
                        $sheet->setCellValue('D' . $i, $value);
                        break;
                    case 'level':
                        $role = 'Клиент';
                        switch ($value) {
                            case '2':
                                $role = 'Менеджер';
                                break;
                            case '9':
                                $role = 'Администратор';
                                break;
                        }
                        $sheet->setCellValue('E' . $i, $role);
                        break;
                    case 'is_blocked':
                        $value = $value ? 'Заблокирован' : 'Не заблокирован';
                        $sheet->setCellValue('F' . $i, $value);
                        break;
                }
            }
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'users.xlsx';
        $writer->save($path = storage_path($filename));

        return response()->download($path)->deleteFileAfterSend();
    }

}
