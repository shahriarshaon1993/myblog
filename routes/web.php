<?php

use App\Http\Controllers\Backend\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\TagController;

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

// Tag Routes
Route::post('/app/create-tag', [TagController::class, 'store']);
Route::get('/app/get-tag', [TagController::class, 'index']);
Route::post('/app/edit-tag', [TagController::class, 'updateTag']);
Route::post('/app/delete-tag', [TagController::class, 'deleteTag']);

// Category Routes
Route::get('/app/get-category', [CategoryController::class, 'getAllCategories']);
Route::post('/app/create-category', [CategoryController::class, 'addCategory']);
Route::post('/app/edit-category', [CategoryController::class, 'updateCategory']);
Route::post('/app/category-file-upload', [CategoryController::class, 'uploadCategoryFile']);
Route::post('/app/delete-category-image', [CategoryController::class, 'deleteCategoryImage']);
Route::post('/app/delete-category', [CategoryController::class, 'destroyCategory']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{any}', [DashboardController::class, 'index']);