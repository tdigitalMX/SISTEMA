<?php
use Illuminate\Http\Request;

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
    return view('index');
});


Route::post('/store/catalogos/productos', 'CatalogoProductos@store');
Route::get('/get/catalogos/productos', 'CatalogoProductos@get');
Route::get('/validate/catalogos/productos', 'CatalogoProductos@validator');
Route::put('/update/catalogos/productos', 'CatalogoProductos@update');
Route::post('/update/catalogos/productos', 'CatalogoProductos@update');

Route::get('/test', function(){
    
});


Route::post('/store/atencion-medica/pacientes', function(Request $request){
    return $request->data;
});
