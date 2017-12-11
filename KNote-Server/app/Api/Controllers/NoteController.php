<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 03/12/2017
 * Time: 15:33
 */

namespace App\Api\Controllers;

use App\Note;
use App\Notebook;
use App\User;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use TCPDF;
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
            if (strcmp($note->user_id, $user->id) !== 0 && $note->permission === 'private') {
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
    public function modifyNoteContent(Request $request)
    {
        $note_id = $request->noteId;
        $title = $request->noteTitle;
        $note_content = $request->noteContent;

        $note = Note::find($note_id);
        $note->title = $title;
        $note->content = $note_content;

        $note->save();

        return response()->json(['success' => '修改成功']);
    }

    public function modifyNotePermission(Request $request)
    {
        $note_id = $request->id;
        $permission = $request->permission;
        $note = Note::find($note_id);

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'user_not_found'], 404);
            } else {
                if ((int)$user->id - (int)$note->user_id != 0) {
                    return response()->json(['error' => '您无权修改该笔记权限'], 200);
                } else {
                    $note->permission = $permission;

                    $note->save();

                    return response()->json(['success' => '修改成功']);
                }
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], 200);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'token_absent'], 200);
        }

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
        $user_id = $request->userId;
        $notebook_id = $request->notebookId;
        $title = $request->noteTitle;
        $note_content = $request->noteContent;
        $permission = $request->permission;

        $note = new Note();
        $note->user_id = $user_id;
        $note->notebook_id = $notebook_id;
        $note->title = $title;
        if ($note_content) {
            $note->content = $note_content;
        } else {
            $note->content = '';
        }
        $note->is_valid = true;
        $note->permission = $permission;

        $note->save();

        // 用户的笔记数+1
        $user = User::find($user_id);
        $user->notes_count += 1;
        $user->save();

        // 笔记本内的笔记数+1
        $notebook = Notebook::find($notebook_id);
        $notebook->notes_count += 1;
        $notebook->save();

        return response()->json(['success' => '创建成功', 'noteId' => $note->id]);
    }

    /**
     * user_id
     * note_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeNote(Request $request)
    {
        $userId = $request->userId;
        $noteId = $request->noteId;

        $isLiked = $this->isLikedNote($userId, $noteId);
        if ($isLiked) {
            return response()->json(['error' => '已经点赞！']);
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
        $userId = $request->userId;
        $noteId = $request->noteId;

        $isLiked = $this->isLikedNote($userId, $noteId);
        if (!$isLiked) {
            return response()->json(['error' => '尚未点赞！']);
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
        $userId = $request->userId;
        $noteId = $request->noteId;

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

    public function getPDF(Request $request)
    {
        $noteId = $request->noteId;

        $note = DB::table('notes')->where('id', $noteId)->first();
        $user = DB::table('users')->where('id', $note->user_id)->first();
        $notebook = DB::table('notebooks')->where('id', $note->notebook_id)->first();

        $tags = DB::table('tags')
            ->join('note_tag_relations', 'tags.id', '=', 'note_tag_relations.tag_id')
            ->select('tags.tag_content as content')
            ->where('note_tag_relations.note_id', $noteId)->get();
        // create new PDF document
        $pdf = new \TCPDF();
        // 设置文档信息
        $pdf->SetCreator('KNOTE');
        $pdf->SetAuthor($user->name);
        $pdf->SetTitle($note->title);
        $pdf->SetSubject($note->title);

        // 设置页眉和页脚信息
        $pdf->setFooterData([0, 64, 0], [0, 64, 128]);
        $pdf->setPrintHeader(false);

        // 设置页眉和页脚字体
        $pdf->setFooterFont(['helvetica', '', '8']);

        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('courier');

        // 设置间距
        $pdf->SetMargins(15, 15, 15);//页面间隔
        $pdf->SetFooterMargin(10);//页脚bottom间隔

        // 设置分页
        $pdf->SetAutoPageBreak(true, 25);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        //设置字体 stsongstdlight支持中文
        $pdf->SetFont('droidsansfallback', '', 14);

        $tagStr = '';
        foreach ($tags as $tag) {
            $tagStr .= '"' . $tag->content . '"  ';
        }

        //第一页
        $pdf->AddPage();
        $pdf->writeHTML('<h1 style="text-align: left;color: #00815d;font-size: 30px;">' . $note->title . '</h1>');
        $pdf->writeHTML('<div style="text-align: left;color: #2A8146;font-weight: bold">作者:  ' . $user->name . '</div>');
        $pdf->writeHTML('<div style="text-align: left;color: #2A8146;font-weight: bold">笔记本:  ' . $notebook->notebook_name . '</div>');
        $pdf->writeHTML('<div style="text-align: left;color: #2A8146;font-weight: bold">相关标签:  ' . $tagStr . '</div>');
        $pdf->writeHTML('<div style="text-align: left;color: #2A8146;font-weight: bold">创建时间:  ' . $note->created_at . '</div>');
        $pdf->writeHTML('<hr style="padding-top: 20px;padding-bottom: 20px">');
        $pdf->writeHTML($note->content);

        //输出PDF
        $res = $pdf->Output('/Users/keenan/Documents/workspace/KNote/KNote-Server/t.pdf', 'F');//I输出、D下载
        return response()->file('/Users/keenan/Documents/workspace/KNote/KNote-Server/t.pdf');
    }
}