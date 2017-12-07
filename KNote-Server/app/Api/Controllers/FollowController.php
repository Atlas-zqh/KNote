<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 03/12/2017
 * Time: 13:21
 */

namespace App\Api\Controllers;


use App\Follow;
use App\User;
use Dingo\Api\Contract\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends BaseController
{
    /**
     * follow_user_id
     * followed_user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $userId = $request->follow_user_id;
        $followed_user = $request->followed_user_id;

        $isFollowed = $this->isFollowed($userId, $followed_user);
        if ($isFollowed) {
            return response()->json(['failure' => '已经关注！']);
        }

        // 如果没找到，会自动返回404
        $user = User::findOrFail($userId);
        $followed = User::findOrFail($followed_user);

        DB::table('follows')->insert(
            ['follow_user_id' => $userId, 'followed_user_id' => $followed_user]
        );

        // 用户粉丝数和关注数变化
        $user = User::find($userId);
        $user->follow_cnt += 1;
        $user->save();

        $f_user = User::find($followed_user);
        $f_user->fans_count += 1;
        $f_user->save();

        return response()->json(['success' => '关注成功！']);
    }

    /**
     * follow_user_id
     * followed_user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFollow(Request $request)
    {
        $userId = $request->follow_user_id;
        $followed_user = $request->followed_user_id;

        $isFollowed = $this->isFollowed($userId, $followed_user);
        if (!$isFollowed) {
            return response()->json(['failure' => '尚未关注！']);
        }

        // 如果没找到，会自动返回404
        $user = User::findOrFail($userId);
        $followed = User::findOrFail($followed_user);

        DB::table('follows')->where(
            ['follow_user_id' => $userId, 'followed_user_id' => $followed_user]
        )->delete();

        // 用户粉丝数和关注数变化
        $user = User::find($userId);
        $user->follow_cnt -= 1;
        $user->save();

        $f_user = User::find($followed_user);
        $f_user->fans_count -= 1;
        $f_user->save();

        return response()->json(['success' => '取关成功！']);
    }

    /**
     * follow_user_id
     * followed_user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isFollowing(Request $request)
    {
        $userId = $request->follow_user_id;
        $followed_user = $request->followed_user_id;

        $result = $this->isFollowed($userId, $followed_user);
        return response()->json(['isFollowing' => $result]);
    }

    /**
     * @param $userId
     * @param $followed_user
     * @return bool
     */
    private function isFollowed($userId, $followed_user)
    {
        $follow = DB::table('follows')->where(
            [
                ['follow_user_id', '=', $userId],
                ['followed_user_id', '=', $followed_user]
            ]
        )->get();

        if (!$follow->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }
}