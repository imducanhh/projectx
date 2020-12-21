<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
//     return view('home');
// });

Route::get('/', [HomeController::class, 'index']);

// Đăng nhập
Route::get('/admin', function () {
	if (Auth::guard('users')->check() == false) {
		return redirect('signin');
	} elseif(Auth::guard('users')->check() == true) {
		return redirect('dashboard');
	}	
});

Route::get('/signin', function() {
	return view('signin');
});

Route::post('/admin/signin-process', [HomeController::class, 'signIn']);


Route::get('/dashboard', function () {
	if (Auth::guard('users')->check() == false) {
		return redirect('signin');
	} elseif(Auth::guard('users')->check() == true) {
		return view('dashboard');
	}
})->name('dashboard');

Route::get('logout', [HomeController::class, 'logOut'])->name('logout');

Route::get('posts', [HomeController::class, 'posts'])->name('posts');

// Thêm mới bài viết
Route::post('/admin/addpost-process', [HomeController::class, 'addPost']);

// List bài viết
Route::post('/admin/getposts', [HomeController::class, 'getPosts'])->name('getposts');

// Xóa bài biết
Route::get('/delete-post/{id}', [HomeController::class, 'deletePost'])->name('delete-post');