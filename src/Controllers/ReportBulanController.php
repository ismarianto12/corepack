<?php

namespace Ismarianto\Ismarianto\Controllers;

use App\Http\Controllers\Controller as AbangJeckController;
use Ismarianto\Ismarianto\Lib\StatusApp;
use Illuminate\Http\Request;
use DataTales;
use Ismarianto\Ismarianto\Models\Tmstatus_aplikasi;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;

class ReportBulanController extends AbangJeckController
{
    protected $request;
    protected $route;
    protected $view;


    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::report_bulanan.';
        $this->route   = 'report_bulanan.';
    }

    public function index()
    {
        $title =  'Laporan Bulanan';
        $parsed =  '';
        $view = $this->view . '.index';
        $statusdata = Tmstatus_aplikasi::get();

        $month =  [
            1 => 'January',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'July',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        return view(
            $view,
            [
                'title' => $title,
                'parsed' => $parsed,
                'month' => $month,
                'statusdata' => $statusdata
            ]
        );
    }

    public function api($verifikasi = null)
    {

        $status_program = $this->request->status_program;
        $bulan = $this->request->bulan;

        $data = Tmnasabah::select(
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            'tmstatus_aplikasi.keterangan_status'
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->orderBy('tmnasabah.no_aplikasi')
            ->distinct();

        if ($status_program && $bulan) {
            $fdata =  $data->where('tmsla.tmstatus_aplikasi_id', $status_program)->get();
            $fdata =  $data->where(\DB::raw('FORMAT(tmnasabah.created_at,M)', $status_program))->get();
        } else {
            $fdata = $data->get();
        }
        return \DataTables::of($fdata)
            ->editColumn('action', function ($p) use ($verifikasi) {
                return  '<a href="" class="btn btn-info btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-print"></i></a> ';
            }, true)
            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return  '<a href="#" class="btn btn-warning btn-sm" id="lengkapi" data-id="' . $p->no_aplikasi . '"><i class="fa fa-refresh"></i>' . $percent . '</a> ';
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<a href="#" class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</a>';
            }, true)
            ->editColumn('waktu_input', function ($p) {
                $g = date('Y-m-d', strtotime($p->date_create));
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
