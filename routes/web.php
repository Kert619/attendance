<?php

use App\Http\Controllers\AdminReports;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainorAttendance;
use App\Http\Controllers\TrainorController;
use App\Http\Controllers\TrainorDashboard;
use App\Http\Controllers\TrainorStudents;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    if (Session::has('isAdmin')) {
        if (Session::get('isAdmin') == true) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('trainor.dashboard');
        }
    }

    return view('auth.login');
});

Route::post('/', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::prefix(('trainor'))->middleware('isTrainor')->group(function () {
    Route::get('/students', [TrainorStudents::class, 'index'])->name('trainor.students.index');
    Route::get('/students/create', [TrainorStudents::class, 'create'])->name('trainor.students.create');
    Route::post('/students/create', [TrainorStudents::class, 'store'])->name('trainor.students.store');
    Route::delete('/students/{id}', [TrainorStudents::class, 'destroy'])->name('trainor.students.destroy');
    Route::put('/students/mark-as-accepted/{id}', [TrainorStudents::class, 'markAsAccepted'])->name('trainor.students.accepted');
    Route::get('/students/view-student/{id}', [TrainorStudents::class, 'viewStudent'])->name('trainor.students.view-student');
    Route::get('/students/edit/{id}', [TrainorStudents::class, 'show'])->name('trainor.students.show');
    Route::put('/students/edit/{id}', [TrainorStudents::class, 'update'])->name('trainor.students.update');
    Route::delete('/students/reject/{id}', [TrainorStudents::class, 'reject'])->name('trainor.students.reject');
    Route::put('students/change-profile/{id}', [TrainorStudents::class, 'changeProfile'])->name('trainor.students.change-profile');

    Route::get('/dashboard', [TrainorDashboard::class, 'index'])->name('trainor.dashboard');

    Route::get('/students/qrcode{id}', [QrCodeController::class, 'download'])->name('trainor.students.qrcode');

    Route::get('/time-report', [TrainorAttendance::class, 'index'])->name('trainor.reports.index');
    Route::get('/attendance-report', [TrainorAttendance::class, 'monthlyReport'])->name('trainor.reports.monthly');
    Route::get('/reports/download', [TrainorAttendance::class, 'exportPdf'])->name('trainor.reports.download');

    Route::post('/students/import', [ImportController::class, 'import'])->name('trainor.students.import');

    Route::get('user/change-profile', [UserController::class, 'showChangeUserProfile'])->name('trainor.user.show-change-profile');
    Route::put('user/change-profile/{id}', [UserController::class, 'changeUserProfile'])->name('trainor.user.change-profile');
});

Route::prefix('admin')->middleware('isAdmin')->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('admin.courses.create');
    Route::post('/courses/create', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::get('/courses/edit/{id}', [CourseController::class, 'show'])->name('admin.courses.show');
    Route::put('/courses/edit/{id}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');

    Route::get('/trainors', [TrainorController::class, 'index'])->name('admin.trainors.index');
    Route::get('/trainors/create', [TrainorController::class, 'create'])->name('admin.trainors.create');
    Route::post('/trainors/create', [TrainorController::class, 'store'])->name('admin.trainors.store');
    Route::get('/trainors/edit/{id}', [TrainorController::class, 'show'])->name('admin.trainors.show');
    Route::put('/trainors/edit/{id}', [TrainorController::class, 'update'])->name('admin.trainors.update');
    Route::delete('/trainors/{id}', [TrainorController::class, 'destroy'])->name('admin.trainors.destroy');

    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students/create', [StudentController::class, 'store'])->name('admin.students.store');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::put('/students/mark-as-accepted/{id}', [StudentController::class, 'markAsAccepted'])->name('admin.students.accepted');
    Route::get('/students/view-student/{id}', [StudentController::class, 'viewStudent'])->name('admin.students.view-student');
    Route::get('/students/edit/{id}', [StudentController::class, 'show'])->name('admin.students.show');
    Route::put('/students/edit/{id}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/students/reject/{id}', [StudentController::class, 'reject'])->name('admin.students.reject');
    Route::put('students/change-profile/{id}', [StudentController::class, 'changeProfile'])->name('admin.students.change-profile');
    Route::post('/students/import', [ImportController::class, 'import'])->name('admin.students.import');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('/users/change-password/{id}', [UserController::class, 'changePassShow'])->name('admin.users.changepassShow');
    Route::put('/users/change-password/{id}', [UserController::class, 'changepass'])->name('admin.users.changepass');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/change-admin-profile', [UserController::class, 'showChangeAdminProfile'])->name('admin.users.show-change-admin-profile');
    Route::post('/users/change-admin-profile', [UserController::class, 'changeAdminProfile'])->name('admin.users.change-profile');

    Route::get('/students/qrcode{id}', [QrCodeController::class, 'download'])->name('admin.students.qrcode');

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance');
    Route::post('/attendance', [AttendanceController::class, 'scan'])->name('attendance.scan');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/time-report', [AdminReports::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/download', [AdminReports::class, 'exportPdf'])->name('admin.reports.download');

    Route::get('/attendance-report', [AdminReports::class, 'monthlyReport'])->name('admin.reports.monthly');
});
