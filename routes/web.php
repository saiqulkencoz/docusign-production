<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});
Route::get('/login','AuthController@login')->name('login'); //view halaman login
Route::post('/postlogin','AuthController@postlogin')->name('postlogin'); //menangani proses login
Route::get('/logout','AuthController@logout')->name('logout'); //menangani proses logout

Route::group(['middleware' => 'auth'],function(){
    //superadmin
    //index | read instansi
    Route::get('/super/instansi','SuperadminController@instansi_index')->name('super-instansi');
    Route::get('/super/statistik','SuperadminController@statistik')->name('super-statistik');
    //create instansi
    Route::post('/super/instansi/create','SuperadminController@create')->name('create-instansi');
    Route::get('/super/instansi/edit/{id}','SuperadminController@update_index');
    //update data instansi
    Route::post('/super/instansi/update/{id}','SuperadminController@update');
    //delete data instansi
    Route::get('/super/instansi/delete/{id}','SuperadminController@delete');
    Route::get('/super/user','SuperadminController@user_index')->name('super-user');
    Route::post('/super/user/create','SuperadminController@create_user')->name('create-user');
    Route::get('/super/user/edit/{id}','SuperadminController@update_user_index');
    Route::get('/super/user/delete/{id}','SuperadminController@delete_user');
    Route::post('/super/user/update/{id}','SuperadminController@update_user');
    Route::get('/super/cekuser','SuperadminController@cek_view')->name('super-cekuser');
    Route::post('/super/cekuser/post','SuperadminController@cek_post')->name('super-cekuserpost');
    
    //admin dinas
    Route::get('/admin/pengajuan','AdminController@pengajuan')->name('adm-pengajuan');
    Route::get('/admin/statistik','AdminController@statistik')->name('adm-statistik');
    Route::post('/admin/uploadpdf','AdminController@uploadpdf')->name('uploadpdf');
    Route::get('/admin/deletepdf/{id}','AdminController@deletepdf');
    Route::post('/admin/updatepdf/{id}','AdminController@updatepdf');
    Route::get('/admin/updatepdf/{id}/view','AdminController@viewupdate');
    Route::get('/admin/download','AdminController@download_index')->name('adm-download');
    Route::get('/admin/download/{id}','AdminController@download_bsre');
    Route::get('/admin/cekdokumen','AdminController@cek_view')->name('adm-cek');
    Route::post('/admin/cekdokumen/post','AdminController@cek_dokumen')->name('adm-cekpost');
    
    //kadis
    Route::get('/kadis/dokumen','KadisController@index')->name('kadis-dokumen');
    Route::get('/kadis/dokumentte','KadisController@download_index')->name('kadis-tte');
    Route::get('/kadis/statistik','KadisController@statistik')->name('kadis-statistik');
    Route::post('/kadis/dokumen/terima/{id}','KadisController@terima');
    Route::post('/kadis/dokumen/tolak/{id}','KadisController@tolak');
    Route::get('/kadis/download/{id}','KadisController@download_bsre');
});
