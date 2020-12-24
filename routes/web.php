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

// Dashboard danh mục
Route::get('categories', [HomeController::class, 'categories'])->name('categories');

// Thêm mới danh mục
Route::post('/admin/addcategory-process', [HomeController::class, 'addCategory']);

// List bài viết
Route::post('/admin/getposts', [HomeController::class, 'getPosts'])->name('getposts');

// List danh mục
Route::post('/admin/getcategories', [HomeController::class, 'getCategories'])->name('getcategories');

// Dashboard bài viết
Route::get('posts', [HomeController::class, 'posts'])->name('posts');

// List bài viết
Route::post('/admin/getposts', [HomeController::class, 'getPosts'])->name('getposts');

// Thêm mới bài viết
Route::post('/admin/addpost-process', [HomeController::class, 'addPost']);

// Xóa bài biết
Route::get('/delete-post/{id}', [HomeController::class, 'deletePost'])->name('delete-post');

// Xem chi tiết bài viết
Route::get('/post/{slug}', [HomeController::class, 'viewPost'])->name('view-post');

// Load thông tin bài viết lên modal cập nhật bài viết
Route::get('/admin/getpost-process/{id}', [HomeController::class, 'getPostUpdate'])->name('get-post-update');

// Cập nhật bài viết
Route::post('/admin/updatepost-process', [HomeController::class, 'updatePost']);