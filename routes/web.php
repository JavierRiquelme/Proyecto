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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('blog', 'front\BlogController');
Route::get('frontblog/blog/about', 'front\BlogController@about')->name('about');
Route::get('frontblog/blog/contact', 'front\BlogController@contact')->name('contact');
Route::get('frontblog/blog/categories', 'front\BlogController@categories')->name('categories');
Route::get('frontblog/blog/post/{clase}', 'front\BlogController@post')->name('post');
Route::get('frontblog/blog/post/{category}/category', 'front\BlogController@listClaseCategory')->name('clases-category');

Route::resource('dashboard/contact', 'dashboard\ContactController');

Route::resource('dashboard/post-comment', 'dashboard\PostCommentController')->only(['destroy']);
Route::get('dashboard/post-comment/{clase}/post', 'dashboard\PostCommentController@post')->name('post-comment.post');
Route::get('dashboard/post-comment/j-show/{postComment}', 'dashboard\PostCommentController@jshow');
Route::post('dashboard/post-comment/proccess/{postComment}', 'dashboard\PostCommentController@proccess');

Route::post('frontblog/blog/post/{clase}/comments', 'front\BlogController@createComment')->name('create-comment');

Route::get('dashboard/clase/inicio', 'dashboard\ClaseController@inicio')->name('inicio');

Route::match(['get', 'post'], 'calendario/index_calendario', 'dashboard\ClaseController@indexCalendario')->name('inicio-calendario');
Route::post('calendario/index_calendario', 'dashboard\ClaseController@storeCalendario')->name('store-calendario');
Route::get('calendario/show_calendario', 'dashboard\ClaseController@showCalendario')->name('show-calendario');
Route::put('calendario/index_calendario/{clase}', 'dashboard\ClaseController@updateCalendario')->name('update-calendario');
Route::delete('calendario/index_calendario/{clase}', 'dashboard\ClaseController@destroyCalendario')->name('delete-calendario');

Route::resource('dashboard/clase', 'dashboard\ClaseController');

Route::post('dashboard/clase/descripcion_image', 'dashboard\ClaseController@descripcionImage');

Route::resource('dashboard/category', 'dashboard\CategoryController');

Route::resource('dashboard/user', 'dashboard\UserController');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
