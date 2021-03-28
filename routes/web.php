<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RentController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class, 'login'])->name('login');
Route::post('/sign-in',[AuthController::class, 'signIn'])->name('signin');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('admin');

Route::group(['prefix'=>'/customer', 'middleware'=>'admin'], function(){
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::post('/destroy', [CustomerController::class, 'destroy'])->name('customer.destroy');
});

Route::group(['prefix'=>'/driver', 'middleware'=>'admin'], function(){
    Route::get('/', [DriverController::class, 'index'])->name('driver.index');
    Route::post('/store', [DriverController::class, 'store'])->name('driver.store');
    Route::post('/update', [DriverController::class, 'update'])->name('driver.update');
    Route::post('/destroy', [DriverController::class, 'destroy'])->name('driver.destroy');
});

Route::group(['prefix'=>'/owner', 'middleware'=>'admin'], function(){
    Route::get('/', [OwnerController::class, 'index'])->name('owner.index');
    Route::post('/store', [OwnerController::class, 'store'])->name('owner.store');
    Route::post('/update', [OwnerController::class, 'update'])->name('owner.update');
    Route::post('/destroy', [OwnerController::class, 'destroy'])->name('owner.destroy');
});

Route::group(['prefix'=>'/rent', 'middleware'=>'admin'], function(){
    Route::get('/', [RentController::class, 'index'])->name('rent.index');
    Route::get('/create', [RentController::class, 'create'])->name('rent.create');
    Route::post('/store', [RentController::class, 'store'])->name('rent.store');
    Route::get('/edit/{id}', [RentController::class, 'edit'])->name('rent.edit');
    Route::post('/update/{id}', [RentController::class, 'update'])->name('rent.update');
    Route::post('/destroy', [RentController::class, 'destroy'])->name('rent.destroy');
});