<?php

namespace Ismarianto\Ismarianto\Controllers;

//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use Ismarianto\Ismarianto\Lib\StatusApp;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use DataTables;
use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Models\Tmparameter;
// use
use Ismarianto\Ismarianto\Models\Tmupload_document;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;
use Ismarianto\Ismarianto\Models\Tmstatus_aplikasi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Ismarianto\Ismarianto\Models\Tmupload_jaminan;

use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Troveride;
use Ismarianto\Ismarianto\Models\Trotorisasi;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;

class StatusprogramController extends controller
{
    // use Tmparamtertr;
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::status_program.';
        $this->route   = 'status_program.';
    }

    public function index($verfikasi = null)
    {

        $title =  'Status data nasabah';
        $parsed =  '';
        $view = $this->view . '.index';
        $statusdata = Tmstatus_aplikasi::get();
        return view(
            $view,
            [
                'title' => $title,
                'parsed' => $parsed,
                'statusdata' => $statusdata
            ]
        );
    }

    public function api($verifikasi = null)
    {

        $status_program = $this->request->status_program;
        $username = Session::get('username');
        $session_level = Session::get('role');
        $ref_cabang = Session::get('unit');
        $data = Tmnasabah::select(
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            'tmstatus_aplikasi.keterangan_status',
            'tmref_cabang.nama_cabang',
            'tmref_cabang.kode_cabang'
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->join('tmref_cabang', 'tmaplikasi.tmref_cabang_id', '=', 'tmref_cabang.id', 'left outer') 
            ->orderBy('tmnasabah.no_aplikasi')
            ->distinct();

        if ($session_level == 'marketing' && $session_level == 'manageroperation') {

            $data->where('tmaplikasi.tmref_cabang_id', $ref_cabang)
                ->where('tmnasabah.users_id', $username);
            if ($status_program) {
                $data->where('tmsla.tmstatus_aplikasi_id', $status_program);
            }
        } else {

            if ($status_program) {
                $data->where('tmsla.tmstatus_aplikasi_id', $status_program);
            }
        }

        $fdata = $data->get();

        return \DataTables::of($fdata)
            ->editColumn('action', function ($p) use ($verifikasi) {
                return  '<a href="" class="btn btn-info btn-sm" id="edit" data-id="' . $p->id . '"><i class="fa fa-print"></i></a> ';
            }, true)

            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return $percent;
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<button class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</button>';
            }, true)
            ->editColumn('waktu_input', function ($p) {
                $g = date('Y-m-d', strtotime($p->created_at));
                return $g;
            }, true)
            ->editColumn('user_id', function ($p) {
                return $p->users_id;
            }, true)
            ->editColumn('status', function ($p) {
                return ($p->keterangan_status) ? $p->keterangan_status : 'kosong';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'progress', 'waktu_input', 'user_id', 'status', 'j_manfaat'])
            ->toJson();
    }
}
