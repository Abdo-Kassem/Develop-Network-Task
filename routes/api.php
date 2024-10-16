<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\TagController;
use App\Jobs\FetchRandomUser;
use App\Jobs\ForceDeleteOldSoftDeletedPosts;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('test', function() {
    dispatch(new FetchRandomUser());
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/verify', 'verify');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tags', TagController::class);

    Route::get('posts/soft-deleted-posts', [PostController::class, 'softDeletedPosts']);
    Route::patch('posts/restore-post/{id}', [PostController::class, 'restoreSoftDeletedPost']);
    Route::apiResource('posts', PostController::class);
    
});

Route::get('/stats', [StatController::class, 'index']);
