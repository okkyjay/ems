<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\Auth\AuthController;
use App\Http\Controllers\Api\V1\Employee\Auth\AuthController as EmployeeAuthController;
use App\Http\Controllers\Api\V1\Admin\Employee\EmployeeAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Complaint\ComplaintAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Country\CountryAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Department\DepartmentAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Designation\DesignationAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Holiday\HolidayAdminApiController;
use App\Http\Controllers\Api\V1\Admin\LeaveType\LeaveTypeAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Leave\LeaveAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Notification\NotificationAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Payroll\PayrollAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Permission\PermissionAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Role\RoleAdminApiController;
use App\Http\Controllers\Api\V1\Admin\State\StateAdminApiController;
use App\Http\Controllers\Api\V1\Admin\Todo\TodoAdminApiController;
use App\Http\Controllers\Api\V1\Admin\User\UserAdminApiController;
use App\Http\Controllers\Api\GeneralApiController;
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


Route::group(['prefix' => 'v1/ems', 'as' => 'api.'], function () {

    Route::post('upload-media-file', [GeneralApiController::class, 'fileUploadMethod']);
    Route::get('country-list', [GeneralApiController::class, 'countryList']);
    Route::get('state-list', [GeneralApiController::class, 'stateList']);
    Route::get('leave-type-list', [GeneralApiController::class, 'leaveTypeList']);

    Route::group(['prefix' => 'admin'], function (){
        Route::post('login', [AuthController::class, 'login'])->name('admin.login');
        Route::group(['middleware' => ['auth:admin']], function() {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
            Route::apiResource("employees", EmployeeAdminApiController::class);
            Route::apiResource("complaints", ComplaintAdminApiController::class);
            Route::apiResource("countries", CountryAdminApiController::class);
            Route::apiResource("departments", DepartmentAdminApiController::class);
            Route::apiResource("designations", DesignationAdminApiController::class);
            Route::apiResource("holidays", HolidayAdminApiController::class);
            Route::apiResource("leave-types", LeaveTypeAdminApiController::class);
            Route::apiResource("leaves", LeaveAdminApiController::class);
            Route::apiResource("notifications", NotificationAdminApiController::class);
            Route::apiResource("payrolls", PayrollAdminApiController::class);
            Route::apiResource("permissions", PermissionAdminApiController::class);
            Route::apiResource("roles", RoleAdminApiController::class);
            Route::apiResource("states", StateAdminApiController::class);
            Route::apiResource("todos", TodoAdminApiController::class);
            Route::apiResource("users", UserAdminApiController::class);
        });
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::post('login', [EmployeeAuthController::class, 'login']);
        Route::group(['middleware' => ['auth:employee']], function() {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
            Route::apiResource("complaints", App\Http\Controllers\Api\V1\Employee\Complaint\ComplaintController::class);
            Route::apiResource("notifications", App\Http\Controllers\Api\V1\Employee\Notification\NotificationController::class);
            Route::apiResource("todos", App\Http\Controllers\Api\V1\Employee\Todo\TodoController::class);
            Route::apiResource("payrolls", App\Http\Controllers\Api\V1\Employee\Payroll\PayrollController::class);
            Route::apiResource("leaves", App\Http\Controllers\Api\V1\Employee\Leave\LeaveController::class);
            Route::apiResource("holidays", App\Http\Controllers\Api\V1\Employee\Holiday\HolidayController::class);

            Route::get("messages", [App\Http\Controllers\Api\V1\Employee\Message\MessageController::class, 'index']);
            Route::get("message-conversations", [App\Http\Controllers\Api\V1\Employee\Message\MessageController::class, 'conversations']);

            Route::post("messages", [App\Http\Controllers\Api\V1\Employee\Message\MessageController::class, 'newMessage']);
            Route::post("message-conversations", [App\Http\Controllers\Api\V1\Employee\Message\MessageController::class, 'newConversation']);
        });
    });
});

