<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 03/12/2017
 * Time: 14:51
 */

namespace App\Api\Controllers;


use App\Notebook;
use App\User;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotebookController extends BaseController
{
    /**
     * userId
     * token
     * @param Request $request
     * @return string
     */
    public function getNotebooks(Request $request)
    {

        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            if (strcmp($user->id, $userId) == 0) {
                $notebooks = DB::table('notebooks')->where([
                    ['user_id', $request->userId],
                    ['is_valid', true]
                ])->orderBy('updated_at', 'desc')->get();
                return response()->json($notebooks);
            } else {
                $notebooks = DB::table('notebooks')->where([
                    ['user_id', $request->userId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->orderBy('updated_at', 'desc')->get();
                return response()->json($notebooks);
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
     * notebook_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteNotebook(Request $request)
    {
        $notebook_id = $request->notebookId;

        $notebook = Notebook::find($notebook_id);
        $notebook->is_valid = false;
        $notebook->save();

        // 将笔记本中的笔记也删除
        DB::table('notes')->where('notebook_id', $notebook_id)->update(['is_valid' => false]);

        // 用户的笔记数减
        // 用户笔记本的数量-1
        $user = User::find($notebook->user_id);
        $user->notebooks_count -= 1;
        $user->notes_count -= $notebook->notes_count;
        $user->save();

        return response()->json(['success' => '删除成功']);
    }

    /**
     * notebook_id
     * notebook_name
     * permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyNotebooks(Request $request)
    {
        $notebook_id = $request->notebookId;
        $notebook_name = $request->notebookName;
        $permission = $request->permission;

        $notebook = Notebook::find($notebook_id);
        $notebook->notebook_name = $notebook_name;
        $notebook->permission = $permission;

        $notebook->save();

        return response()->json(['success' => '修改成功']);
    }

    /**
     * user_id
     * notebook_name
     * permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNotebook(Request $request)
    {

        $user_id = $request->userId;
        $notebook_name = $request->notebookName;
        $permission = $request->permission;

        $notebook = new Notebook();
        $notebook->user_id = $user_id;
        $notebook->notebook_name = $notebook_name;
        $notebook->notes_count = 0;
        $notebook->is_valid = true;
        $notebook->permission = $permission;

        $notebook->save();

        // 用户笔记本的数量+1
        $user = User::find($user_id);
        $user->notebooks_count += 1;
        $user->save();

        return response()->json(['success' => '创建成功']);

    }

    public function getNotebooksAndNotes(Request $request)
    {
        $userId = $request->userId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            if ((int)$user->id - (int)$userId == 0) {
                $notebooks = DB::table('notebooks')->where([
                    ['user_id', $userId],
                    ['is_valid', true]
                ])->orderBy('updated_at', 'desc')->get();
                foreach ($notebooks as $notebook) {
                    $notes = DB::table('notes')->
                    select('id', 'title')->where([
                        ['user_id', $userId],
                        ['notebook_id', $notebook->id],
                        ['is_valid', true]
                    ])->orderBy('updated_at', 'desc')->get();
//
                    $notebook->notes = $notes;
                }
                return response()->json($notebooks);

            } else {
                return response()->json(['error' => '您无权限进入其他用户的工作台'], 200);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired']);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'token_absent']);
        }
    }

    public function getNotesInNotebook(Request $request)
    {
        $userId = $request->userId;
        $notebookId = $request->notebookId;

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'user_not_found'], 200);
            }

            $notebook = DB::table('notebooks')->where('id', $notebookId)->first();
            if (strcmp($user->id, $userId) == 0) {
                $notes = DB::table('notes')->where([
                    ['notebook_id', $notebookId],
                    ['is_valid', true]
                ])->orderBy('updated_at', 'desc')->get();
                return response()->json(['userId' => $notebook->user_id,
                    'notebookId' => $notebook->id,
                    'permission' => $notebook->permission,
                    'notebookName' => $notebook->notebook_name,
                    'notesCount' => $notebook->notes_count,
                    'createdAt' => $notebook->created_at,
                    'notes' => $notes]);
            } else {
                $notes = DB::table('notes')->where([
                    ['notebook_id', $notebookId],
                    ['is_valid', true],
                    ['permission', 'public']
                ])->orderBy('updated_at', 'desc')->get();
                return response()->json(['userId' => $notebook->user_id,
                    'notebookId' => $notebook->id,
                    'permission' => $notebook->permission,
                    'notebookName' => $notebook->notebook_name,
                    'notesCount' => $notebook->notes_count,
                    'createdAt' => $notebook->created_at,
                    'notes' => $notes]);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], 200);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'token_absent'], 200);
        }
    }

}