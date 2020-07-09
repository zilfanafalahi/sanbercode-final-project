<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/template', function () {
    return view('adminlte.master');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Route CRUD
Route::resource('answers', 'AnswerController');
Route::post('answers/{id}', 'AnswerController@store');
Route::get('/questions/{id}/comments', 'CommentController@show_question');
Route::post('/questions/{id}/comments', 'CommentController@store_question');
Route::get('/answers/{q_id}/{id}/comments', 'CommentController@show_answer');
Route::post('/answers/{q_id}/{id}/comments', 'CommentController@store_answer');
Route::resource('questions', 'QuestionController');
Route::resource('reputations', 'ReputationController');
Route::resource('votes', 'VoteController');
