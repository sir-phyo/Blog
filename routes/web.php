<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/service', 'PagesController@service');

// Route::get('index1', function(){
//   return view('pages.index', ['title' => "abc"]);
// });



Route::get('/hello', function () {
    return "<h1>Hello My Friends</h1>";
});

Route::get('/user/{id}', function ($id) {
    return "This is user ".$id;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/blogs', 'BlogController@index')->name('blogs');

Route::resource('posts','PostsController');
Route::resource('comments','CmtController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('comments', 'CmtController');
