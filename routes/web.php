<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

// Route::get('/', function () {
//     return view('create');
// });
Route::get('/',[PostController::class,'create'])->name('post#home');
Route::get('customer/createPage',[PostController::class,'create'])->name('post#createPage');

Route::post('post/create',[PostController::class,'postCreate'])->name('post#create');

// delete post by get method
Route::get('post/delete{id}',[PostController::class,'postDelete'])->name('post#delete');

//delete post by delete method
// Route::delete()


// update post
Route::get('post/update/{id}',[PostController::class,'postUpdate'])->name('post#update');

//edit post
Route::get('post/edit/{id}',[PostController::class,'postEdit'])->name('post#edit');

Route::post('post/edit/done',[PostController::class,'posteditDone'])->name('post#edit#done');
