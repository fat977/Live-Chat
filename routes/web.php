<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Database\Schema\Grammars\ChangeColumn;
use Illuminate\Routing\Route as RoutingRoute;
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

Route::middleware('auth','verifyUser')->group(function () {
    Route::get('/dashboard',[ChatController::class,'dashboard'])->name('dashboard');
    Route::get('chat/{user_id}',[ChatController::class,'chat'])->name('chat');
    Route::get('/delete/{message_id}',[ChatController::class,'deleteChat'])->name('delete.chat');
    Route::post('send/{receiver_id}',[ChatController::class,'send'])->name('send');
    Route::get('/delete/{message_id}',[ChatController::class,'deleteMessage'])->name('delete.message');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
