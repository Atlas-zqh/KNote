<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 02/12/2017
 * Time: 21:13
 */

namespace App\Api\Controllers;


use App\Follow;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    public function getFrequentTags(Request $request)
    {

        $userId = $request->userId;
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $frequent_tags = DB::table('tags')
                ->join('note_tag_relations', 'note_tag_relations.tag_id', '=', 'tags.id')
                ->select(DB::raw('tags.tag_content, count(*) as tag_cnt'))
                ->where([['tags.user_id', $userId],
                    ['tags.is_valid', true]])
                ->groupBy('tags.tag_content')
                ->orderBy('tag_cnt', 'desc')
                ->limit(5)
                ->get();
            return json_encode($frequent_tags, JSON_UNESCAPED_UNICODE);
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function getHotNotes(Request $request)
    {
        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $hot_notes = DB::table('notes')
                ->join('likes', 'notes.id', '=', 'likes.note_id')
                ->select(DB::raw('notes.id, notes.title, count(*) as like_cnt'))
                ->where([
                    ['notes.user_id', '=', $userId],
                    ['notes.permission', '=', 'public'],
                    ['notes.is_valid', '=', true]
                ])->groupBy('notes.id')
                ->orderBy('like_cnt', 'desc')
                ->limit(10)
                ->get();

            return json_encode($hot_notes, JSON_UNESCAPED_UNICODE);
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }


    public function getCountInfo(Request $request)
    {
        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            if (strcmp($user->id, $userId) == 0) {
                $notebooks_cnt = DB::table('notebooks')->where([
                    ['user_id', $userId],
                    ['is_valid', true]
                ])->count();
                $notes_cnt = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['is_valid', true]
                ])->count();
                $fans_cnt = DB::table('follows')->where('followed_user_id', $userId)->count();
                $following_cnt = DB::table('follows')->where('follow_user_id', $userId)->count();

                return response()->json([['notebooks_cnt' => $notebooks_cnt], ['notes_cnt' => $notes_cnt], ['fans_cnt' => $fans_cnt], ['following_cnt' => $following_cnt]]);
            } else {
                $notebooks_cnt = DB::table('notebooks')->where([
                    ['user_id', $userId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->count();
                $notes_cnt = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->count();
                $fans_cnt = DB::table('follows')->where('followed_user_id', $userId)->count();
                $following_cnt = DB::table('follows')->where('follow_user_id', $userId)->count();

                return response()->json([['notebooks_cnt' => $notebooks_cnt], ['notes_cnt' => $notes_cnt], ['fans_cnt' => $fans_cnt], ['following_cnt' => $following_cnt]]);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function getUserInfo(Request $request)
    {
        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            if (strcmp($user->id, $userId) == 0) {
                $user = DB::table('users')->where('id', $userId)->get();

                return json_encode(['user' => $user], JSON_UNESCAPED_UNICODE);
            } else {
                $user = DB::table('users')->where('id', $userId)->get();

                $user[0]->notes_count = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->count();

                $user[0]->notebooks_count = DB::table('notebooks')->where([
                    ['user_id', $userId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->count();

                return json_encode(['user' => $user], JSON_UNESCAPED_UNICODE);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

    }

    public function getFollowers(Request $request)
    {
        $userId = $request->userId;
        $followers = DB::table('users')
            ->join('follows', 'follows.follow_user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.fans_count')
            ->where('follows.followed_user_id', $userId)
            ->get();
        return json_encode($followers, JSON_UNESCAPED_UNICODE);
    }

    public function getFollowing(Request $request)
    {
        $userId = $request->userId;
        $followers = DB::table('users')
            ->join('follows', 'follows.followed_user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.fans_count')
            ->where('follows.follow_user_id', $userId)
            ->get();
        return json_encode($followers, JSON_UNESCAPED_UNICODE);
    }

}