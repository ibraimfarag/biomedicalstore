<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\DivisionController;


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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);



Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');


    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // // Products, Orders, Departments - only accessible after login
    // Route::resource('products', ProductController::class);
    // Route::resource('orders', OrderController::class);
    // Route::resource('departments', DepartmentController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);


    Route::get('/assign-to-department', [RoleController::class, 'assignToDepartment'])->name('assignToDepartment');
    Route::post('/store-assignments', [RoleController::class, 'storeAssignments'])->name('storeAssignments');


    Route::resource('departments', DepartmentController::class);
    Route::resource('users', UserController::class);
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('items', ItemController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('requests', RequestController::class);

    Route::get('/export-orders', [OrderController::class, 'exportOrders'])->name('orders.export');


    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('password/change', [PasswordController::class, 'edit'])->name('password.change');
    Route::put('password/update', [PasswordController::class, 'update'])->name('password.update');


    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::post('/divisions/create', [DivisionController::class, 'create'])->name('divisions.create');
    Route::delete('/divisions/{id}', [DivisionController::class, 'delete'])->name('divisions.delete');


    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
