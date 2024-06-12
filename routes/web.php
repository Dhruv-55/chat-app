<?php

use App\Http\Controllers\Auth\ChatController;
use App\Http\Controllers\Auth\GroupController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard',[UserController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('chat')->group(function() {
        Route::post('index',[ChatController::class,'index'])->name('chat.index');
        Route::post('insert', [ChatController::class, 'insert'])->name('chat.insert');  
        Route::post('delete', [ChatController::class, 'delete'])->name('chat.delete');  
        
    });


    Route::prefix('group')->group(function(){
        Route::get('index',[GroupController::class,'index'])->name('group.index');
        Route::post('insert', [GroupController::class, 'insert'])->name('group.insert');  
        Route::get('delete', [GroupController::class, 'delete'])->name('group.delete');  
    });
});

require __DIR__.'/auth.php';
