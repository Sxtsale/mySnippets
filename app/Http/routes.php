<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/github/authorize', function(){
    return SocialAuth::authorize('github');
});
Route::get('/github/logout', ['as' => 'github/logout', 'uses' => 'HomeController@gitHubLogout']);
Route::get('/github/login', ['as' => 'github/login', 'uses' => 'HomeController@gitHubLogin']);

Route::get('/', ['as' => '/', 'uses' => 'HomeController@home']);
Route::get('/store-snippet', ['as' => '/store-snippet', 'uses' => 'SnippetsController@storeSnippet']);
Route::get('/createSnippet', ['as' => '/createSnippet', 'uses' => 'HomeController@createSnippet']);
Route::get('/mySnipet/{snippet_id}/edit', ['as' => 'mySnipet/{snippet_id}/edit', 'uses' => 'SnippetsController@mySnippetEdit']);
Route::get('/update-snippet', ['as' => '/update-snippet', 'uses' => 'SnippetsController@updateSnippet']);
Route::get('/mySnippet/{snippet_id}/delete', ['as' => '/mySnippet/{snippet_id}/delete', 'uses' => 'SnippetsController@deleteSnippet']);

Route::get('/mySnippet/{snippet_id}', ['as' => 'mySnippet/{snippet_id}', 'uses' => 'SnippetsController@mySnippet']);
Route::get('/mySnippet/{snippet_id}/allSnippetRevisions', ['as' => '/mySnippet/{snippet_id}/allSnippetRevisions', 'uses' => 'SnippetsController@allSnippetRevisions']);
Route::get('/mySnippet/{snippet_id}/revision-{revision_id}', ['as' => '/mySnippet/{snippet_id}/revision-{revision_id}', 'uses' => 'SnippetsController@viewSnippetRevision']);


