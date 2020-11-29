<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClockOutFromWorkPlace;
use App\Http\Controllers\GenerateTravelCompensationReport;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewAllAttendances;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware(["auth"])->group(function () {
    Route::resource('users', UserController::class)->except(["show"]);

    Route::get("attendances", ViewAllAttendances::class)->name("attendances.index");

    Route::resource("my-attendances", AttendanceController::class)
        ->parameters(["my_attendance" => "attendance"])
        ->only(["index", "create", "store"]);

    Route::get("my-attendances/{attendance}/check-out", ClockOutFromWorkPlace::class)
        ->name("my-attendances.check-out");

    Route::view("reports", "reports.index")->name("reports.index")
        ->middleware(['can:viewAny,App\Models\Attendance', 'can:viewAny,App\Models\User']);

    Route::get("travel-compensation-report", GenerateTravelCompensationReport::class)
        ->name("reports.travel-compensation");
});
