<?php
use Src\Route;

Route::add('GET', '/', [Controller\ApiController::class, 'index']);
Route::add('POST', '/echo', [Controller\ApiController::class, 'echo']);
Route::add('POST', '/login', [Controller\ApiController::class, 'login']);
Route::add('GET', '/workers', [Controller\ApiController::class, 'workers'])->middleware('bearer');
