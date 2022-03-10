<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares;
use App\Http\Controller\TarifController;

$url = "App\http\Controllers";
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
    return view('welcome');
});

// Tampilan
route::get('/dashboard',function(){
    return view('isidashboard');
})->middleware('auth')->name('dashboard');

route::get('/admin',function(){
    return view('isidashboard');
})->middleware('role:admin');

// Authentication
route::get('/login',function(){
    return view('auth.login');
})->middleware('guest')->name('login');

route::get('/register',function(){
    return view('auth.register');
})->middleware('guest')->name('regis');

route::post('/register',$url."\AuthController@register");
route::post('/login',$url."\AuthController@login");
route::post('/logout',$url."\AuthController@logout");

// Tarif
Route::middleware('role:admin')->group(function () {
    route::get('/tarif',[TarifController::class, 'index'])->name('tarif');

    route::get('/addtarif',function(){
        return view('addtarif');
    })->name('addtarif');

    route::post('/savetarif',[TarifController::class, 'store'])->name('savetarif');
    route::get('/edittarif/{id}',[TarifController::class, 'show'])->name('edittarif');
    route::post('/updatetarif/{id}',[TarifController::class, 'update'])->name('updatetarif');
    route::get('/deletetarif/{id}',[TarifController::class, 'destroy'])->name('deletetarif');
    });