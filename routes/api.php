<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/signup', [UserController::class, 'create_user'])->name('create.user');
Route::post('/signin', [UserController::class, 'login_user'])->name('login.user');

Route::prefix('auth')->group(function(){
    // Route::delete('/signin/delete/', [UserController::class, 'userLogOut'])->middleware('jwt');
    Route::get('/user', [UserController::class, 'getUser'])->middleware('jwt');
});
Route::fallback(function (){
    return response()->json(['error' => 'endpoint não encontrado'], 404);
});