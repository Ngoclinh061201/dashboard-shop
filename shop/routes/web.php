<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

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
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('admin.pages.dashboard.index');
})->middleware('auth')->name('dashboard');

Route::resource('users',UserController::class)->middleware('auth');

Route::prefix('/products')->middleware(['auth', 'role:user,admin,super-admin'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware('role:admin');
    Route::post('/', [ProductController::class, 'store'])->name('products.store')->middleware('role:admin');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('role:admin,super-admin');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('role:admin,super-admin');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('role:super-admin');
});
Route::resource('categories',CategoryController::class)->middleware(['auth', 'role:admin']);

Route::resource('roles',RoleController::class)->middleware('auth', 'role:super-admin');

require __DIR__.'/auth.php';
