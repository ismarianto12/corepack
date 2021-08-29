<?php


namespace Ismarianto\Ismarianto\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use Ismarianto\Ismarianto\Models\Tmoveride;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;
use Ismarianto\Ismarianto\Traits\NasabahApirek;
use Ismarianto\Ismarianto\Traits\Overide;
// use Tmoveride;
use DataTables;
use Illuminate\Support\Facades\Session;

use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;
use Carbon\Carbon;
use Ismarianto\Ismarianto\Models\Trstatus_otorisasi;
use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Troveride;

use Ismarianto\Ismarianto\Models\Trhubungan;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use Ismarianto\Ismarianto\Lib\StatusApp;

class OverideController extends Controller
{

    public $request;
    public $view;
    public $route;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = 'tazamcore::.overide.';
        $this->route = 'nasabah.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Session::get('RF.subfolder'));
        // get data nasabha dengan statuS 2
        return view($this->view . 'index', [
            'title' => 'Overide data nasabah'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function api()
    {
        $sql = Tmoveride::select(
            'tmnasabah.id as idnya',
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmoveride.created_at',
            'tmoveride.status',
            'tmoveride.users_id'

        )->join('tmnasabah', 'tmnasabah.no_aplikasi', '=', 'tmoveride.no_aplikasi')
            ->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')->where('jenis', 'peserta');

        if (Tmparamtertr::session('role') == 'marketing') {
            $sql->where('tmaplikasi.tmref_cabang_id', Session::get('unit'));
        }
        if (Tmparamtertr::session('role') == 'manageroperation') {
            $sql->where('tmaplikasi.tmref_cabang_id', Session::get('unit'));
            $sql->whereIn('tmoveride.status', [
                0, 2, 3
            ]);
        } else if (Tmparamtertr::session('role') == 'businessdevelopment') {
            $sql->whereIn('tmoveride.status', [
                1, 2
            ]);
        }
        $fdata =  $sql->distinct()->get();
        return \DataTables::of($fdata)
            ->editColumn('action', function ($p) {
                if (Tmparamtertr::session('role') == 'marketing') {
                    if ($p->status == 2) {
                        return  '<a href="' . route('nasabah.edit', $p->idnya) . '" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-edit"></i>Revise Om Cabang</a> ';
                    } else if ($p->status == 3 || $p->status == 4 || $p->status == 5) {
                        $parameter = Tmparamtertr::status_approve();
                        $stat   = $parameter[$p->status];
                        return  isset($stat) ? $stat : 'kosong';
                    } else {
                        return 'Proses Approved Overide';
                    }
                } else {
                    if ($p->status == 2) {
                        return  '<a href="" class="btn btn-warning btn-sm"><i class="fa fa-share fa-spin"></i>Menunggu Marketing memperbaiki data </a> ';
                    } else {
                        return  '<a href="" class="btn btn-info btn-sm" id="lengkapi" data-id="' . $p->idnya . '"><i class="fa fa-edit"></i>Overide Nasabah  </a> ';
                    }
                }
            }, true)
            ->editColumn('no_aplikasi', function ($p) {
                $url  = route('overide.show', $p->no_aplikasi);
                return  '<a href="#" class="btn btn-warning btn-sm" onclick="javascript:overidedetail(\'' . $p->no_aplikasi . '\')">' . $p->no_aplikasi . '</a>';
            }, true)

            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return $percent;
            }, true)
            ->editColumn('waktu_input', function ($p) {
                $g = date('Y-m-d H:i:s', strtotime($p->created_at));
                return $g;
            }, true)
            ->editColumn('user_id', function ($p) {
                return ucfirst($p->users_id);
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<button class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</button>';
            }, true)
            ->editColumn('status', function ($p) {
                // dd($p->status);
                if ($p->status == 0) {
                    $statusnya = 'Belum di verifikasi';
                } else {
                    $parameter = Tmparamtertr::status_approve();
                    $statusnya   = $parameter[$p->status];
                }
                return isset($statusnya) ? $statusnya : '';
            }, true)

            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'no_aplikasi', 'progress', 'waktu_input', 'user_id', 'j_manfaat'])
            ->toJson();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($no_aplikasi)
    {
        if (!$this->request->ajax()) {
            return abort(404, 'null');
        }
        $data = Tmnasabah::where('no_aplikasi', $no_aplikasi)->first();
        $tazamprogram = Tmparameter::get();

        $overide = Tmoveride::where('no_aplikasi', $data->no_aplikasi);

        if ($overide->count() < 0) return abort('404', 'Data overide nasabah tidak ada ');

        $peserta = Tmoveride::where([
            'no_aplikasi' => $data->no_aplikasi,
            'jenis' => 'peserta'
        ]);

        $pmanfaat =   $overide->where([
            'jenis' => 'pmanfaat'
        ])->first();

        $aplikasi_pmanfaat = isset($pmanfaat->no_aplikasi) ? $pmanfaat->no_aplikasi : '';
        $data_penerima_manfaat =  Trpenerimamanfaat::where('no_aplikasi', $aplikasi_pmanfaat);

        if ($data_penerima_manfaat->count() > 0) {

            $i = 0;
            foreach ($data_penerima_manfaat->get() as $data_penerima_manfaats) {
                $parvar[$i]['nama']['val'] = $data_penerima_manfaats->nama;
                $parvar[$i]['usia']['val'] = $data_penerima_manfaats->usia;
                $parvar[$i]['hubungan']['val'] = $data_penerima_manfaats->hubungan;
                $parvar[$i]['tmhadiah_id']['val'] = $data_penerima_manfaats->tmhadiah;
                $parvar[$i]['no_hp']['val'] = $data_penerima_manfaats->no_hp;
                $parvar[$i]['email']['val'] = $data_penerima_manfaats->email;
                $parvar[$i]['alamat']['val'] = $data_penerima_manfaats->alamat;
                $parvar[$i]['pilihan_hadiah']['val'] = $data_penerima_manfaats->tmhadiah_id;

                // data overide 
                $openeriman_manfaat  =  Tmoveride::where([
                    'jenis' => 'pmanfaat',
                    'trpenerima_manfaat_id' => $data_penerima_manfaats->id
                ]);

                if ($openeriman_manfaat->count() > 0) {
                    foreach ($openeriman_manfaat->get() as $openeriman_manfaas) {
                        $parvar[$i]['id']['val'] = $openeriman_manfaas->id;
                        $parvar[$i]['no_aplikasi']['val'] = $openeriman_manfaas->no_aplikasi;
                        $parvar[$i]['jenis']['val'] = $openeriman_manfaas->jenis;
                        $parvar[$i]['catatan_cabang']['val'] = $openeriman_manfaas->catatan_cabang;
                        $parvar[$i]['keterangan_overide']['val'] = isset($openeriman_manfaas->keterangan_overide) ? $openeriman_manfaas->keterangan_overide : [];
                        $parvar[$i]['status']['val'] = $openeriman_manfaas->status;
                        $parvar[$i]['status_revise']['val'] = $openeriman_manfaas->status_revise;
                        $parvar[$i]['catatan_pusat']['val'] = $openeriman_manfaas->catatan_pusat;
                        $parvar[$i]['trpenerima_manfaat_id']['val'] = $openeriman_manfaas->trpenerima_manfaat_id;
                        $parvar[$i]['users_id']['val'] = $openeriman_manfaas->users_id;
                        $i++;
                    }
                } else {
                    $parvar[$i]['id']['val'] = '';
                    $parvar[$i]['no_aplikasi']['val'] = '';
                    $parvar[$i]['jenis']['val'] = '';
                    $parvar[$i]['catatan_cabang']['val'] = '';
                    $parvar[$i]['keterangan_overide']['val'] = [];
                    $parvar[$i]['status']['val'] = '';
                    $parvar[$i]['status_revise']['val'] = '';
                    $parvar[$i]['catatan_pusat']['val'] = '';
                    $parvar[$i]['trpenerima_manfaat_id']['val'] = '';
                    $parvar[$i]['users_id']['val'] = '';
                    $i++;
                }
                $i++;
            }
        } else {
            $parvar = [];
        }

        // cek data penerima manfaat dan overide status yang di miliki ts  
        $overidemanfaat = isset($parvar) ? $parvar : [];
        $catatan_cabang = isset($peserta->first()->catatan_cabang) ? $peserta->first()->catatan_cabang : '';
        $catatan_pusat = isset($peserta->first()->catatan_pusat) ? $peserta->first()->catatan_pusat : '';
        // status overide
        $status_approve = isset($peserta->first()->status) ? $peserta->first()->status : '';

        $keterangan_peserta = isset($peserta->first()->keterangan_overide) ? json_decode($peserta->first()->keterangan_overide) : [];

        $aplikasi = Tmaplikasi::join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id', 'left')
            ->join('tmhadiah', 'tmaplikasi.tmhadiah_id', '=', 'tmhadiah.id', 'left')
            ->where('no_aplikasi', $peserta->first()->no_aplikasi)->first();

        $nama_program = $aplikasi->nama_prog;
        $jenis_hadiah = $aplikasi->jenis_hadiah;

        $cabangusername = isset($overide->users_id) ? $overide->users_id : '';
        $pusatusername =  isset($overide->users_id) ? $overide->users_id : '';

        $tmhubungan = Trhubungan::get();


        // dd($data);

        return view($this->view . '.form_show', [
            'pmanfaat_data' => $data_penerima_manfaat,
            'title' => 'Tambah data nasbah',
            'program' => $tazamprogram,
            'id' => $data->id,
            'no_aplikasi' => $data->no_aplikasi,
            'no_ktp' => $data->no_ktp,
            'nama_sesuai_ktp' => $data->nama_sesuai_ktp,
            'tempat_lahir_ktp' => $data->tempat_lahir_ktp,
            'tanggal_lahir_ktp' => $data->tanggal_lahir_ktp,
            'jenis_kelamin_ktp' => $data->jenis_kelamin_ktp,
            'pekerjaan_ktp' => $data->pekerjaan_ktp,
            'status_pernikahan_ktp' => $data->status_pernikahan_ktp,
            'alamat_sesuai_ktp' => $data->alamat_sesuai_ktp,
            'rt_rw_ktp' => $data->rt_rw_ktp,
            'kelurahan_ktp' => $data->kelurahan_ktp,
            'kecamatan_ktp' => $data->kecamatan_ktp,
            'kode_kota_kabupaten_ktp' => $data->kode_kota_kabupaten_ktp,
            'kota_kabupaten_ktp' => $data->kota_kabupaten_ktp,
            'kode_provinsi_ktp' => $data->kode_provinsi_ktp,
            'provinsi_ktp' => $data->provinsi_ktp,
            'kode_pos_ktp' => $data->kode_pos_ktp,
            'alamat_domisili' => $data->alamat_domisili,
            'rt_rw_domisili' => $data->rt_rw_domisili,
            'kelurahan_domisili' => $data->kelurahan_domisili,
            'kecamatan_domisili' => $data->kecamatan_domisili,
            'kota_kabupaten_domisili' => $data->kota_kabupaten_domisili,
            'provinsi_domisili' => $data->provinsi_domisili,
            'kode_pos_domisili' => $data->kode_pos_domisili,
            'jenis_penduduk' => $data->jenis_penduduk,
            'kewarganegaraan' => $data->kewarganegaraan,
            'nama_ibu_kandung_ktp' => $data->nama_ibu_kandung_ktp,
            'agama' => $data->agama,
            'no_hp' => $data->no_hp,
            'email' => $data->email,
            'tlp_rumah' => $data->tlp_rumah,
            'penghasilan_perbulan' => $data->penghasilan_perbulan,
            'penghasilan_pertahun' => $data->penghasilan_pertahun,
            'pengeluaran_pertahun' => $data->pengeluaran_pertahun,
            'status_tempat_tinggal' => $data->status_tempat_tinggal,
            'jumlah_tanggungan' => $data->jumlah_tanggungan,
            'jenis' => $data->jenis,
            'tujuan_penggunaan' => $data->tujuan_penggunaan,
            'nama_kelurahan' => $data->nama_kelurahan,
            'nominal_setor_tunai' => $data->nominal_setor_tunai,
            'users_id' => $data->users_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'umur_peserta' => $data->umur_peserta,
            'status_approve' => $status_approve,
            'keterangan_overide_peserta' => $keterangan_peserta,
            'catatan_cabang' =>  $catatan_cabang,
            'catatan_pusat' =>  $catatan_pusat,
            'hubungan' => $tmhubungan,
            'cabangusername' => $cabangusername,
            'pusatusername' => $pusatusername,
            // data over penerima manfaat  
            'overidemanfaat' => $overidemanfaat,
            'nama_program' => $nama_program,
            'jenis_hadiah' => $jenis_hadiah,
            'tmparameter_id' => $aplikasi->tmparameter_id
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Tmnasabah::findOrfail($id);
        $tazamprogram = Tmparameter::get();

        $overide = Tmoveride::where('no_aplikasi', $data->no_aplikasi);

        if ($overide->count() < 0) return abort('404', 'Data overide nasabah tidak ada ');

        $peserta = Tmoveride::where([
            'no_aplikasi' => $data->no_aplikasi,
            'jenis' => 'peserta'
        ]);

        $pmanfaat =   $overide->where([
            'jenis' => 'pmanfaat'
        ])->first();

        $aplikasi_pmanfaat = isset($pmanfaat->no_aplikasi) ? $pmanfaat->no_aplikasi : '';
        $data_penerima_manfaat =  Trpenerimamanfaat::join(
            'tmhubungan', 
            'trpenerima_manfaat.hubungan',
            '=',
            'tmhubungan.id',
            'left'
        )->where('trpenerima_manfaat.no_aplikasi', $aplikasi_pmanfaat);

        if ($data_penerima_manfaat->count() > 0) {

            $i = 0;
            foreach ($data_penerima_manfaat->get() as $data_penerima_manfaats) {
                $parvar[$i]['nama']['val'] = $data_penerima_manfaats->nama;
                $parvar[$i]['usia']['val'] = $data_penerima_manfaats->usia;
                $parvar[$i]['hubungan']['val'] = $data_penerima_manfaats->jenis_hubungan;
                $parvar[$i]['jenis_hubungan']['val'] = $data_penerima_manfaats->jenis_hubungan;
                $parvar[$i]['tmhadiah_id']['val'] = $data_penerima_manfaats->tmhadiah;
                $parvar[$i]['no_hp']['val'] = $data_penerima_manfaats->no_hp;
                $parvar[$i]['email']['val'] = $data_penerima_manfaats->email;
                $parvar[$i]['alamat']['val'] = $data_penerima_manfaats->alamat;
                $parvar[$i]['pilihan_hadiah']['val'] = $data_penerima_manfaats->tmhadiah_id;

                // data overide 
                $openeriman_manfaat  =  Tmoveride::where([
                    'jenis' => 'pmanfaat',
                    'trpenerima_manfaat_id' => $data_penerima_manfaats->id
                ]);

                if ($openeriman_manfaat->count() > 0) {
                    foreach ($openeriman_manfaat->get() as $openeriman_manfaas) {
                        $parvar[$i]['id']['val'] = $openeriman_manfaas->id;
                        $parvar[$i]['no_aplikasi']['val'] = $openeriman_manfaas->no_aplikasi;
                        $parvar[$i]['jenis']['val'] = $openeriman_manfaas->jenis;
                        $parvar[$i]['catatan_cabang']['val'] = $openeriman_manfaas->catatan_cabang;
                        $parvar[$i]['keterangan_overide']['val'] = isset($openeriman_manfaas->keterangan_overide) ? $openeriman_manfaas->keterangan_overide : [];
                        $parvar[$i]['status']['val'] = $openeriman_manfaas->status;
                        $parvar[$i]['status_revise']['val'] = $openeriman_manfaas->status_revise;
                        $parvar[$i]['catatan_pusat']['val'] = $openeriman_manfaas->catatan_pusat;
                        $parvar[$i]['trpenerima_manfaat_id']['val'] = $openeriman_manfaas->trpenerima_manfaat_id;
                        $parvar[$i]['users_id']['val'] = $openeriman_manfaas->users_id;
                        $i++;
                    }
                } else {
                    $parvar[$i]['id']['val'] = '';
                    $parvar[$i]['no_aplikasi']['val'] = '';
                    $parvar[$i]['jenis']['val'] = '';
                    $parvar[$i]['catatan_cabang']['val'] = '';
                    $parvar[$i]['keterangan_overide']['val'] = [];
                    $parvar[$i]['status']['val'] = '';
                    $parvar[$i]['status_revise']['val'] = '';
                    $parvar[$i]['catatan_pusat']['val'] = '';
                    $parvar[$i]['trpenerima_manfaat_id']['val'] = '';
                    $parvar[$i]['users_id']['val'] = '';
                    $i++;
                }
                $i++;
            }
        } else {
            $parvar = [];
        }

        // cek data penerima manfaat dan overide status yang di miliki ts  
        $overidemanfaat = isset($parvar) ? $parvar : [];
        $catatan_cabang = isset($peserta->first()->catatan_cabang) ? $peserta->first()->catatan_cabang : '';
        $catatan_pusat = isset($peserta->first()->catatan_pusat) ? $peserta->first()->catatan_pusat : '';
        // status overide
        $status_approve = isset($peserta->first()->status) ? $peserta->first()->status : '';

        $keterangan_peserta = isset($peserta->first()->keterangan_overide) ? json_decode($peserta->first()->keterangan_overide) : [];

        $aplikasi = Tmaplikasi::join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id', 'left')
            ->join('tmhadiah', 'tmaplikasi.tmhadiah_id', '=', 'tmhadiah.id', 'left')
            ->where('no_aplikasi', $peserta->first()->no_aplikasi)->first();

        $nama_program = $aplikasi->nama_prog;
        $jenis_hadiah = $aplikasi->jenis_hadiah;

        $cabangusername = isset($overide->users_id) ? $overide->users_id : '';
        $pusatusername =  isset($overide->users_id) ? $overide->users_id : '';

        $tmhubungan = Trhubungan::get();


        // dd($data);

        return view($this->view . '.form_edit', [
            'pmanfaat_data' => $data_penerima_manfaat,
            'title' => 'Tambah data nasbah',
            'program' => $tazamprogram,
            'id' => $data->id,
            'no_aplikasi' => $data->no_aplikasi,
            'no_ktp' => $data->no_ktp,
            'nama_sesuai_ktp' => $data->nama_sesuai_ktp,
            'tempat_lahir_ktp' => $data->tempat_lahir_ktp,
            'tanggal_lahir_ktp' => $data->tanggal_lahir_ktp,
            'jenis_kelamin_ktp' => $data->jenis_kelamin_ktp,
            'pekerjaan_ktp' => $data->pekerjaan_ktp,
            'status_pernikahan_ktp' => $data->status_pernikahan_ktp,
            'alamat_sesuai_ktp' => $data->alamat_sesuai_ktp,
            'rt_rw_ktp' => $data->rt_rw_ktp,
            'kelurahan_ktp' => $data->kelurahan_ktp,
            'kecamatan_ktp' => $data->kecamatan_ktp,
            'kode_kota_kabupaten_ktp' => $data->kode_kota_kabupaten_ktp,
            'kota_kabupaten_ktp' => $data->kota_kabupaten_ktp,
            'kode_provinsi_ktp' => $data->kode_provinsi_ktp,
            'provinsi_ktp' => $data->provinsi_ktp,
            'kode_pos_ktp' => $data->kode_pos_ktp,
            'alamat_domisili' => $data->alamat_domisili,
            'rt_rw_domisili' => $data->rt_rw_domisili,
            'kelurahan_domisili' => $data->kelurahan_domisili,
            'kecamatan_domisili' => $data->kecamatan_domisili,
            'kota_kabupaten_domisili' => $data->kota_kabupaten_domisili,
            'provinsi_domisili' => $data->provinsi_domisili,
            'kode_pos_domisili' => $data->kode_pos_domisili,
            'jenis_penduduk' => $data->jenis_penduduk,
            'kewarganegaraan' => $data->kewarganegaraan,
            'nama_ibu_kandung_ktp' => $data->nama_ibu_kandung_ktp,
            'agama' => $data->agama,
            'no_hp' => $data->no_hp,
            'email' => $data->email,
            'tlp_rumah' => $data->tlp_rumah,
            'penghasilan_perbulan' => $data->penghasilan_perbulan,
            'penghasilan_pertahun' => $data->penghasilan_pertahun,
            'pengeluaran_pertahun' => $data->pengeluaran_pertahun,
            'status_tempat_tinggal' => $data->status_tempat_tinggal,
            'jumlah_tanggungan' => $data->jumlah_tanggungan,
            'jenis' => $data->jenis,
            'tujuan_penggunaan' => $data->tujuan_penggunaan,
            'nama_kelurahan' => $data->nama_kelurahan,
            'nominal_setor_tunai' => $data->nominal_setor_tunai,
            'users_id' => $data->users_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'umur_peserta' => $data->umur_peserta,
            'status_approve' => $status_approve,
            'keterangan_overide_peserta' => $keterangan_peserta,
            'catatan_cabang' =>  $catatan_cabang,
            'catatan_pusat' =>  $catatan_pusat,
            'hubungan' => $tmhubungan,
            'cabangusername' => $cabangusername,
            'pusatusername' => $pusatusername,
            // data over penerima manfaat  
            'overidemanfaat' => $overidemanfaat,
            'nama_program' => $nama_program,
            'jenis_hadiah' => $jenis_hadiah,
            'tmparameter_id' => $aplikasi->tmparameter_id
        ]);
    }

    public function savedata()
    {
        // dd($this->request->all());
        try {
            $no_aplikasi = $this->request->no_aplikasi;
            $catatan = $this->request->catatan;
            $catatan_pmanfaat = $this->request->catatan_pmanfaat;
            $status = $this->request->status;
            // passed var 
            $overide = Tmoveride::where([
                'no_aplikasi' => $no_aplikasi,
            ])->get();
            foreach ($overide as $overides) {
                if ($overides->jenis == 'pmanfaat') {
                    if (Tmparamtertr::session('role') == 'manageroperation') {
                        foreach ($catatan_pmanfaat as $key) {
                            Tmoveride::where([
                                'no_aplikasi' => $no_aplikasi,
                                'jenis' => 'pmanfaat',
                            ])->update([
                                'catatan_cabang' => $key,
                                'status' => $status
                            ]);
                        }
                    } elseif (Tmparamtertr::session('role') == 'businessdevelopment') {
                        foreach ($catatan_pmanfaat as  $value) {
                            Tmoveride::where([
                                'no_aplikasi' => $no_aplikasi,
                                'jenis' => 'pmanfaat',

                            ])->update([
                                'catatan_pusat' => $value,
                                'status' => $status

                            ]);
                        }
                    }
                }
                if ($overides->jenis == 'peserta') {
                    if (Tmparamtertr::session('role') == 'manageroperation') {
                        Tmoveride::where([
                            'no_aplikasi' => $no_aplikasi,
                            'jenis' => 'peserta'
                        ])->update([
                            'catatan_cabang' => $catatan,
                            'status' => $status
                        ]);
                    } elseif (Tmparamtertr::session('role') == 'businessdevelopment') {
                        Tmoveride::where([
                            'no_aplikasi' => $no_aplikasi,
                            'jenis' => 'peserta'
                        ])->update([
                            'catatan_pusat' => $catatan,
                            'status' => $status
                        ]);
                    }
                }
            }


            if ($status == 5) {

                $aplikasi = Tmaplikasi::where('no_aplikasi', $no_aplikasi)->first();
                $aplikasi->overide = 0;
                $aplikasi->user_id = session::get('username');
                $aplikasi->created_at = Carbon::now();
                $aplikasi->updated_at = Carbon::now();
                $aplikasi->save();
                // hapus list data dari overide 
                Tmoveride::whereIn(
                    'jenis',
                    ['peserta', 'pmanfaat']
                )->where([
                    'no_aplikasi' => $no_aplikasi,
                ])->delete();
                // indikasi notifikasi awal sms sudah selesai
                Tmparamtertr::setstatus(
                    [
                        'no_ap' => $no_aplikasi,
                        'status' => 11,
                        'kode' => 11,
                    ]
                );
            }
            return response()->json([
                'status' => 1,
                'message' => 'data berhasil di simpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
