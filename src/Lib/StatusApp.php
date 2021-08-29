<?php

namespace Ismarianto\Ismarianto\Lib;

use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Models\Tmstatus_aplikasi;
use Ismarianto\Ismarianto\Models\Tmnasabah;

class StatusApp
{

    public function get($no_aplikasi)
    {
    }

    public static function percentage($no_aplikasi)
    {
        $keseluruhan = Tmstatus_aplikasi::whereNotIn('id', [32, 33, 34, 35, 36, 37, 38, 39, 40])->get();
        // detail nasabah
        $data = Tmnasabah::select(
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmstatus_aplikasi.id as statusnya'

        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id', 'left')
            ->where('tmnasabah.no_aplikasi', $no_aplikasi);
        // ->whereNotIn('tmstatus_aplikasi.id', [32, 33, 34, 35, 36, 37, 38, 39, 40]);

        $kode = $data->first()->statusnya;
        // dd($kode);

        if ($data->count() > 0) {
            foreach ($keseluruhan as $statuss) {
                $nil[]  = $statuss['id'];
            }
            if ($kode <= 32) {
                $getval = count($nil);
                $a = $kode / $getval * 100;
                $percentage = round($a, 0, STR_PAD_LEFT);
                return $percentage . '%';
            } else if ($kode > 32) {
                return '100%';
            }
        } else {
            return '0%';
        }
    }
}
