<?php
if (php_sapi_name() !== 'cli') {
    header("Access-Control-Allow-Origin: *");
}

use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\AttendencePermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\JobdeskController;
use App\Http\Controllers\JurusanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
//Sertifikat
Route::get('upload-images', [ ImageController::class, 'index' ]);
Route::post('upload-images', [ ImageController::class, 'storeImage' ])->name('images.store');

Route::get('/', function () {
  return view('welcome');
});
// Public / Guest Area
Route::get('/api/get', [AttendenceController::class, 'getApi']);

// Forgot Password
Route::get('/forgot-password', function () {
  return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
  $request->validate(['email' => 'required|email']);

  $status = Password::sendResetLink(
    $request->only('email')
  );

  return $status === Password::RESET_LINK_SENT
    ? back()->with(['status' => __($status)])
    : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// IT Teams Page
Route::get('/teams', function () {
  return view('teams');
})->name('teams');

// Root Area
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
  if (Route::has('login') && Auth::user()->role == 1) {
    return redirect('/attendence');
  } else if (Route::has('login') && Auth::user()->role == 0) {
    return redirect('/dashboard');
  } else if (Route::has('login') && Auth::user()->role == 2) {
    return redirect('/index');
  } else {
    return view('auth/login');
  }
})->name('dashboard');


