<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AmenitieController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FacilitieController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.pages.home');
});

Route::get('/dashboard', function () {
    return view('backend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/categories',[CategoryController::class, 'index'])->name('category.all');
    // Route::get('/category/new',[CategoryController::class, 'create'])->name('category.new');
    // Route::get('/category/edit/{id}',[CategoryController::class, 'edit'])->name('category.edit');
    // Route::post('/category/delete{id}',[CategoryController::class, 'destroy'])->name('category.delete');

    Route::resource('facilitie',FacilitieController::class);
    Route::resource('bed',BedController::class);
    Route::resource('amenitie',AmenitieController::class);
    Route::resource('room',RoomController::class);
    Route::resource('request',BookingController::class);
    
  
});



//admin login and logout,registration
Route::middleware('guest:admin')->prefix('admin')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Admin\LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Auth\Admin\LoginController::class, 'store']);

    //Route::get('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'create'])->name('admin.register');
    //Route::post('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'store']);

});

Route::middleware('auth:admin')->prefix('admin')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Admin\LoginController::class, 'destroy'])->name('admin.logout');

    Route::view('/dashboard','backend.admin_dashboard');

});


//6th step
//manager login,logout,registration

Route::middleware('guest:manager')->prefix('manager')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Manager\LoginController::class, 'create'])->name('manager.login');
    Route::post('login', [App\Http\Controllers\Auth\Manager\LoginController::class, 'store']);

    //Route::get('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'create'])->name('admin.register');
    //Route::post('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'store']);

});

Route::middleware('auth:manager')->prefix('manager')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Manager\LoginController::class, 'destroy'])->name('manager.logout');

    Route::view('/dashboard','backend.manager_dashboard');

});

Route::post('/amenitie/status-toggle', [AmenitieController::class, 'statusToggle'])
    ->name('amenitie.status.toggle');
    Route::post('/bed/status-toggle', [BedController::class, 'statusToggle'])
    ->name('bed.status.toggle');
    Route::post('/room/status-toggle', [RoomController::class, 'statusToggle'])
    ->name('room.status.toggle');





//frontend
     Route::get('/about', function(){return view('frontend.about');});
     Route::get('/room', function(){return view('frontend.room');});
     Route::get('/pages/home', function(){return view('frontend.pages.home');});

    //frontend
     Route::get('/admin/dashboard', [AdminController::class, 'Admindashboard'])->name('admin.dashboard');
     Route::get('/manager/dashboard', [ManagerController::class, 'ManagerDashboard'])->name('manager.dashboard');
require __DIR__.'/auth.php';
