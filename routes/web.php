<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares;
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
route::get('/tarif',$url."\TarifController@index")->middleware('role:admin')->name('tarif');

route::get('/addtarif',function(){
    return view('addtarif');
})->middleware('role:admin')->name('addtarif');

route::post('/savetarif',$url."\TarifController@store")->middleware('role:admin')->name('savetarif');
route::get('/edittarif/{id}',$url."\TarifController@show")->middleware('role:admin')->name('edittarif');
route::post('/updatetarif/{id}',$url."\TarifController@update")->middleware('role:admin')->name('updatetarif');
route::get('/deletetarif/{id}',$url."\TarifController@destroy")->middleware('role:admin')->name('deletetarif');


