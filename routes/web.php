<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\BasicWorktimeController;
use App\Http\Controllers\TodayDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
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
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->controller(ManagerController::class)->group(function(){
    Route::get('/manager', 'manager')->name('mg.dashboard');
    Route::get('/manager/setting', 'setting')->name('mg.membersetting');
    Route::post('/manager/setting', 'regester_member')->name('mg.regester');
    Route::get('/manager/member/{user}', 'memberinfo')->name('mg.memberinfo');
});

Route::middleware('auth')->controller(BasicWorktimeController::class)->group(function(){
    Route::get('/basicSetting', 'show_setting')->name('bsSet.show');
    Route::post('/basicSetting', 'store_setting')->name('bsSet.store');
});

Route::middleware('auth')->controller(TodayDataController::class)->group(function(){
    Route::get('/todaydata', 'save_todaydata')->name('today.save');
});

require __DIR__.'/auth.php';
