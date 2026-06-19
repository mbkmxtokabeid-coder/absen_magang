<?php
header("Access-Control-Allow-Origin: *");

use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Profile Route
Route::get('/user/profile', [ProfileController::class, 'index'])->name('profile.show');
Route::get('/user/profile/setting', [ProfileController::class, 'setting'])->name('profile.setting');
Route::post('/user/profile/store', [ProfileController::class, 'store'])->name('profile.save');
Route::post('/user/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/user/profile/changepass', [ProfileController::class, 'changePass'])->name('user.changepass');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
  if (Route::has('login') && Auth::user()->role == 1) {
    return redirect('/attendence');
  } else if (Route::has('login') && Auth::user()->role == 0) {
    return view('admin/dashboard');
  }
  else{
    return view('auth/login');
  }
})->name('dashboard');

Route::get('/teams', function () {
    // dd(Auth::user() == null ? true : false);
  return view('teams');
})->name('teams');

Route::group(['middleware' => 'App\Http\Middleware\Admin'], function () {
  // User Route
  Route::get('/users', [UserController::class, 'index'])->name('admin.users');
  Route::get('/users/{userName}/{userId}', [UserController::class, 'show']);
  Route::get('/users/add', [UserController::class, 'add']);
  Route::post('/users/store', [UserController::class, 'register']);
  Route::get('/users/edit/{userId}', [UserController::class, 'edit']);
  Route::put('/user/{userId}', [UserController::class, 'storeEdit']);
  Route::delete('/user/{userId}', [UserController::class, 'destroy']);

  // Campus
  Route::get('/campus', [CampusController::class, 'indexAdmin'])->name('admin.campus');
  Route::get('/campus/add', [CampusController::class, 'add']);
  Route::post('/campus/store', [CampusController::class, 'store']);
  Route::get('/campus/edit/{id}', [CampusController::class, 'edit']);
  Route::put('/campus/update/{id}', [CampusController::class, 'update']);
  Route::delete('/campus/{id}', [CampusController::class, 'destroy']);


  Route::get('/supervisors', [SupervisorController::class, 'indexAdmin'])->name('admin.supervisors');
  Route::get('/supervisors/add', [SupervisorController::class, 'add']);

  // Attendence (Admin)
  Route::get('/attendences', [AttendenceController::class, 'indexAdmin'])->name('admin.attendence');
});

Route::group(['middleware' => 'App\Http\Middleware\User'], function () {
  // logbook
  Route::get('/logbook', [LogbookController::class, 'index'])->name('user.logbook');
  Route::get('/logbook/add', [LogbookController::class, 'add'])->name('user.logbook.add');
  Route::post('/logboot/store', [LogbookController::class, 'store'])->name('user.logbook.store');
  Route::get('/logbook/edit/{id}', [LogbookController::class, 'edit'])->name('user.logbook.edit');
  Route::put('/logbook/update', [LogbookController::class, 'update'])->name('user.logbook.update');

  //Attendence (User)
  Route::get('/attendence', [AttendenceController::class, 'index'])->name('user.attendence');
  Route::post('/attendence', [AttendenceController::class, 'store'])->name('user.attendence.store');
});
