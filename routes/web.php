<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;

Route::get('/', fn  () =>view('welcome'));

Route::get('/register',[RegisteredUserController::class,'create']);



