<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReminderController;
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
