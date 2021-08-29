
<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Ismarianto\Ismarianto\Controllers', 'middleware' => ['web', 'tazamauth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::middleware(['modulpar'])->group(function () {
        // core access syste app
        Route::resource('dokumenjaminan', 'KelengkapanjaminanController');
        Route::resource('nasabah', 'NasabahController');
        Route::resource('overide', 'OverideController');
        Route::resource('otorisasi', 'OtorisasiController');
        Route::resource('uploaddankelengkapan', 'UploadkelengkapanController');
        Route::resource('verifikasikelengkapan', 'VerifikasiController');

        Route::resource('modul', 'ModulappController');
        Route::resource('submodul', 'ModulsubController');
        Route::resource('parameter', 'TmparameterController');
        Route::resource('trparameter_doc', 'Tmparameter_docController');
        Route::resource('trtablebiaya', 'TrtablebiayaController');
        Route::resource('trhububungan', 'TrhubunganController');
        Route::resource('picoveride', 'TrpicoverideController');
    });


    Route::post('jumlah_rekening', 'TmparameterController@jumlah_rekening')->name('jumlah_rekening');
    Route::get('tablebiaya_list', 'TrtablebiayaController@tablebiaya_list')->name('tablebiaya_list');

    Route::prefix('parameter')->name('parameter.')->group(function () {
        Route::post('getypefile', 'TmparameterController@gettype')->name('getypefile');
        Route::post('setactive', 'TmparameterController@setactive')->name('setactive');
    });
    Route::post('gettable_document', 'TmparameterController@gettable_document')->name('gettable_document');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('levelakses', 'DashboardController@levelakses')->name('levelakses');
        Route::get('changepass', 'DashboardController@profil')->name('changepass');
        Route::post('actionsave', 'DashboardController@actionsave')->name('actionsave');
    });

    Route::get('testover/{id}', 'NasabahController@testover')->name('testover');
    Route::get('dl', 'NasabahController@devrest')->name('dl');
    Route::get('detilpmanfaat/{id}', 'NasabahController@detilpmanfaat')->name('detilpmanfaat');


    Route::prefix('otorisasi')->name('otorisasi.')->group(function () {
        Route::post('tableotorisasi/{id}', 'OtorisasiController@tableotorisasi')->name('tableotorisasi');
        Route::post('savedata/{id}', 'OtorisasiController@savedata')->name('savedata');
    });

    Route::prefix('overide')->name('overide.')->group(function () {
        Route::post('savedata', 'OverideController@savedata')->name('savedata');
    });

    Route::prefix('nasabah')->name('nasabah.')->group(function () {
        Route::get('getdatailnasabah/{id}', 'NasabahController@getdatailnasabah')->name('getdatailnasabah');


        Route::get('pr/{id}', 'NasabahController@pr')->name('pr');
        Route::post('penerima_manfaat', 'NasabahController@jum_penerima_manfaat')->name('penerima_manfaat');
        Route::post('penerima_manfaat_edit', 'NasabahController@jum_penerima_edit')->name('penerima_manfaat_edit');
    });
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('otorisasi', 'DashboardController@otorisasi')->name('otorisasi');
        Route::get('verifikasi', 'DashboardController@verifikasi')->name('verifikasi');
        Route::get('jumlah', 'DashboardController@jumlah')->name('jumlah');
    });


    Route::prefix('uploaddankelengkapan')->name('uploaddankelengkapan.')->group(function () {

        Route::get('datailkonfirm/{id}', 'UploadkelengkapanController@datailkonfirm')->name('datailkonfirm');
        Route::post('actionconfirm', 'UploadkelengkapanController@actionconfirm')->name('actionconfirm');

        Route::post('lengkapi/{id}', 'UploadkelengkapanController@simpan_data')->name('lengkapi');
        Route::post('delete_file', 'UploadkelengkapanController@delelete_file')->name('delete_file');
        // table list document masing masing
        Route::post('table_file_nasabah', 'UploadkelengkapanController@table_file_nasabah')->name('table_file_nasabah');
        Route::post('table_file_penerima_manfaat', 'UploadkelengkapanController@table_file_penerima_manfaat')->name('table_file_penerima_manfaat');
    });

    Route::resource('statusprogram', 'StatusprogramController');
    Route::resource('report_bulanan', 'ReportBulanController');
    //  add line action  seeem like bottom
    Route::prefix('api')->name('api.')->group(function () {
        Route::post('statusprogram', 'StatusprogramController@api')->name('statusprogram');

        // this ad line to report as month by ria
        Route::post('reportbulanan', 'ReportBulanController@api')->name('reportbulanan');
    });

    Route::prefix('dokumenjaminan')->name('dokumenjaminan.')->group(function () {
        Route::post('uploaddata/{id}', 'KelengkapanjaminanController@simpan_data')->name('uploaddata');
        Route::post('table_upload/{id}', 'KelengkapanjaminanController@table_upload')->name('table_upload');
        Route::post('delete_file/{id}', 'KelengkapanjaminanController@delete_file')->name('delete_file');

        // action confirm kelengkapan
        Route::get('datailkonfirm/{id}', 'KelengkapanjaminanController@datailkonfirm')->name('datailkonfirm');
        Route::post('actionconfirm', 'KelengkapanjaminanController@actionconfirm')->name('actionconfirm');
    });
    // list data api route access 
    Route::prefix('api')->name('api.')->group(function () {
        // table biaya dan table list data hungunan dnas ah 
        Route::post('trparameter_doc', 'Tmparameter_docController@api')->name('trparameter_doc');
        Route::post('getdetail_hadiah', 'TmparameterController@getdetail_hadiah')->name('getdetail_hadiah');
        // prameter biaya penutupan 
        Route::post('trtablebiaya', 'TrtablebiayaController@api')->name('trtablebiaya');
        // hubungan
        Route::post('trhububungan', 'TrhubunganController@api')->name('trhububungan');
        // pic overide
        Route::get('picoveride', 'TrpicoverideController@api')->name('picoveride');

        Route::get('modul', 'ModulappController@api')->name('modul');
        Route::get('modulsub', 'ModulsubController@api')->name('modulsub');
        Route::get('parameter', 'TmparameterController@api')->name('parameter');

        // table biaya dan table list data hungunan dnas ah 
        Route::get('uploaddankelengkapan', 'UploadkelengkapanController@api')->name('uploaddankelengkapan');
        Route::get('otorisasi', 'OtorisasiController@api')->name('otorisasi');
        Route::get('dokumenjaminan', 'KelengkapanjaminanController@api')->name('dokumenjaminan');
        Route::get('dokumenjaminanverify', 'VerifikasiController@api')->name('dokumenjaminanverify');
        Route::get('nasabah', 'NasabahController@api')->name('nasabah');
        Route::get('overidenasabah', 'OverideController@api')->name('overidenasabah');
    });
    // pased route access

    // linet to noticed ket 
    Route::prefix('notif')->name('notif.')->group(function () {
        // notfikasi jaminan
        Route::get('jaminanbelumupload', 'VerifikasiController@jaminanbelumupload')->name('jaminanbelumupload');
        Route::get('otorisasirek', 'VerifikasiController@otorisasirek')->name('otorisasirek');
        Route::get('lengkap', 'VerifikasiController@lengkap')->name('lengkap');

        // notifikasi jaminan 
        // Route::get('jaminanbelumupload', 'KelengkapanjaminanController@jaminanbelumupload')->name('');
        // Route::get('sudahotor', 'KelengkapanjaminanController@sudahotor')->name('');
        // Route::get('jaminanlengkap', 'KelengkapanjaminanController@jaminanlengkap')->name('');
    });
});

Route::group(['namespace' => 'Ismarianto\Ismarianto\Controllers', 'middleware' => ['web']], function () {
    Route::get('/', 'LoginController@index')->name('');
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('actionlogin', 'LoginController@AuthProcessed')->name('actionlogin');
    Route::get('403', 'RouteController@acces403')->name('403');
    Route::get('404', 'RouteController@acces404')->name('404');
});
Route::group(['namespace' => 'Ismarianto\Dash\Controllers', 'middleware' => 'web'], function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