// Profile Route (Auth == True)
Route::group(['middleware' => 'App\Http\Middleware\Profile'], function () {
  Route::get('/user/profile', [ProfileController::class, 'index'])->name('profile.show');
  Route::post('/user/profile/log-photoes', [ProfileController::class, 'logPhotoes'])->name('profile.logphotoes');
  Route::get('/user/profile/setting', [ProfileController::class, 'setting'])->name('profile.setting');
  Route::post('/user/profile/store', [ProfileController::class, 'store'])->name('profile.save');
  Route::post('/user/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
  Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('/user/profile/changepass', [ProfileController::class, 'changePass'])->name('user.changepass');
});

// Admin Area
Route::group(['middleware' => 'App\Http\Middleware\Admin'], function () {
  // Dashboard Route
  Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

  // Assesment
  Route::get('/assessment', [AdminController::class, 'indexAssessment'])->name('admin.assessments');
  Route::get('/users/{userName}/{userId}/assessment', [AssessmentController::class, 'index']);
  Route::get('/users/{userName}/{userId}/assessment/add', [AssessmentController::class, 'add']);
  Route::post('/users/{userName}/{userId}/assessment/store', [AssessmentController::class, 'store'])->name('admin.assesment.save');

  // User Jobdesk
  Route::get('/users/jobdesk/{userId}', [JobdeskController::class, 'indexAdmin']);
  Route::get('/jobdesk/add/{userId}', [JobdeskController::class, 'add']);
  Route::get('/jobdesk/delete/{id}', [JobdeskController::class, 'delete'])->name('admin.jobdesk.delete');
  Route::post('/jobdesk/store', [JobdeskController::class, 'store'])->name('admin.jobdesk.store');
  Route::get('/jobdesk/edit/{userId}', [JobdeskController::class, 'edit'])->name('admin.jobdesk.edit');

  
  // User Route
  Route::get('/users', [AdminController::class, 'indexUser'])->name('admin.users');
  Route::get('/userselesai', [AdminController::class, 'indexUserSelesai'])->name('admin.userselesai');
  Route::get('/users/add', [UserController::class, 'add']);
  Route::get('/users/edit/{userId}', [UserController::class, 'edit']);
  Route::get('/users/{userName}/{userId}', [UserController::class, 'show']);
  Route::put('/users/editstatus/{userId}', [UserController::class, 'editstatus'])->name('admin.editstatus');
  Route::post('/users/store', [UserController::class, 'register']);
  Route::put('/user/{userId}', [UserController::class, 'storeEdit']);
  Route::delete('/user/{userId}', [UserController::class, 'destroy']);

  // Campus
  Route::get('/campus', [AdminController::class, 'indexCampus'])->name('admin.campus');
  Route::get('/campus/add', [CampusController::class, 'add']);
  Route::post('/campus/store', [CampusController::class, 'store']);
  Route::get('/campus/edit/{id}', [CampusController::class, 'edit']);
  Route::put('/campus/update/{id}', [CampusController::class, 'update']);
  Route::delete('/campus/{id}', [CampusController::class, 'destroy']);

  // Supervisor
  Route::get('/supervisors', [AdminController::class, 'indexSupervisor'])->name('admin.supervisors');
  Route::get('/supervisors/add', [SupervisorController::class, 'add']);
  Route::post('/supervisors/store', [SupervisorController::class, 'store']);
  Route::get('/supervisors/edit/{id}', [SupervisorController::class, 'edit']);
  Route::put('/supervisors/update/{id}', [SupervisorController::class, 'update']);
  Route::delete('/supervisors/{userId}', [SupervisorController::class, 'destroy']);

  //Instruktur
  Route::get('/instruktur', [AdminController::class, 'indexInstruktur'])->name('admin.instruktur');
  Route::get('/instruktur/add', [InstrukturController::class, 'add']);
  Route::post('/instruktur/store', [InstrukturController::class, 'store']);
  Route::get('/instruktur/edit/{id}', [InstrukturController::class, 'edit']);
  Route::put('/instruktur/update/{id}', [InstrukturController::class, 'update']);
  Route::delete('/instruktur/{userId}', [InstrukturController::class, 'destroy']);

  //Jurusan
  Route::get('/jurusan', [JurusanController::class, 'index'])->name('admin.jurusan');
  Route::get('/jurusan-add', [JurusanController::class, 'create'])->name('addJurusan');
  Route::post('/jurusan-save', [JurusanController::class, 'store'])->name('saveJurusan');
  Route::get('/jurusan-edit', [JurusanController::class, 'show'])->name('editJurusan');
  Route::put('/jurusan-update/{id}', [JurusanController::class, 'update'])->name('updateJurusan');
  Route::delete('/jurusan-delete/{id}', [JurusanController::class, 'destroy'])->name('deleteJurusan');

  // Attendence (Admin)
  Route::get('/attendences', [AdminController::class, 'indexAttendence'])->name('admin.attendence');

  // Attendence Permission (Admin)
  Route::get('/attendences/permissions', [AdminController::class, 'indexAttendencePermission'])->name('admin.attendence.permission');

  // Maintenance route
  Route::get('/sites/maintenance', function (){
    return Artisan::call('down');
  });
  Route::get('/sites/normal', function (){
    return Artisan::call('up');
  });
  Route::get('/sites/clear/cache', function(){
    return Artisan::call('cache:clear');
  });
  Route::get('/sites/clear/route', function(){
    return Artisan::call('route:clear');
  });
  Route::get('/sites/clear/config', function(){
    return Artisan::call('config:clear');
  });
  Route::get('/sites/clear/view', function() {
    return Artisan::call('view:clear');
  });
});

// User Area
Route::group(['middleware' => 'App\Http\Middleware\User'], function () {
  // logbook
  Route::get('/logbook', [LogbookController::class, 'index'])->name('user.logbook');
  Route::get('/logbook/add', [LogbookController::class, 'add'])->name('user.logbook.add');
  Route::post('/logboot/store', [LogbookController::class, 'store'])->name('user.logbook.store');
  Route::get('/logbook/edit/{id}', [LogbookController::class, 'edit'])->name('user.logbook.edit');
  Route::post('/logbook/update', [LogbookController::class, 'update'])->name('user.logbook.update');

  // jobdesk
  Route::get('/jobdesk', [JobdeskController::class, 'index'])->name('user.jobdesk');
  
  //Attendence (User)
  Route::get('/attendence', [AttendenceController::class, 'index'])->name('user.attendence');
  Route::post('/attendence', [AttendenceController::class, 'store'])->name('user.attendence.store');

  //Attendence Permission Request (User)
  Route::get('/attendence/permission', [AttendencePermissionController::class, 'index'])->name('user.attendence.permissions');
  Route::get('/attendence/permission/add', [AttendencePermissionController::class, 'add'])->name('user.attendence.permissions.add');
});

// Supervisor Area
Route::group(['middleware' => 'App\Http\Middleware\Supervisor'], function () {
  Route::get('/index', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
  Route::get('/apprentices', [SupervisorController::class, 'usersIndex'])->name('supervisor.users');
  Route::get('/apprentices/attendences', [SupervisorController::class, 'indexAttendence'])->name('supervisor.attendences');
  Route::get('/apprentices/{userName}/{userId}', [UserController::class, 'show']);
  Route::post('/apprentices/log-photoes', [ProfileController::class, 'logPhotoes'])->name('supervisor.logphotoes');
  Route::get('/supervisor/profile', [SupervisorController::class, 'profile'])->name('supervisor.profile');
  Route::get('/apprentices/{usernName}/{userId}/jobdesk', [UserController::class, 'superjobdesk']);
  Route::post('/aprentices/tambah/', [UserController::class, 'superaddJobDesk'])->name('supervisor.jobdesk.tambah');
});

// Serve storage files dynamically (for Hostinger environment without symlink)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    $mimeType = mime_content_type($filePath);
    return response()->file($filePath, ['Content-Type' => $mimeType]);
})->where('path', '.*');
