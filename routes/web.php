<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PizzaController;
use App\Http\Controllers\Admin\CategoryController;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        if(Auth::user()->role =='admin'){
            return redirect()->route('admin#profile');
          }else if(Auth::user()->role=='user'){
             return redirect()->route('user#index');
          }
    })->name('dashboard');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    // Route::get('/',[AdminController::class,'index'])->name('admin#index');
    Route::get('profile', [AdminController::class, 'profile'])->name('admin#profile');
    Route::post('update/{id}', [AdminController::class, 'updateProfile'])->name('admin#updateProfile');
    Route::post('changePassword/{id}', [AdminController::class, 'changePassword'])->name('admin#changePassword');
    Route::get('changePasswordPage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');

    Route::get('category', [CategoryController::class, 'category'])->name('admin#category');
    Route::get('addCategory', [CategoryController::class, 'addCategory'])->name('admin#addCategory');
    Route::post('createCategory', [CategoryController::class, 'createCategory'])->name('admin#createCategory');
    Route::get('deleteCategory/{id}', [CategoryController::class, 'deleteCategory'])->name('admin#deleteCategory');
    Route::get('editCategory/{id}', [CategoryController::class, 'editCategory'])->name('admin#editCategory');
    Route::post('updateCategory', [CategoryController::class, 'updateCategory'])->name('admin#updateCategory');
    Route::get('searchcategory', [CategoryController::class, 'searchCategory'])->name('admin#searchcategory');


    Route::get('pizza', [PizzaController::class, 'pizza'])->name('admin#pizza');
    Route::get('createPizza', [PizzaController::class, 'createPizza'])->name('admin#createPizza');
    Route::post('insertPizza', [PizzaController::class, 'insertPizza'])->name('admin#insertPizza');
    Route::post('insertPizza', [PizzaController::class, 'insertPizza'])->name('admin#insertPizza');
    Route::get('deletePizza/{id}', [PizzaController::class, 'deletePizza'])->name('admin#deletePizza');
    Route::get('pizzaInfo/{id}', [PizzaController::class, 'pizzaInfo'])->name('admin#pizzaInfo');
    Route::get('editPizza/{id}', [PizzaController::class, 'editPizza'])->name('admin#editPizza');
    Route::post('updatePizza/{id}', [PizzaController::class, 'updatePizza'])->name('admin#updatePizza');
    Route::get('pizza/search', [PizzaController::class, 'pizzaSearch'])->name('admin#pizzaSearch');

    Route::get('userList',[UserController::class,'userList'])->name('admin#userList');
    Route::get('adminList',[UserController::class,'adminList'])->name('admin#adminList');
    Route::get('userList/search',[UserController::class,'userSearch'])->name('admin#userSearch');
    Route::get('userList/delete/{id}',[UserController::class,'userDelete'])->name('admin#userDelete');
    Route::get('admin/search',[UserController::class,'adminSearch'])->name('admin#adminSearch');

});

Route::group(['prefix'=>'user'],function (){
    Route::get('/',[UserController::class,'index'])->name('user#index');
});
