<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::post('temp/file', [App\Http\Controllers\Companies\FileController::class,'tempFileUpload'])->name('temp-file-upload');
Route::middleware('auth:api')->group(function () {
    Route::apiResource('companies', 'App\Http\Controllers\Companies\CompanyController');
    Route::apiResource('employees', 'App\Http\Controllers\Employees\EmployeeController');
});
