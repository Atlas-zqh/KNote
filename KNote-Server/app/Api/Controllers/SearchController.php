<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 10/12/2017
 * Time: 20:38
 */

namespace App\Api\Controllers;


use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends BaseController
{
    public function getSearchResult(Request $request)
    {
        $userId = $request->userId;
        $keyword = $request->keyword;

        $othersNotebooks = DB::table('notebooks')->where([
            ['user_id', '<>', $userId],
            ['is_valid', '=', true],
            ['notebook_name', 'like', '%' . $keyword . '%'],
            ['permission', '=', 'public']
        ])->get();

        $myNotebooks = DB::table('notebooks')->where([
            ['user_id', '=', $userId],
            ['is_valid', '=', true],
            ['notebook_name', 'like', '%' . $keyword . '%']
        ])->get();

        $othersNotes = DB::table('notes')->where([
            ['user_id', '<>', $userId],
            ['is_valid', '=', true],
            ['title', 'like', '%' . $keyword . '%'],
            ['permission', '=', 'public']
        ])->orWhere([
            ['user_id', '<>', $userId],
            ['is_valid', '=', true],
            ['content', 'like', '%' . $keyword . '%'],
            ['permission', '=', 'public']
        ])->get();

        $myNotes = DB::table('notes')->where([
            ['user_id', '=', $userId],
            ['is_valid', '=', true],
            ['title', 'like', '%' . $keyword . '%'],
        ])->orWhere([
            ['user_id', '=', $userId],
            ['is_valid', '=', true],
            ['content', 'like', '%' . $keyword . '%'],
        ])->get();

        $users = DB::table('users')->where([
            ['name', 'like', '%' . $keyword . '%'],
            ['permission', '=', 'normal'],
            ['is_valid', '=', true]
        ])->get();

        $tags = DB::table('tags')
            ->join('note_tag_relations', 'note_tag_relations.tag_id', '=', 'tags.id')
            ->join('notes', 'notes.id', '=', 'note_tag_relations.note_id')
            ->where([
                ['tags.user_id', '=', $userId],
                ['tags.tag_content', 'like', '%' . $keyword . '%'],
                ['tags.is_valid', '=', true]
            ])->get();

        return ['searchContent' => $keyword,
            'othersNotebooks' => $othersNotebooks,
            'myNotebooks' => $myNotebooks,
            'othersNotes' => $othersNotes,
            'myNotes' => $myNotes,
            'users' => $users,
            'tags' => $tags];
    }
}