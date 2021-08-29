<?php

namespace Ismarianto\Ismarianto\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use Ismarianto\Cms\Models\Page;
use Ismarianto\Cms\Models\Post;
use Ismarianto\Dash\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use  Ismarianto\Ismarianto\Traits\LoginActions;
use Ismarianto\Ismarianto\Models\Tmlevelakses;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Ismarianto\Models\Tmnasabah;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illum   inate\Http\Response
     */

    public $username;
    public $ref_cabang;

    public function __construct()
    {
        $this->username = Session::get('username');
        $this->ref_cabang = Session::get('unit');
    }


    public function index(Request $request)
    {
        return view('tazamcore::dashboard.index', [
            'title' => 'welcome dashboard'
        ]);
    }

    public function profil()
    {
        return view('tazamcore::dashboard.profil', [
            'title' => "Ganti Password"
        ]);
    }
    public function actionsave(Request $request)
    {

        try {
            $request->validate([
                'old_password' => $request->old_password,
                'new_password' => $request->new_password
            ]);
            if ($request->old_password != $request->new_password) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Password berhasil di simpan'
                ]);
            }
            $par = [
                'old_password' => $request->old_password,
                'new_password' => $request->new_password,
            ];
            $this->change_pass($par);
            return response()->json([
                'status' => 1,
                'msg' => 'Password berhasil di simpan'
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function levelakses(Request $request)
    {
        $data = Tmlevelakses::get();
        return response()->json($data);
    }

    // notfikasi
    public function otorisasi()
    {
        $username = Session::get('username');
        $ref_cabang = Session::get('unit');

        $sql = Tmnasabah::select(
            'tmnasabah.id',
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmstatus_aplikasi.keterangan_status',
            'tmaplikasi.overide',
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->where('tmaplikasi.document_kelengkapan', 1)
            ->whereNotExists(function ($query) {
                $query->select('tmoveride.no_aplikasi')
                    ->from('tmoveride')
                    ->whereRaw('tmaplikasi.no_aplikasi = tmoveride.no_aplikasi');
            });
        if (Tmparamtertr::session('role') == 'manageroperation') {
            $sql->where('tmaplikasi.tmref_cabang_id', $ref_cabang);
            $sql->where(function ($query) {
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 11);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 12);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 13);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 14);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 18);
            });
        } else {
            $sql->where(function ($query) {
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 16);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 17);
                // $query->Orwhere('tmsla.tmstatus_aplikasi_id', 19);
                // $query->Orwhere('tmsla.tmstatus_aplikasi_id', 20);
            });
        }
        $data = $sql->distinct()
            ->get();

        return response()->json($data);
    }
    public function verifikasi()
    {
        $username = Session::get('username');
        $ref_cabang = Session::get('unit');

        $sql = Tmnasabah::select(
            'tmnasabah.id',
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            'tmstatus_aplikasi.keterangan_status',
            'tmsla.tmstatus_aplikasi_id',
            'tmaplikasi.overide'
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->whereNotExists(function ($query) {
                $query->select('tmoveride.no_aplikasi')
                    ->from('tmoveride')
                    ->whereRaw('tmaplikasi.no_aplikasi = tmoveride.no_aplikasi');
            })->distinct();

        if (Tmparamtertr::session('role') == 'backoffice') {
            $data =  $sql->where(function ($query) {
                $query->OrWhere('tmsla.tmstatus_aplikasi_id', 24);
                $query->OrWhere('tmsla.tmstatus_aplikasi_id', 26);
            })
                ->get();
        } else if (Tmparamtertr::session('role') == 'manageroperation') {
            $data = $sql->where('tmaplikasi.tmref_cabang_id', $ref_cabang)
                ->where(function ($query) {
                    $query->OrWhere('tmsla.tmstatus_aplikasi_id', 24);
                    $query->OrWhere('tmsla.tmstatus_aplikasi_id', 26);
                    $query->OrWhere('tmsla.tmstatus_aplikasi_id', 25);
                    $query->OrWhere('tmsla.tmstatus_aplikasi_id', 28);
                })
                ->get();
        } else if (Tmparamtertr::session('role') == 'internalcontrol') {
            $data =   $sql->where(function ($query) {
                $query->OrWhere('tmsla.tmstatus_aplikasi_id', 27);
                $query->OrWhere('tmsla.tmstatus_aplikasi_id', 29);
                $query->OrWhere('tmsla.tmstatus_aplikasi_id', 30);
                // $query->OrWhere('tmsla.tmstatus_aplikasi_id', 31);
                // $query->OrWhere('tmsla.tmstatus_aplikasi_id', 32);
            })
                ->get();
        } else {
            $data = [];
        }

        return response()->json($data);
    }
    public function jumlah()
    {
    }
}
