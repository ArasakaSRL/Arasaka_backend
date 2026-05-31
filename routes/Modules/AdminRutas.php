<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/admin')->group(function () {
    Route::get('/users', [AdminController::class, 'indexAllUsuarios'])->name('users.index');
});

