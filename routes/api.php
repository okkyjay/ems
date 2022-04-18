<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\Auth\AuthController;
use App\Http\Controllers\Api\V1\Employee\Auth\AuthController as EmployeeAuthController;
use App\Http\Controllers\Api\V1\Admin\Employee\EmployeeAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Complaint\ComplaintAdminApiController;
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


Route::group(['prefix' => 'v1/ems/admin', 'as' => 'api.'], function () {

    Route::post('login', [AuthController::class, 'login'])->name('admin.login');

    Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::apiResource("employees", EmployeeAdminApiController::class);
        Route::apiResource("complaints", ComplaintAdminApiController::class);
    });
});


Route::group(['prefix' => 'v1/ems/employee', 'as' => 'api.'], function () {

    Route::post('login', [EmployeeAuthController::class, 'login']);

    Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
