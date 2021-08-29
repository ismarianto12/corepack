<?php

/**
 *@author ismarianto 
 */

namespace Ismarianto\Ismarianto\Traits;

use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use Ismarianto\Ismarianto\Models\Tmoveride;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

trait Overide
{
    public function cekoveride($no_aplikasi)
    {
        // dapatkan siapa yang overide di tazamcore 
        $nasabah = Tmnasabah::select(
            'tmnasabah.no_aplikasi',
            'tmaplikasi.tmhadiah_id',
            'tmparameter.id',
            'tmnasabah.umur_peserta',
            'tmparameter.usia_peserta_min',
            'tmparameter.usia_peserta_max',
            'tmparameter.usia_penerima_manfaat_min',
            'tmparameter.usia_penerima_manfaat_manmax'
        )->where('tmnasabah.no_aplikasi', $no_aplikasi)
            ->join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi', 'LEFT')
            ->join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id', 'LEFT')
            ->first();

        $data = Tmaplikasi::select('tmaplikasi.tmparameter_id', 'tmaplikasi.tmhadiah_id')->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmaplikasi.tmparameter_id')
            ->where('tmaplikasi.no_aplikasi', $no_aplikasi)
            ->first();

        // dd($data->tmparameter_id);

        $parameter = Tmparameter::find($data->tmparameter_id);
        // dd($parameter);
        $pmanfaat = Trpenerimamanfaat::select(
            'id',
            'no_aplikasi',
            'nama',
            'usia',
            'hubungan',
            'tmhadiah_id',
            'no_hp',
            'email',
            'alamat',
            'users_id',
            'created_at',
            'updated_at',
            'tmparameter_id'
        )->where('no_aplikasi', $no_aplikasi)->get();

        $usia_peserta =  $nasabah->umur_peserta;
        $hadiahpeserta = $data->tmhadiah_id;


        $usia_peserta_min = $parameter->usia_peserta_min;
        $usia_peserta_max = $parameter->usia_peserta_max;
        $usia_penerima_manfaat_min = $parameter->usia_penerima_manfaat_min;
        $usia_penerima_manfaat_manmax = $parameter->usia_penerima_manfaat_manmax;
        $ovr = [];


        $overide_peserta =  [];
        if ($usia_peserta < $usia_peserta_min) {
            $overide_peserta[] =  'Usia minmal tidak terpenuhi';
        }
        if ($usia_peserta_max < $usia_peserta) {
            $overide_peserta[] =  'Usia maksimal tidak terpenuhi';
        }


        if ($hadiahpeserta  != 1) {
            $overide_peserta[] = 'Hadiah yang di  pilih tidak sesuai dengan parameter program.';
        }

        if (count($overide_peserta) > 0) {
            $keterangan_overide = json_encode($overide_peserta);
            $partial = Tmoveride::where(
                [
                    'no_aplikasi' => $no_aplikasi,
                    'jenis' => 'peserta',
                ]
            );
            if ($partial->count() > 0) {
                $partial->update([
                    'status' => 0,
                    'users_id' => Session::get('username'),
                    'created_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'keterangan_overide' => $keterangan_overide
                ]);
            } else {
                $partial->insert([
                    'no_aplikasi' => $no_aplikasi,
                    'jenis' => 'peserta',
                    'status' => 0,
                    'users_id' => Session::get('username'),
                    'created_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'keterangan_overide' => $keterangan_overide
                ]);
            }
            $ovr['peserta'] = 'peserta_overide';
        } else {
            $ovr['peserta'] = '';
        }
        $overide_pmanfaat = [];

        // dd($pmanfaat);
        foreach ($pmanfaat as $pmanfaats) {


            // dd($pmanfaats->id);
            $pilihan_hadiah_manfaat = $pmanfaats->tmhadiah_id;
            $hubunganpmanfaat = $pmanfaats->hubungan;
            $usia_penerima_manfaat = $pmanfaats->usia;
            // if hubungan lainya
            if ($hubunganpmanfaat == 7) {
                $overide_pmanfaat[] =  'Hubungan Penerima manfaat tidak sesuai parameter program ,';
            }
            if ($pilihan_hadiah_manfaat != 1) {
                $overide_pmanfaat[]  =  'Hadiah Penerima manfaat tidak berupa haji';
            }
            if ($usia_penerima_manfaat < $usia_penerima_manfaat_min) {
                $overide_pmanfaat[] =  'Usia range minimal dan maksimal peserta tidak sesuia dengan parameter program yang di ikuti.';
            }

            // dd($usia_penerima_manfaat_manmax .'-'. $usia_penerima_manfaat);
            if ($usia_penerima_manfaat_manmax < $usia_penerima_manfaat) {
                $overide_pmanfaat[] =  'Usia range maksimal peserta tidak sesuia dengan parameter program yang di ikuti.';
            }

            if (count($overide_pmanfaat) > 0) {
                $keterangan_overide = json_encode($overide_pmanfaat);
                $partial = Tmoveride::where(
                    [
                        'no_aplikasi' => $no_aplikasi,
                        'jenis' => 'pmanfaat',
                    ]
                );
                if ($partial->count() > 0) {
                    $partial->update([
                        'status' => 0,
                        'trpenerima_manfaat_id' => $pmanfaats->id,
                        'created_at' => Carbon::now(),
                        'created_at' => Carbon::now(), 
                        'users_id' => Session::get('username'),

                        'keterangan_overide' => $keterangan_overide
                    ]);
                } else {
                    $partial->insert([
                        'no_aplikasi' => $no_aplikasi,
                        'jenis' => 'pmanfaat',
                        'status' => 0,
                        'trpenerima_manfaat_id' => $pmanfaats->id,
                        'created_at' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'users_id' => Session::get('username'),

                        'keterangan_overide' => $keterangan_overide
                    ]);
                }
                $ovr['pmanfaat'] = 'pmnanfaat_overide';
            } else {
                $ovr['pmanfaat'] = '';
            }
        }
        return $ovr;
    }
}
