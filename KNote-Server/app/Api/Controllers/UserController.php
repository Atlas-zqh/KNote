<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 02/12/2017
 * Time: 21:13
 */

namespace App\Api\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    public function getFrequentTags(Request $request)
    {
        $userId = $request->userId;
        $frequent_tags = DB::table('tags')
            ->join('note_tag_relations', 'note_tag_relations.tag_id', '=', 'tags.id')
            ->select(DB::raw('tags.tag_content, count(*) as tag_cnt'))
            ->where('tags.user_id', $userId)
            ->groupBy('tags.tag_content')
            ->orderBy('tag_cnt', 'desc')
            ->limit(5)
            ->get();

        return json_encode($frequent_tags, JSON_UNESCAPED_UNICODE);
    }

    public function getHotNotes(Request $request)
    {
        $userId = $request->userId;
        $hot_notes = DB::table('notes')
            ->join('likes', 'notes.id', '=', 'likes.note_id')
            ->select(DB::raw('notes.id, notes.title, count(*) as like_cnt'))
            ->where([
                ['notes.user_id', '=', $userId],
                ['notes.permission', '=', 'public']
            ])->groupBy('notes.id')
            ->orderBy('like_cnt', 'desc')
            ->limit(10)
            ->get();

        return json_encode($hot_notes, JSON_UNESCAPED_UNICODE);
    }


    public function getCountInfo(Request $request)
    {
        $userId = $request->userId;
        $notebooks_cnt = DB::table('notebooks')->where('user_id', $userId)->count();
        $notes_cnt = DB::table('notes')->where('user_id' , $userId)->count();
        $fans_cnt = DB::table('follows')->where('followed_user_id', $userId)->count();
        $following_cnt = DB::table('follows')->where('follow_user_id', $userId)->count();

        return response()->json([['notebooks_cnt' => $notebooks_cnt], ['notes_cnt' => $notes_cnt], ['fans_cnt' => $fans_cnt], ['following_cnt' => $following_cnt]]);
    }
}