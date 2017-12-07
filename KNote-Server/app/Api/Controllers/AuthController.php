<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 15/11/2017
 * Time: 10:47
 */

namespace App\Api\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;


class AuthController extends BaseController
{
    /**
     * email
     * password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    /**
     * username
     * email
     * password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $registerInfo = $request->only('username', 'email', 'password');
        $registerInfo["password"] = Hash::make($registerInfo["password"]);
        if (User::where('name', $registerInfo["username"])) {
            return response()->json(['error' => '用户名已被注册！']);
        } else if (User::where('email', $registerInfo["email"])) {
            return response()->json(['error' => '邮箱已被注册！']);
        } else {
            User::create($registerInfo);

            return response()->json(['success' => '注册成功！']);
        }
    }

    public function modifyUserInfo(Request $request)
    {
        $userId = $request->userId;
        $username = $request->username;
        $gender = $request->gender;
        if (DB::table('users')->where('id', $userId)->get()->isEmpty()) {
            return response()->json([
                'error' => '该用户不存在！',
            ]);
        } else {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'name' => $username,
                    'gender' => $gender
                ]);
            return response()->json([
                'success' => '修改成功',
            ]);
        }
    }

    public function modifyPassword(Request $request)
    {
        $userId = $request->userId;
        $oldPw = $request->oldPass;
        $newPw = $request->pass;
        if (DB::table('users')->where('id', $userId)->get()->isEmpty()) {
            return response()->json([
                'error' => '该用户不存在！',
            ]);
        } else if (!Hash::check((string)$oldPw, DB::table('users')->where('id', $userId)->value('password'))) {
            return response()->json([
                'error' => '原密码错误！',
            ]);
        } else {
            DB::table('users')
                ->where('id', $userId)
                ->update(['password' => Hash::make($newPw)]);
            return response()->json([
                'success' => '修改成功！',
            ]);
        }
    }
}