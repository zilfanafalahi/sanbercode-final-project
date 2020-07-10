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
    return redirect()->route('login');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Route CRUD
Route::group(['middleware' => 'auth'], function(){  
    Route::get('answers/{id}', 'AnswerController@show');
    Route::post('answers/{id}', 'AnswerController@store');
    Route::get('answers/{q_id}/{id}/edit', 'AnswerController@edit');
    Route::put('answers/{q_id}/{id}', 'AnswerController@update');
    Route::delete('answers/{q_id}/{id}', 'AnswerController@destroy');
    Route::post('answers/{id}', 'AnswerController@store');
    Route::get('/questions/{id}/comments', 'CommentController@show_question');
    Route::post('/questions/{id}/comments', 'CommentController@store_question');
    Route::get('/answers/{q_id}/{id}/comments', 'CommentController@show_answer');
    Route::post('/answers/{q_id}/{id}/comments', 'CommentController@store_answer');
    Route::get('/questions/{q_id}/comments/{id}/edit', 'CommentController@edit_question');
    Route::put('/questions/{q_id}/comments/{id}', 'CommentController@update_question');
    Route::delete('/questions/{q_id}/comments/{id}', 'CommentController@destroy_question');
    Route::get('/answers/{q_id}/{a_id}/comments/{id}/edit', 'CommentController@edit_answer');
    Route::put('/answers/{q_id}/{a_id}/comments/{id}', 'CommentController@update_answer');
    Route::delete('/answers/{q_id}/{a_id}/comments/{id}', 'CommentController@destroy_answer');
    Route::resource('questions', 'QuestionController');
    Route::resource('reputations', 'ReputationController');
    Route::resource('votes', 'VoteController');
});