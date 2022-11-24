<?php

use App\Http\Controllers\API\ProblemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/** Problem-Solving routes */
Route::get('problem/1', [ProblemController::class, 'problem_1']);
Route::get('problem/2', [ProblemController::class, 'problem_2']);
Route::post('problem/3', [ProblemController::class, 'problem_3']);

/** Auth routes */
Route::post('register', [Auth\RegisterController::class, 'register']);
Route::post('login', [Auth\LoginController::class, 'login']);
Route::post('forgot-password', [Auth\LoginController::class, 'forgotPassword']);
Route::post('reset-password', [Auth\LoginController::class, 'resetPassword'])->name('password.reset');


Route::resource('user', UserController::class)->except([
    'create', 'store', 'edit'
]);;