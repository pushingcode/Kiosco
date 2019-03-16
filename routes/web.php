<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::view('/admin/config', 'admin.config');
Route::get('/admin/config', 'ConfigController@index')
->name('config');
Route::get('/admin/config/create', 'ConfigController@create')
->name('create.config');
Route::get('/admin/config/edit/{id}', 'ConfigController@edit')
->name('edit.config');
Route::put('/admin/config/update/{id}', 'ConfigController@update')
->name('update.config');
Route::post('/admin/config/store', 'ConfigController@store')
->name('store.config');
Route::delete('/admin/config/destroy/{id}', 'ConfigController@destroy')
->name('destroy.config');

Route::resources([
    'ejercicio' => 'EjercicioController',
    'almacen'   => 'AlmacenController',
    'unidad'    => 'UnidadController',
    'categoria' => 'CategoriaController',
    'producto'  => 'ProductoController',
    'proveedor' => 'ProveedorController',
]);