<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HelpDeskController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::post('/register', [EnrollmentController::class, 'register'])->name('register');
Route::put('/admin/students/{student}', [UsersController::class, 'update'])->name('admin.students.update');
Route::patch('admin/users/{user}/toggle-status', [UsersController::class, 'toggleStatus'])->name('admin.users.toggleStatus');

Route::get('/register', [EnrollmentController::class, 'showRegisterForm'])->name('register.form');
Route::get('/', 'HomeController@index')->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/help-desk', [HelpDeskController::class, 'index'])->name('help-desk.index');
    Route::post('/help-desk', [HelpDeskController::class, 'store'])->name('admin.help-desks.store');
    Route::put('admin/help-desks/{id}/status', [HelpDeskController::class, 'updateStatus'])->name('admin.help-desks.updateStatus');
});
Route::get('enroll/login/{course}', 'EnrollmentController@handleLogin')->name('enroll.handleLogin')->middleware('auth');
Route::get('enroll/{course}', 'EnrollmentController@create')->name('enroll.create');
Route::post('enroll/{course}', 'EnrollmentController@store')->name('enroll.store');
Route::get('my-courses', 'EnrollmentController@myCourses')->name('enroll.myCourses')->middleware('auth');
Route::resource('courses', 'CourseController')->only(['index', 'show']);
Route::put('{id}/update-email', [EnrollmentController::class, 'updateEmail'])->name('admin.users.updateEmail');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'blockStudentAdmin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Disciplines
    Route::delete('disciplines/destroy', 'DisciplinesController@massDestroy')->name('disciplines.massDestroy');
    Route::resource('disciplines', 'DisciplinesController');

    // Institutions
    Route::delete('institutions/destroy', 'InstitutionsController@massDestroy')->name('institutions.massDestroy');
    Route::post('institutions/media', 'InstitutionsController@storeMedia')->name('institutions.storeMedia');
    Route::resource('institutions', 'InstitutionsController');

    // Courses
    Route::delete('courses/destroy', 'CoursesController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CoursesController@storeMedia')->name('courses.storeMedia');
    Route::resource('courses', 'CoursesController');

    // Enrollments
    Route::delete('enrollments/destroy', 'EnrollmentsController@massDestroy')->name('enrollments.massDestroy');
    Route::resource('enrollments', 'EnrollmentsController');
});
