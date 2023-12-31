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
});

// Route::group(['prefix' => 'admin'], function () {
//   Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
//   Route::post('/login', 'Admin\Auth\LoginController@login');
//   Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('logout');

//   Route::get('/register', 'Admin\Auth\RegisterController@showRegistrationForm')->name('register');
//   Route::post('/register', 'Admin\Auth\RegisterController@register');

//   Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
//   Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.email');
//   Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
//   Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
// });

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
  Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

  // Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
  // Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm']);
  
  Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'home'])->name('home');

  Route::get('/categories', [App\Http\Controllers\Admin\HomeController::class, 'categories'])->name('categories');
  Route::post('/addCategory', [App\Http\Controllers\Admin\HomeController::class,'addCategory'])->name('admin.addCategory');
  Route::post('/updateCategory', [App\Http\Controllers\Admin\HomeController::class,'updateCategory'])->name('admin.updateCategory');
  Route::post('/deleteCategory', [App\Http\Controllers\Admin\HomeController::class,'deleteCategory'])->name('admin.deleteCategory');


Route::get('/blogposts', [App\Http\Controllers\Admin\HomeController::class,'blogposts'])->name('admin.blogposts');
  Route::post('/addPost', [App\Http\Controllers\Admin\HomeController::class,'addPost'])->name('admin.addPost');
  Route::post('/updatePost', [App\Http\Controllers\Admin\HomeController::class,'updatePost'])->name('admin.updatePost');
  Route::post('/deletePost', [App\Http\Controllers\Admin\HomeController::class,'deletePost'])->name('admin.deletePost');

  Route::get('/breakingnews', [App\Http\Controllers\Admin\HomeController::class, 'breakingnews'])->name('breakingnews');
  Route::post('/addbreakingNews', [App\Http\Controllers\Admin\HomeController::class, 'addbreakingNews'])->name('addbreakingNews');


  Route::get('/newsletters', [App\Http\Controllers\Admin\HomeController::class, 'newsletters'])->name('newsletters');


  Route::get('/users', [App\Http\Controllers\Admin\HomeController::class, 'users'])->name('users');

  

});





// Route::group(['prefix' => 'user'], function () {
//   Route::get('/login', 'User\Auth\LoginController@showLoginForm')->name('login');
//   Route::post('/login', 'User\Auth\LoginController@login');
//   Route::post('/logout', 'User\Auth\LoginController@logout')->name('logout');

//   Route::get('/register', 'User\Auth\RegisterController@showRegistrationForm')->name('register');
//   Route::post('/register', 'User\Auth\RegisterController@register');

//   Route::post('/password/email', 'User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
//   Route::post('/password/reset', 'User\Auth\ResetPasswordController@reset')->name('password.email');
//   Route::get('/password/reset', 'User\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
//   Route::get('/password/reset/{token}', 'User\Auth\ResetPasswordController@showResetForm');
// });



Route::group(['prefix' => 'user'], function () {
  Route::get('/', [App\Http\Controllers\User\Auth\LoginController::class, 'showLoginForm'])->name('user.login');
  Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\User\Auth\LoginController::class, 'logout'])->name('logout');

  Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
  Route::post('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\User\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\User\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\User\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\User\Auth\ResetPasswordController::class, 'showResetForm']);
  
  Route::get('/home', [App\Http\Controllers\User\UserController::class, 'index'])->name('home')->middleware(['auth:user']);

});