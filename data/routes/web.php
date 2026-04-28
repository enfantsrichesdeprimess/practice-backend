<?php
use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'index']);

Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login']);
Route::add('GET', '/logout', [Controller\AuthController::class, 'logout']);
Route::add(['GET', 'POST'], '/admin/register', [Controller\AuthController::class, 'register'])
    ->middleware('auth', 'role:admin');

Route::add('GET', '/workers', [Controller\WorkerController::class, 'index'])->middleware('auth');
Route::add('GET', '/workers/create', [Controller\WorkerController::class, 'create'])->middleware('auth');
Route::add('GET', '/workers/{id}', [Controller\WorkerController::class, 'show'])->middleware('auth');
Route::add('POST', '/workers', [Controller\WorkerController::class, 'store'])->middleware('auth');

Route::add('GET', '/departments', [Controller\DepartmentController::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/departments/create', [Controller\DepartmentController::class, 'create'])->middleware('auth');
Route::add('GET', '/departments/{id}', [Controller\DepartmentController::class, 'show'])->middleware('auth');
Route::add(['GET', 'POST'], '/departments/{id}/attach', [Controller\DepartmentController::class, 'attach'])->middleware('auth');
