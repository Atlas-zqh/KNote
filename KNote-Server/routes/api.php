<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers'], function ($api) {
        $api->post('user/login', 'AuthController@authenticate');
        $api->post('user/register', 'AuthController@register');
        $api->group(['middleware' => 'jwt.auth'], function ($api) {
            $api->get('user/me', 'AuthController@getAuthenticatedUser');

            $api->post('note/modifyPermission', 'NoteController@modifyNotePermission');

            $api->get('notebooks/getNotes', 'NotebookController@getNotesInNotebook');
        });

        $api->get('notebooks', 'NotebookController@getNotebooks');
        $api->post('notebooks/modify', 'NotebookController@modifyNotebooks');
        $api->post('notebooks/add', 'NotebookController@addNotebook');
        $api->get('notebooks/delete', 'NotebookController@deleteNotebook');


        $api->get('note/tag', 'NoteController@getTagByNote');
        $api->get('note/getNotes', 'NoteController@getAllValidNotesByUser');
        $api->get('note/detail', 'NoteController@getNoteDetail');
        $api->get('note/delete', 'NoteController@deleteNote');
        $api->post('note/modify', 'NoteController@modifyNoteContent');
        $api->post('note/add', 'NoteController@addNote');
        $api->get('note/like', 'NoteController@likeNote');
        $api->get('note/unlike', 'NoteController@cancelLike');
        $api->get('note/isLikingNote', 'NoteController@isLikingNote');


        $api->get('note/deleteTagRelation', 'NoteController@deleteTag');
        $api->get('note/addTagRelation', 'NoteController@addTag');


        $api->get('workbench', 'NotebookController@getNotebooksAndNotes');

        $api->post('user/modifyInfo', 'AuthController@modifyUserInfo');
        $api->post('user/modifyPassword', 'AuthController@modifyPassword');
        $api->get('user/frequentTags', 'UserController@getFrequentTags');


        $api->get('user/hotNotes', 'UserController@getHotNotes');
        $api->get('user/userInfo', 'UserController@getUserInfo');
        $api->get('user/follow', 'FollowController@follow');
        $api->get('user/isFollowing', 'FollowController@isFollowing');
        $api->get('user/unFollow', 'FollowController@unFollow');
        $api->get('user/followers', 'UserController@getFollowers');
        $api->get('user/following', 'UserController@getFollowing');

    });
});
