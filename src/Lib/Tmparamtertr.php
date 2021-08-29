<?php

/*
*@author Ismarianto  
* if use this library don change namespace below
*/

namespace Ismarianto\Ismarianto\Lib;

use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Truseroveride;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;
use Ismarianto\Ismarianto\Models\Tmstatus_aplikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Ismarianto\Ismarianto\Models\Tmsla;
// use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


class Tmparamtertr
{
    public static function generate()
    {
        $kodecabang = Session::get('unit');
        $kode_cabang = trim($kodecabang);
        $combine = Carbon::now()->format('Ymd');
        $a =  $kode_cabang . $combine;
        $data = Tmnasabah::select(\DB::raw('max(id) + 1 as idnya'))->first();
        $rdata = ($data->idnya > 0 || $data->idnya != null) ?  (int)$data->idnya : 1;
        $result = $a . str_pad($rdata, 4, "0", STR_PAD_LEFT);
        return $result;
    }

    public static function get_detailnasabah($no_apl)
    {
        $data = Tmnasabah::select(
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            // 'tmaplikasi.no_rek_induk'
            'tmaplikasi.tmparameter_id',
            'tmaplikasi.tmhadiah_id',
            'tmparameter.nama_prog',
            'tmhadiah.jenis_hadiah'
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmhadiah', 'tmaplikasi.tmhadiah_id', '=', 'tmhadiah.id')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->where('tmnasabah.no_aplikasi', $no_apl)
            ->first();
        $jmanfaat = Trpenerima_manfaat::where('no_aplikasi', $data->no_aplikasi)
            ->count();

        return view('tazamcore::tmparameter.get_detail_nasabah', [
            'data' => $data,
            'jmanfaat' => $jmanfaat,
            'tmparametername' => $data->nama_prog,
            'tmparameter_id' => $data->tmparameter_id
        ]);
    }

    public static function getoveride($name, $parclass = null)
    {

        $data = Truseroveride::get();
        return view('tazamcore::tmparameter.get_overide', [
            'data' => $data,
            'name' => $name,
            'parclass' => $parclass
        ]);
    }

    public static function getlevel($parclasss = null)
    {
        $data = Truseroveride::get();
        return view('tazamcore::tmparameter.level_akses', [
            'data' => $data,
            'name' => $parclasss
        ]);
    }
    public static function listdocument($parameter)
    {
        if ($parameter == 'Peserta') {
            $gparameter = 'doc_peserta_id';
        } else if ($parameter == 'Pmanfaat') {
            $gparameter = 'doc_pmanfaat_id';
        }
        $data = Tmparameterdoc::where('kode', $parameter)->get();
        return view('tazamcore::tmparameter.pilihan_document_peserta', [
            'tmparater_doc' => $data,
            'name' => $gparameter
        ]);
    }

    public static function setstatus($par)
    {
        $posisi = Route::currentRouteName();
        if (is_array($par)) {

            $no_aplikasi = isset($par['no_ap']) ? $par['no_ap'] : 'null';

            $sla = Tmsla::where('no_ap', $no_aplikasi);
            if ($sla->count() > 0) {
                $sla->first()->update([
                    'posisi' => $posisi,
                    'no_ap' => $no_aplikasi,
                    'tmstatus_aplikasi_id' => isset($par['status']) ? $par['status'] : '0',
                    'kode' => isset($par['kode']) ? $par['kode'] : 'null',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'user_id' => session::get('username'),
                ]);
            } else {
                Tmsla::insert([
                    'posisi' => $posisi,
                    'no_ap' => $no_aplikasi,
                    'tmstatus_aplikasi_id' => isset($par['status']) ? $par['status'] : '0',
                    'kode' => isset($par['kode']) ? $par['kode'] : 'null',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'user_id' => session::get('username'),
                ]);
            }
        }
    }

    public static function jk()
    {
        return [];
    }

    public static  function get_religion()
    {
        return [
            'Islam' => 'Islam',
            'Kristen' => 'Kristen',
            'Katolik' => 'Katolik',
            'Hindu' => 'Hindu',
            'Budha' => 'Budha',
            'KoongHucu' => 'Konghucu',
            'Lainya' => 'Lainya',
        ];
    }

    public static function cabang($cabang)
    {
        $data = DB::table('tmref_cabang')->select('id', 'kode_cabang', 'nama_cabang')->where([
            'kode_cabang' => $cabang
        ])->first();
        return $data->nama_cabang;
    }

    public static function session($parameter)
    {
        if (Session::get('auths')) {

            if ($parameter == 'username') {
                return Session::get('username');
            } else {

                if (in_array($parameter, [

                    'user_id',
                    'username',
                    'name',
                    'email',
                    'phone',
                    'unit',
                    'jabatan',
                    'nik',
                    'status',
                    'counter_pass',
                    'temp_data_time',
                    'active_time',
                    'role',
                    'permission',

                ])) {

                    $session = '';
                    $gsession = Session::get($parameter);
                    foreach ($gsession as $key => $val) {
                        $session .= $val;
                    }
                    return $session;
                } else {
                    return null;
                }
            }
        }
    }

    public static function getuseroveride($tmparamater_id)
    {
        $data = Truseroveride::where('tmparameter_id', $tmparamater_id)->get();
        return $data;
    }
    public static function status_approve_verifikasi()
    {
        return [
            1 => 'Di teruskan ke Pusat',
            2 => 'Revise ke Backofice',
            3 => 'Revise ke Cabang',
            4 => 'Reject',
            5 => 'Approved Pusat'
        ];
    }
    // get status approve 
    public static function status_approve()
    {
        return [
            1 => 'Di teruskan ke Pusat',
            2 => 'Revise ke marketing',
            3 => 'Revise ke Cabang',
            4 => 'Reject',
            5 => 'Approved Pusat'
        ];
    }

    public static function status_overide()
    {
        return [
            1 => 'Di teruskan ke Busines Development',
            2 => 'Revise Ke marketing',
            3 => 'Revise Ke Cabang',
            4 => 'Reject',
            5 => 'Approved Business Development'
        ];
    }

    public static function pekerjaanktp()
    {
        return [
            'Pegawai Negeri / BUMN' => 'Pegawai Negeri / BUMN',
            'Pegawai Swasta' => 'Pegawai Swasta',
            'pelajar /Mahasiswa' => 'pelajar /Mahasiswa',
            'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
            'Lainya' => 'Lainya',
        ];
    }
    // keterangan tempat tinggal
    public static function tempattinggal()
    {
        return [
            'Milik Sendiri' => 'Milik Sendiri',
            'Orang Tua' => 'Orang Tua',
            'Kontrak / Kost' => 'Kontrak / Kost',
            'Tempat Tinggal lainya' => 'Tempat Tinggal lainya',
        ];
    }

    public static function curency($passed)
    {

        $var = str_replace(',', '', $passed);
        if (is_numeric($var)) {
            return number_format((int)$var, 0, 0, '.');
        } else {
            return $passed;
        }
    }
}
