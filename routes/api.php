<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\TimeslotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/messages", [MessageController::class, "index"]);
Route::put("/messages", [MessageController::class, "store"]);
Route::patch("/messages/{uid}", [MessageController::class, "update"]);
Route::delete("/messages/{uid}/delete", [MessageController::class, "destroy"]);

Route::get("/reminders", [ReminderController::class, "show"]);
Route::post("/reminders", [ReminderController::class, "update"]);

Route::get(
    "/appointments/{year}/{month}",
    [AppointmentController::class, "indexYearMonth"]
);
Route::get(
    "/appointments/requesting-procedure-access",
    [AppointmentController::class, "indexRequestingProcedureAccess"]
);

Route::get(
    "/timeslots/appointments",
    [TimeslotController::class, "store"]
);
Route::delete(
    "/timeslots/appointments/{slotSeconds}",
    [TimeslotController::class, "destroy"]
);
Route::get(
    "/timeslots/appointments/closed",
    [TimeslotController::class, "storeClosed"]
);
Route::delete(
    "/timeslots/appointments/closed/{slotSeconds}",
    [TimeslotController::class, "destroyClosed"]
);
Route::get(
    "/timeslots/unavailable/{year}/{month}",
    [TimeslotController::class, "index"]
);

Route::post("/auth/register/admin", [AuthController::class, "registerAdmin"]);
Route::post("/auth/register", [AuthController::class, "registerPatient"]);
Route::post("/auth/login", [AuthController::class, "login"]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get("/auth/user", [AuthController::class, "showProfile"]);
    Route::post("/auth/user/name", [AuthController::class, "updateUsername"]);
    Route::delete("/auth/logout", [AuthController::class, "logout"]);
});
