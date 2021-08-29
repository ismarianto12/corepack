
<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return view('ismarianto::indexapp.index');
});

Route::group(['namespace' => 'Ismarianto\Ismarianto\Controllers', 'middleware' => ['web']], function () {
    Route::get('/', 'IndexaplikasiController@index')->name('/');
    // Route::get('/', 'IndexaplikasiController@index')->name('');
 });
