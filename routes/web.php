<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpensesCategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route for dashboard, protected by the auth middleware
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/expenses', [ExpensesController::class, 'expenses'])->name('expenses');
    Route::post('/change-password/{id}', [UserController::class, 'changePassword'])->name('changePassword');
    Route::get('/expenses', [ExpensesController::class, 'expenses'])->name('expenses');
Route::get('/expenses/{id}', [ExpensesController::class, 'showExpense']);
Route::post('/expenses', [ExpensesController::class, 'storeExpense'])->name('storeExpense');
Route::put('/expenses/{id}', [ExpensesController::class, 'updateExpense'])->name('updateExpense');
Route::get('/dashboard', [ExpensesController::class, 'totalExpenses'])->name('dashboard');


});



Route::middleware(['auth', 'Admin'])->group(function () {
    // Users Route
    Route::get('/users', [UserController::class, 'showUsers'])->name('users');
    Route::post('/users/create', [UserController::class, 'createUser'])->name('createUser');
    Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('updateUser');
    // Roles Route
    Route::get('/roles', [RoleController::class, 'showRoles'])->name('roles');
    Route::post('/role-post', [RoleController::class, 'addRole'])->name('addRole'); 
    Route::delete('/roles/{id}', [RoleController::class,'deleteRole'])->name('deleteRole');
    Route::put('/roles/{id}', [RoleController::class, 'updateRole'])->name('updateRole');
    // Expense Categories
    Route::get('/expensecategories', [ExpensesCategoriesController::class, 'showExpensesCategories'])->name('expensecategories');
    Route::post('/expensecategories', [ExpensesCategoriesController::class, 'storeCategory'])->name('storeCategory');
    Route::put('/expensecategories/{id}', [ExpensesCategoriesController::class, 'updateCategory'])->name('updateCategory');
    Route::delete('/expensecategories/{id}', [ExpensesCategoriesController::class, 'deleteCategory'])->name('deleteCategory');



});
