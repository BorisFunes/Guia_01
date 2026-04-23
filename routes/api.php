<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/my-posts', [PostController::class, 'myPosts']);
        Route::get('/{post}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);

        Route::post('/{post}/tags', [PostController::class, 'updateTags']);
        Route::delete('/{post}/tags', [PostController::class, 'detachTags']);
    });

    Route::prefix('categorias')->group(function () {
        Route::get('/', [CategoriaController::class, 'index']);
        Route::get('/{categoria}', [CategoriaController::class, 'show']);
        Route::post('/', [CategoriaController::class, 'store']);
        Route::put('/{categoria}', [CategoriaController::class, 'update']);
        Route::delete('/{categoria}', [CategoriaController::class, 'destroy']);
    });

    Route::prefix('autores')->group(function () {
        Route::get('/', [AutorController::class, 'index']);
        Route::get('/{autor}', [AutorController::class, 'show']);
        Route::post('/', [AutorController::class, 'store']);
        Route::put('/{autor}', [AutorController::class, 'update']);
        Route::delete('/{autor}', [AutorController::class, 'destroy']);
    });

    Route::prefix('libros')->group(function () {
        Route::get('/', [LibroController::class, 'index']);
        Route::get('/{libro}', [LibroController::class, 'show']);
        Route::post('/', [LibroController::class, 'store']);
        Route::put('/{libro}', [LibroController::class, 'update']);
        Route::delete('/{libro}', [LibroController::class, 'destroy']);
    });

    Route::prefix('prestamos')->group(function () {
        Route::get('/', [PrestamoController::class, 'index']);
        Route::get('/{prestamo}', [PrestamoController::class, 'show']);
        Route::post('/', [PrestamoController::class, 'store']);
        Route::put('/{prestamo}', [PrestamoController::class, 'update']);
        Route::delete('/{prestamo}', [PrestamoController::class, 'destroy']);
    });
});
