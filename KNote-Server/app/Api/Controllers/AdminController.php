<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 11/12/2017
 * Time: 23:10
 */

namespace App\Api\Controllers;


use App\User;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    public function searchUsers(Request $request)
    {
        $keyword = $request->adminSearchKeyword;
        $users = DB::table('users')->where([
            ['permission', '=', 'normal'],
            ['name', 'like', '%'.$keyword.'%']
        ])->get();
        return response()->json(['users' => $users]);
    }

    public function deleteUser(Request $request)
    {
        $userId = $request->userId;
        $user = User::find($userId);
        $user->is_valid = false;
        $user->save();
        return response()->json(['success' => '已封禁该用户']);
    }

    public function unblockUser(Request $request)
    {
        $userId = $request->userId;
        $user = User::find($userId);
        $user->is_valid = true;
        $user->save();
        return response()->json(['success' => '已解封用户']);
    }

    public function resetUserPassword(Request $request)
    {
        $userId = $request->userId;
        $user = User::find($userId);
        $user->password = Hash::make('123456a');
        $user->save();
        return response()->json(['success' => '已重置用户密码为"123456a"']);
    }
}