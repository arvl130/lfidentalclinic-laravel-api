<?php

use App\Http\Controllers\UserAppointmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDentalChartController;
use App\Http\Controllers\UserFormController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSignatureController;
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

Route::get("/users", [UserController::class, "index"]);
Route::get("/users/search/by-name/{nameFilter}", [UserController::class, "search"]);
Route::get("/users/archived", [UserController::class, "indexArchived"]);
Route::get("/users/archived/search/by-name/{nameFilter}", [UserController::class, "searchArchived"]);

Route::get("/users/{patientUid}", [UserProfileController::class, "show"]);
Route::post("/users/{patientUid}/archived", [UserProfileController::class, "archive"]);
Route::delete("/users/{patientUid}/archived", [UserProfileController::class, "unarchive"]);

Route::get("/users/{patientUid}/appointments", [UserAppointmentController::class, "index"]);
Route::put("/users/{patientUid}/appointments", [UserAppointmentController::class, "store"]);
Route::post(
    "/users/{patientUid}/appointments/{slotSeconds}/payment",
    [UserAppointmentController::class, "updatePayment"]
);
Route::delete(
    "/users/{patientUid}/appointments/{slotSeconds}/cancel",
    [UserAppointmentController::class, "cancel"]
);
Route::delete(
    "/users/{patientUid}/appointments/{slotSeconds}/delete",
    [UserAppointmentController::class, "destroy"]
);
Route::put(
    "/users/{patientUid}/appointments/{slotSeconds}/attended",
    [UserAppointmentController::class, "updateSetAttended"]
);
Route::patch(
    "/users/{patientUid}/appointments/{slotSeconds}/attended",
    [UserAppointmentController::class, "updateSetNotAttended"]
);
Route::delete(
    "/users/{patientUid}/appointments/{slotSeconds}/attended",
    [UserAppointmentController::class, "updateSetPendingAttended"]
);
Route::get(
    "/users/{patientUid}/appointments/{slotSeconds}/procedure",
    [UserAppointmentController::class, "showProcedure"]
);
Route::patch(
    "/users/{patientUid}/appointments/{slotSeconds}/procedure",
    [UserAppointmentController::class, "updateProcedure"]
);
Route::put(
    "/users/{patientUid}/appointments/{slotSeconds}/procedure/access",
    [UserAppointmentController::class, "updateSetProcedureAccessAllowed"]
);
Route::delete(
    "/users/{patientUid}/appointments/{slotSeconds}/procedure/access",
    [UserAppointmentController::class, "updateSetProcedureAccessNotAllowed"]
);
Route::put(
    "/users/{patientUid}/appointments/{slotSeconds}/procedure/request-access",
    [UserAppointmentController::class, "updateRequestProcedureAccess"]
);
Route::delete(
    "/users/{patientUid}/appointments/{slotSeconds}/procedure/request-access",
    [UserAppointmentController::class, "updateCancelRequestProcedureAccess"]
);

Route::get(
    "/users/{patientUid}/signatures/patient",
    [UserSignatureController::class, "showPatient"]
);
Route::patch(
    "/users/{patientUid}/signatures/patient",
    [UserSignatureController::class, "updatePatient"]
);
Route::get(
    "/users/{patientUid}/signatures/guardian",
    [UserSignatureController::class, "showGuardian"]
);
Route::patch(
    "/users/{patientUid}/signatures/guardian",
    [UserSignatureController::class, "updateGuardian"]
);

Route::get(
    "/users/{patientUid}/charts/medical-chart/filled-in",
    [UserDentalChartController::class, "showFilledIn"]
);
Route::post(
    "/users/{patientUid}/charts/medical-chart/filled-in",
    [UserDentalChartController::class, "updateFilledIn"]
);
Route::get(
    "/users/{patientUid}/charts/medical-chart",
    [UserDentalChartController::class, "showMedicalChart"]
);
Route::patch(
    "/users/{patientUid}/charts/medical-chart",
    [UserDentalChartController::class, "updateMedicalChart"]
);
Route::get(
    "/users/{patientUid}/charts/dental-chart",
    [UserDentalChartController::class, "showDentalChart"]
);
Route::patch(
    "/users/{patientUid}/charts/dental-chart",
    [UserDentalChartController::class, "updateDentalChart"]
);
Route::get(
    "/users/{patientUid}/charts/deciduous-chart",
    [UserDentalChartController::class, "showDeciduousChart"]
);
Route::patch(
    "/users/{patientUid}/charts/deciduous-chart",
    [UserDentalChartController::class, "updateDeciduousChart"]
);

Route::get(
    "/users/{patientUid}/forms/consent",
    [UserFormController::class, "showConsentForm"]
);
Route::patch(
    "/users/{patientUid}/forms/consent",
    [UserFormController::class, "updateConsentForm"]
);
Route::get(
    "/users/{patientUid}/forms/assessment",
    [UserFormController::class, "showAssessmentForm"]
);
Route::patch(
    "/users/{patientUid}/forms/assessment",
    [UserFormController::class, "updateAssessmentForm"]
);
