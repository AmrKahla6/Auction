<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Member;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\BaseController as BaseController;

class UserController extends BaseController
{
    //Commercial registration
    public function registerBusiness(Request $request)
    {
        try {
            // return $request;
            $validator = Validator::make(
                $request->all(),
                [
                    'commercial_record'   => 'required|unique:members',
                    'phone'               => 'required|unique:members',
                    'date_of_birth'       => 'required',
                    'id_number'           => 'required|unique:members',
                    'email'               => 'required|unique:members',
                    'password'            => 'required|min:6',
                ],
                [
                    'commercial_record.required'   => __("user.commercial_record"),
                    'commercial_record.unique'     => __("user.commercial_exist"),
                    'phone.required'               => __("user.phone"),
                    'phone.unique'                 => __("user.unique_phone"),
                    'date_of_birth.required'       => __("user.date_of_birth"),
                    'id_number.required'           => __("user.id_number"),
                    'id_number.unique'             => __("user.unique_id_number"),
                    'email.required'               => __("user.email"),
                    'email.unique'                 => __("user.unique_email"),
                    'password.required'            => __("user.password"),
                    'password.min'                 => __("user.max_password"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $newmember                     = new Member;
            $newmember->commercial_record  = $request['commercial_record'];
            $newmember->phone              = $request['phone'];
            $newmember->date_of_birth      = $request['date_of_birth'];
            $newmember->id_number          = $request['id_number'];
            $newmember->email              = $request['email'];
            $newmember->password           = Hash::make($request['password']);
            $newmember->save();
            $message = __("user.regist_success");
            return $this->returnData('user', $message);
        }catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }



    //registeration process
    public function register(Request $request)
    {
        try {
            // return $request;
            $validator = Validator::make(
                $request->all(),
                [
                    'username'            => 'required',
                    'phone'               => 'required|unique:members',
                    'date_of_birth'       => 'required',
                    'nationality'         => 'required',
                    'email'               => 'required|unique:members',
                    'password'            => 'required|min:6',
                ],
                [
                    'username.required'            => __("user.username"),
                    'phone.required'               => __("user.phone"),
                    'phone.unique'                 => __("user.unique_phone"),
                    'date_of_birth.required'       => __("user.date_of_birth"),
                    'nationality.required'         => __("user.nationality"),
                    'email.required'               => __("user.email"),
                    'email.unique'                 => __("user.unique_email"),
                    'password.required'            => __("user.password"),
                    'password.min'                 => __("user.max_password"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $newmember                     = new Member;
            $newmember->username           = $request['username'];
            $newmember->phone              = $request['phone'];
            $newmember->date_of_birth      = $request['date_of_birth'];
            $newmember->nationality        = $request['nationality'];
            $newmember->email              = $request['email'];
            $newmember->password           = Hash::make($request['password']);
            $newmember->save();
            $message = __("user.regist_success");
            return $this->returnData('user', $message);
        }catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    /**
     * Member Login
     */

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'          => 'required',
                'password'       => 'required',
            ], [
                'email.required'        => __("user.email"),
                'password.required'     => __("user.password"),
            ]);

                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
                //login

                $credentials = $request->only(['email', 'password']);
                $token = Auth::guard('member-api')->attempt($credentials);  //generate token

                if (!$token)
                    return $this->returnError('E001', __('user.false_info'));

                $user = Auth::guard('member-api')->user();
                $user ->api_token = $token;

                $response = [
                    'id'        => $user->id,
                    'username'  => $user->username,
                    'phone'     => $user->phone,
                    'email'     => $user->email,
                    'api_token' => $token,
                ];
                //return token
                return $this->returnData('user', $response,__('user.login'));  //return json response
        } catch (\Exception $ex) {
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    }
}
