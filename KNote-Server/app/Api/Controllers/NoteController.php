<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 03/12/2017
 * Time: 15:33
 */

namespace App\Api\Controllers;


use App\Note;
use App\User;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class NoteController extends BaseController
{
    /**
     * userId
     * @param Request $request
     * @return string
     */
    public function getAllValidNotesByUser(Request $request)
    {
        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            if (strcmp($user->id, $userId) == 0) {
                $notes = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['is_valid', true]
                ])->orderBy('updated_at', 'desc')->get();
                return json_encode($notes, JSON_UNESCAPED_UNICODE);
            } else {
                $notes = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->orderBy('updated_at', 'desc')->get();
                return json_encode($notes, JSON_UNESCAPED_UNICODE);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function getNoteDetail(Request $request)
    {
        $noteId = $request->note_id;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $note = DB::table('notes')->where('id', $noteId)->first();
            if (strcmp($note->user_id, $user->id) != 0 && $note->permission == 'private') {
                return response()->json(['error' => '您无权限查看该笔记'], 200);
            } else {
                $tags = DB::table('note_tag_relations')
                    ->join('tags', 'note_tag_relations.tag_id', '=', 'tags.id')
                    ->select('note_tag_relations.id as relationId', 'tags.id', 'tags.tag_content')
                    ->where('note_tag_relations.note_id', $noteId)
                    ->get();
                $like_count = DB::table('likes')
                    ->where('note_id', $noteId)->count();
                $notebook = DB::table('notebooks')
                    ->where('id', $note->notebook_id)->get();
                return response()->json(['note' => $note, 'tags' => $tags, 'like_count' => $like_count, 'notebook' => $notebook]);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

//    /**
//     * userId
//     * @param Request $request
//     * @return string
//     */
//    public function getAllPublicValidNotesByUser(Request $request)
//    {
//        $userId = $request->userId;
//        $notes = DB::table('notes')->where([
//            ['user_id', $userId],
//            ['is_valid', true],
//            ['permission', 'public']
//        ])->orderBy('updated_at', 'desc')->get();
//        return json_encode($notes, JSON_UNESCAPED_UNICODE);
//    }

    /**
     * userId
     * notebook_id
     * @param Request $request
     * @return string
     */
    public function getAllValidNotesByNotebookAndUser(Request $request)
    {
        $noetbook_id = $request->notebook_id;
        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            if (strcmp($user->id, $userId) == 0) {
                $notes = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['notebook_id', $noetbook_id],
                    ['is_valid', true]
                ])->orderBy('updated_at', 'desc')->get();
                return json_encode($notes, JSON_UNESCAPED_UNICODE);
            } else {
                $notes = DB::table('notes')->where([
                    ['user_id', $userId],
                    ['notebook_id', $noetbook_id],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->orderBy('updated_at', 'desc')->get();
                return json_encode($notes, JSON_UNESCAPED_UNICODE);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

//    /**
//     * user_id
//     * notebook_id
//     * @param Request $request
//     * @return string
//     */
//    public function getAllPublicValidNotesByNotebookAndUser(Request $request)
//    {
//        $userId = $request->userId;
//        $noetbook_id = $request->notebook_id;
//
//        return json_encode($notes, JSON_UNESCAPED_UNICODE);
//    }

    /**
     * note_id
     * note_title
     * note_content
     * permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyNote(Request $request)
    {
        $note_id = $request->note_id;
        $title = $request->note_title;
        $note_content = $request->note_content;
        $permission = $request->permission;

        $note = Note::find($note_id);
        $note->title = $title;
        $note->content = $note_content;
        $note->permission = $permission;

        $note->save();

        return response()->json(['success' => '修改成功']);
    }


    /**
     * noteId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteNote(Request $request)
    {
        $note_id = $request->noteId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $note = DB::table('notes')->where('id', $note_id)->first();
            $note_user_id = $note->user_id;

            if ((int)$note_user_id - (int)$user->id == 0) {
                DB::table('notes')->where('id', $note_id)->update(['is_valid' => false]);
                // 用户的笔记数-1
                $auser = User::find($note_user_id);
                $auser->notes_count -= 1;
                $auser->save();
                return response()->json(['success' => '删除成功!']);
            } else {
                return response()->json(['error' => '您无权限删除该笔记']);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    /**
     * user_id
     * notebook_id
     * note_title
     * note_content
     * permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNote(Request $request)
    {
        $user_id = $request->user_id;
        $notebook_id = $request->notebook_id;
        $title = $request->note_title;
        $note_content = $request->note_content;
        $permission = $request->permission;

        $note = new Note();
        $note->user_id = $user_id;
        $note->notebook_id = $notebook_id;
        $note->title = $title;
        $note->content = $note_content;
        $note->is_valid = true;
        $note->permission = $permission;

        $note->save();

        // 用户的笔记数+1
        $user = User::find($user_id);
        $user->notes_count += 1;
        $user->save();

        return response()->json(['success' => '创建成功']);
    }

    /**
     * user_id
     * note_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeNote(Request $request)
    {
        $userId = $request->user_id;
        $noteId = $request->note_id;

        $isLiked = $this->isLikedNote($userId, $noteId);
        if ($isLiked) {
            return response()->json(['failure' => '已经点赞！']);
        }

        DB::table('likes')->insert(
            ['note_id' => $noteId, 'user_id' => $userId]
        );

        return response()->json(['success' => '点赞成功！']);
    }

    /**
     * user_id
     * note_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelLike(Request $request)
    {
        $userId = $request->user_id;
        $noteId = $request->note_id;

        $isLiked = $this->isLikedNote($userId, $noteId);
        if (!$isLiked) {
            return response()->json(['failure' => '尚未点赞！']);
        }

        DB::table('likes')->where(
            ['note_id' => $noteId, 'user_id' => $userId]
        )->delete();

        return response()->json(['success' => '取消成功！']);
    }

    /**
     * user_id
     * note_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isLikingNote(Request $request)
    {
        $userId = $request->user_id;
        $noteId = $request->note_id;

        $result = $this->isLikedNote($userId, $noteId);
        return response()->json(['isLiking' => $result]);
    }

    /**
     * note_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLikeCount(Request $request)
    {
        $count = DB::table('likes')->where('note_id', $request->note_id)->count();
        return response()->json(['likeCount' => $count]);
    }

    private function isLikedNote($userId, $noteId)
    {
        $like = DB::table('likes')->where(
            [
                ['note_id', '=', $noteId],
                ['user_id', '=', $userId]
            ]
        )->get();

        if (!$like->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * note_id
     * @param Request $request
     * @return string
     */
    public function getTagByNote(Request $request)
    {
        $note_id = $request->note_id;
        $tags = DB::table('tags')
            ->join('note_tag_relations', 'note_tag_relations.tag_id', '=', 'tags.id')
            ->select('tags.id', 'tags.tag_content')
            ->where('note_tag_relations.note_id', $note_id)
            ->get();
        return json_encode($tags, JSON_UNESCAPED_UNICODE);
    }

//    /**
//     * 传入的是要存储的笔记的tag
//     * 删掉原来的，存新的即可
//     * @param Request $request
//     */
//    public function modifyNoteTags(Request $request)
//    {
//
//    }

    public function addTag(Request $request)
    {
        $note_id = $request->noteId;
        $tag_content = $request->tagContent;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $userId = DB::table('notes')->where('id', $note_id)->first()->user_id;
            if ((int)$userId - $user->id == 0) {
                $id = DB::table('tags')->insertGetId(
                    ['tag_content' => $tag_content, 'is_valid' => true, 'user_id' => $userId]
                );
                $relationId = DB::table('note_tag_relations')->insertGetId(
                    ['note_id' => $note_id, 'tag_id' => $id]
                );
                return response()->json(['success' => '添加成功', 'id' => $id, 'relationId' => $relationId, 'tagContent' => $tag_content]);
            } else {
                return response()->json(['error' => '添加失败']);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    /**
     * relationId
     * token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTag(Request $request)
    {
        $relationId = $request->relationId;
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

            $userId = DB::table('note_tag_relations')
                ->join('notes', 'note_tag_relations.note_id', '=', 'notes.id')
                ->select('notes.user_id')
                ->where('note_tag_relations.id', $relationId)->first();

            if ((int)$userId->user_id - $user->id == 0) {
                DB::table('note_tag_relations')->where('id', $relationId)->delete();
                return response()->json(['success' => '删除成功']);
            } else {
                return response()->json(['error' => '删除失败']);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function getTagsBuUser(Request $request)
    {

    }
}