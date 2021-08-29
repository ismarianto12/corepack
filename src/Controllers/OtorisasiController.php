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
use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;

use Ismarianto\Ismarianto\Traits\NasabahApirek;
use Ismarianto\Ismarianto\Traits\Overide;
// use Tmoveride;
use DataTables;
use Illuminate\Support\Facades\Session;
// use Ismarianto\Ismarianto\Models\Tmupload_document_jaminan;
use Ismarianto\Ismarianto\Models\Tmupload_document;
// use Tmparameterdoc
use Ismarianto\Ismarianto\Models\Tmparameterdoc;
use Ismarianto\Ismarianto\Models\Trotorisasi;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Form;
use Ismarianto\Ismarianto\Lib\StatusApp;
use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Tmupload_jaminan;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;
use Ismarianto\Ismarianto\Models\Trstatus_otorisasi;

class OtorisasiController extends Controller
{

    public $request;
    public $view;
    public $route;

    function __construct(Request $request)
    {

        $this->request = $request;
        $this->view = 'tazamcore::.otorisasi.';
        $this->route = 'otorisasi.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get data nasabha dengan statuS 2
        return view($this->view . 'index', [
            'title' =>  'Data Otorisasi'
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
        try {
            // dd($this->request->all());
            $no_aplikasi = $this->request->no_aplikasi;
            $data = Tmnasabah::join('tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi', 'left')
                ->where('tmnasabah.no_aplikasi', $no_aplikasi)->first();

            if ($this->request->otorisasi == 'cabang') {
                $catatan = $this->request->catatan;
                $otorisasi = $this->request->otorisasi;
            } else if ($this->request->otorisasi == 'pusat') {
                $catatan = $this->request->catatan;
                $otorisasi = $this->request->otorisasi;
            }
            Trotorisasi::updateOrCreate([
                'no_aplikasi' => $this->request->input('no_aplikasi'),
                'tmaplikasi_id' => $data->tmaplikasi_id,
                'otorisasi_cabang' => $otorisasi,
                'catatan_cabang' => $catatan,
                'otorisasi_pusat' => $otorisasi,
                'catatan_pusat' => $catatan,
                'user_id' => session::get('username'),
            ]);

            // set action 
            Tmparamtertr::setstatus(
                [
                    'no_ap' => $no_aplikasi,
                    'posisi' => 'Input data nasabah',
                    'status' => 7,
                    'kode' => 7,
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function api()
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
        return \DataTables::of($data)
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-info btn-sm" id="lengkapi" data-id="' . $p->no_aplikasi . '" title="Upload Document Jamninan Nasabah"><i class="fa fa-upload"></i></a> ';
            }, true)
            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return  '<a href="" class="btn btn-danger btn-sm" ><i class="fa fa-refresh"></i>' . $percent . '</a> ';
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<button class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</button>';
            }, true)
            ->editColumn('waktu_input', function ($p) {
                $get = Trotorisasi::where('no_aplikasi', $p->no_aplikasi)->first();
                $fk = isset($get->created_at) ? $get->created_at : $p->create_at;
                $g = date('Y-m-d', strtotime($fk));
                return $g;
            }, true)
            ->editColumn('user_id', function ($p) {
                return ($p->users_id) ? ucfirst($p->users_id) : 'Kosong';
            }, true)
            ->editColumn('status', function ($p) {
                return $p->keterangan_status;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'progress', 'waktu_input', 'user_id', 'status', 'j_manfaat'])
            ->toJson();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nasabah = Tmnasabah::select(
            'tmnasabah.no_aplikasi',
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_ktp',
            'tmnasabah.tempat_lahir_ktp',
            'tmnasabah.tanggal_lahir_ktp',
            'tmnasabah.jenis_kelamin_ktp',
            'tmnasabah.pekerjaan_ktp',
            'tmnasabah.status_pernikahan_ktp',
            'tmnasabah.alamat_sesuai_ktp',
            'tmnasabah.rt_rw_ktp',
            'tmnasabah.kelurahan_ktp',
            'tmnasabah.kecamatan_ktp',
            'tmnasabah.kode_kota_kabupaten_ktp',
            'tmnasabah.kota_kabupaten_ktp',
            'tmnasabah.kode_provinsi_ktp',
            'tmnasabah.provinsi_ktp',
            'tmnasabah.kode_pos_ktp',
            'tmnasabah.alamat_domisili',
            'tmnasabah.rt_rw_domisili',
            'tmnasabah.kelurahan_domisili',
            'tmaplikasi.tmparameter_id',
            'tmaplikasi.tmhadiah_id'
            // '' 
        )->join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->where('tmaplikasi.no_aplikasi', $id)->first();
        $tazamprogram = Tmparameter::get();

        $data_penerima_manfaat =  Trpenerima_manfaat::where('no_aplikasi', $nasabah->no_aplikasi)->get();
        $penmanfaat = Trpenerima_manfaat::select(
            'tmhadiah.jenis_hadiah',
            'trpenerima_manfaat.no_aplikasi',
            'trpenerima_manfaat.nama',
            'trpenerima_manfaat.id as pmnanfaat_id',
            'trpenerima_manfaat.usia',
            'trpenerima_manfaat.hubungan',
            'trpenerima_manfaat.tmhadiah_id',
            'trpenerima_manfaat.no_hp',
            'trpenerima_manfaat.email',
            'trpenerima_manfaat.alamat',
            'trpenerima_manfaat.users_id',
            'trpenerima_manfaat.tgl_lahir'
        )->join('tmhadiah', 'trpenerima_manfaat.tmhadiah_id', '=', 'tmhadiah.id', 'left')
            ->where('no_aplikasi', $nasabah->no_aplikasi)
            ->get();

        $document  = Tmupload_document::select(
            'tmparameter_doc.id as id_par',
            'tmparameter_doc.kode',
            'tmparameter_doc.nama_doc',
            'tmparameter_doc.category',
            'tmparameter_doc.status',
            'tmparameter_doc.tmhadiah_id',
            'tmparameter_doc.users_id',
            'tmupload_document.id',
            'tmupload_document.tmparameter_id',
            'tmupload_document.no_aplikasi',
            'tmupload_document.keterangan_file',
            'tmupload_document.nama_file',
            'tmupload_document.tmparameter_doc_id',
            'tmupload_document.users_id',
            'tmupload_document.created_at',
            'tmupload_document.updated_at'
        )->join(
            'tmparameter_doc',
            'tmparameter_doc.id',
            '=',
            'tmupload_document.tmparameter_id'
        )->get();


        // table data  otorisasi   
        $no_aplikasi = $nasabah->no_aplikasi;
        $status = $this->request->kode;
        // role session
        $session = Tmparamtertr::session('role');
        $pesertadoc = Tmparameterdoc::where([
            'tmparameter_doc.category' => 'document',
            'tmparameter_doc.kode' =>  'peserta',
            'tmparameter_doc.tmhadiah_id' => $nasabah->tmhadiah_id,
        ])->get();

        $penmanfaat_doc = Tmparameterdoc::where([
            'tmparameter_doc.category' => 'document',
            'tmparameter_doc.kode' => 'pmanfaat',
            'tmparameter_doc.tmhadiah_id' => $nasabah->tmhadiah_id,
        ])->get();

        // dd($pesertadoc);

        $j = 0;
        foreach ($pesertadoc as $datadoc) {
            // file data   
            $file_upload = Tmupload_document::where([
                'tmparameter_doc_id' => $datadoc->id,
                'status_file' => 'peserta',
                'no_aplikasi' => $no_aplikasi
            ])->first();

            $parsed_data[$j]['id_par']['val'] = $datadoc['id'];
            $parsed_data[$j]['nama_doc']['val'] = $datadoc['nama_doc'];
            $parsed_data[$j]['category']['val'] = $datadoc['category'];
            $parsed_data[$j]['status']['val'] = $datadoc['status'];
            $parsed_data[$j]['tmhadiah_id']['val'] = $datadoc['tmhadiah_id'];
            // chceck jika

            $parsed_data[$j]['otorisasi_cabang']['val'] = isset($file_upload->otorisasi_cabang) ? $file_upload->otorisasi_cabang : '';
            $parsed_data[$j]['catatan_cabang']['val'] = isset($file_upload['catatan_cabang']) ? $file_upload['catatan_cabang'] : '';
            // 
            $parsed_data[$j]['nama_file']['val'] = isset($file_upload['nama_file']) ? $file_upload['nama_file'] : '';

            // document 
            $parsed_data[$j]['otorisasi_pusat']['val'] = isset($file_upload->otorisasi_pusat) ? $file_upload->otorisasi_pusat : '';
            $parsed_data[$j]['catatan_pusat']['val'] = isset($file_upload['catatan_pusat']) ? $file_upload['catatan_pusat'] : '';
            $j++;
        }

        // penerima manfaat 
        $r = 0;
        foreach ($penmanfaat_doc as $penmanfaats) {

            // file data   
            $ffile_upload = Tmupload_document::where([
                // 'tmparameter_doc_id' => $datadoc->id,
                'status_file' => 'pmanfaat',
                'no_aplikasi' => $no_aplikasi
            ])->first();

            $penmanfaatdata[$r]['id_par']['val'] = $penmanfaats['id'];
            $penmanfaatdata[$r]['nama_doc']['val'] = $penmanfaats['nama_doc'];
            $penmanfaatdata[$r]['category']['val'] = $penmanfaats['category'];
            $penmanfaatdata[$r]['status']['val'] = $penmanfaats['status'];
            $penmanfaatdata[$r]['tmhadiah_id']['val'] = $penmanfaats['tmhadiah_id'];

            $penmanfaatdata[$r]['otorisasi_cabang']['val'] = isset($ffile_upload['otorisasi_cabang']) ? $ffile_upload['otorisasi_cabang'] : '';
            $penmanfaatdata[$r]['catatan_cabang']['val'] = isset($ffile_upload['catatan_cabang']) ? $ffile_upload['catatan_cabang'] : '';
            // 
            $penmanfaatdata[$r]['nama_file']['val'] = isset($file_upload['keterangan_file']) ? $file_upload['keterangan_file'] : '';

            // document 
            $penmanfaatdata[$r]['otorisasi_pusat']['val'] = isset($ffile_upload['otorisasi_pusat']) ? $ffile_upload['otorisasi_pusat'] : '';
            $penmanfaatdata[$r]['catatan_pusat']['val'] = isset($ffile_upload['catatan_pusat']) ? $ffile_upload['catatan_pusat'] : '';
            $r++;
        }
        // get status approve 
        $status_approve = Trstatus_otorisasi::where('no_aplikasi', $no_aplikasi)->first();


        $status_otorisasi = isset($status_approve->status_approve) ? $status_approve->status_approve : '';

        $dpeserta = isset($parsed_data) ? $parsed_data : 0;
        $dmanfaat = isset($penmanfaatdata) ? $penmanfaatdata : 0;

        $jenhadiah = ($nasabah->tmhadiah_id == 1) ? 'Haji' : 'Lainya';


        // end data  
        return view($this->view . 'form_edit', [
            // line to nasabah
            'title' => 'Otorisasi file data peserta',
            'id' => $nasabah->id,
            'no_aplikasi' => $nasabah->no_aplikasi,
            'tmparameter_id' => $nasabah->tmparameter_id,
            'no_ktp' => $nasabah->no_ktp,
            'nama_sesuai_ktp' => $nasabah->nama_sesuai_ktp,
            'tempat_lahir_ktp' => $nasabah->tempat_lahir_ktp,
            'tanggal_lahir_ktp' => $nasabah->tanggal_lahir_ktp,
            'jenis_kelamin_ktp' => $nasabah->jenis_kelamin_ktp,
            'hadiah' => ($nasabah->tmhadiah_id == 1) ? 'Haji' : 'Lainya',
            'getpenerimamanfaat' => $penmanfaat,
            'fieldcolump' => $document,
            'pmanfaat_data' => $penmanfaat,
            'dpeserta' => $dpeserta,
            'dmanfaat' => $dmanfaat,
            'status_otorisasi' => $status_otorisasi,
            'nasabah' => $nasabah->first(),
            'jnasabah' => $nasabah->count(),
            'level' => $session,
            'data_penerima_manfaat' => $penmanfaat,
            'status' => $status,
            'hadiah' => $jenhadiah
        ]);
    }


    public function savedata($no_apl)
    {


        if ($this->request->ajax()) {
            $level = Tmparamtertr::session('role');
            if (in_array($level, ['manageroperation', 'internalcontrol'])) {


                $status = $this->request->status;
                $catatan = $this->request->catatan;
                $status_approve = $this->request->status_approve;

                $data =  [
                    1 => 'Di teruskan ke Pusat',
                    2 => 'Revise Ke marketing',
                    3 => 'Revise Ke Cabang',
                    4 => 'Reject',
                    5 => 'Approved Pusat'

                ];
 
                switch ($status_approve) {
                    case 1:
                        $fval =  16;
                        break;
                    case 2:
                        $fval =  15;
                        break;
                    case 3:
                        $fval =  17;

                        break;
                    case 4:
                        $fval =  18;

                        break;
                    case 5:
                        $fval = 19;
                        break;
                    default:
                        $fval = 0;
                        break;
                }

                $no = 0;
                $j = 1;

                $jf = 0;
                foreach ($status as $stat => $statval) {
                    $fileny = Tmparameterdoc::find($stat);
                    $pardata[$jf]['catatan']['val'] = $this->request->input('catatan_' . $jf);
                    $pardata[$jf]['status']['val'] = $statval;
                    $pardata[$jf]['tmparameter_doc_id']['val'] = $stat;
                    $pardata[$jf]['nama_file']['val'] = isset($fileny->nama_doc) ? $fileny->nama_doc : '';
                    $jf++;
                }

                // dd($pardata);
                $parameter_doc  = '';
                foreach ($pardata as $val => $key) {

                    if ($level == 'manageroperation') {
                        $sesuai[] =  $key['status']['val'] == 0 ? $key['status']['val'] : 0;
                        $tidak_sesuai[] =   $key['status']['val'] == 1 ? $key['status']['val'] : 0;
                        $pdata = [
                            'no_aplikasi' => $no_apl,
                            'otorisasi_cabang' => $key['status']['val'],
                            'catatan_cabang' => $key['catatan']['val'],
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                            'status_file' => 'peserta',
                        ];
                    } elseif ($level == 'internalcontrol') {
                        $sesuai[] =  $key['status']['val'] == 0 ? $key['status']['val'] : 0;
                        $tidak_sesuai[] =   $key['status']['val'] == 1 ? $key['status']['val'] : 0;
                        $pdata = [
                            'no_aplikasi' => $no_apl,
                            'otorisasi_pusat' =>  $key['status']['val'],
                            'catatan_pusat' => $key['catatan']['val'],
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                            'status_file' => 'peserta',

                        ];
                    }
                    $d = Tmupload_document::where(
                        [
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                            'no_aplikasi' => $no_apl,
                        ]
                    );
                    // dd($pdata);
                    $d->update($pdata);
                    $no++;
                    $parameter_doc  .=  $key['tmparameter_doc_id']['val'];
                }
                // pmnafaat 

                $pmanfaat = 1;
                $jpmanfaat = 0;
                $pmanfaatdata = Trpenerimamanfaat::where('no_aplikasi', $no_apl)->get();
                foreach ($pmanfaatdata as $pmanfaatdatas) {
                    $status_pmanfaat = $this->request->post('status_pmanfaat' . $pmanfaat . $pmanfaatdatas->id);
                    $catatan_pmanfaat = $this->request->post('catatan_pmanfaat' . $pmanfaat  . $pmanfaatdatas->id);
                    $no = 0;
                    $j = 1;
                    $g = 0;

                    // dd('status_pmanfaat' . $catatan_pmanfaat);
                    foreach ($status_pmanfaat as $stat => $statval) {
                        $fileny = Tmparameterdoc::find($stat);
                        $fpmanfaat[$g]['catatan']['val'] = $catatan_pmanfaat;
                        $fpmanfaat[$g]['status']['val'] = $statval;
                        $fpmanfaat[$g]['tmparameter_doc_id']['val'] = $stat;
                        $fpmanfaat[$g]['nama_file']['val'] = $fileny['nama_doc'];
                        $jf++;
                    }

                    $parameter_doc  = '';
                    foreach ($fpmanfaat as $val => $key) {

                        if ($level == 'manageroperation') {
                            $sesuai[] =  $key['status']['val'] == 0 ? $key['status']['val'] : 0;
                            $tidak_sesuai[] =   $key['status']['val'] == 1 ? $key['status']['val'] : 0;
                            $arrdata = [
                                'no_aplikasi' => $no_apl,
                                'otorisasi_cabang' => $key['status']['val'],
                                'catatan_cabang' => $key['catatan']['val'],
                                'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                                'status_file' => 'pmanfaat'
 
                            ];
                        } elseif ($level == 'internalcontrol') {
                            $sesuai[] =  $key['status']['val'] == 0 ? $key['status']['val'] : 0;
                            $tidak_sesuai[] =   $key['status']['val'] == 1 ? $key['status']['val'] : 0;
                            $arrdata = [
                                'no_aplikasi' => $no_apl,
                                'otorisasi_pusat' =>  $key['status']['val'],
                                'catatan_pusat' => $key['catatan']['val'],
                                'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                                'status_file' => 'pmanfaat'
                           
                            ];
                        }
                        $d = Tmupload_document::where(
                            [
                                'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                                'no_aplikasi' => $no_apl,
                            ]
                        );
                        // dd($arrdata);
                        $d->update($arrdata);

                        $no++;
                        $parameter_doc  .=  $key['tmparameter_doc_id']['val'];
                    }
                    // finalisasi otorisasi
                    $no_aplikasi = $no_apl;
                    $trstatus_otorisasi = Trstatus_otorisasi::where([
                        'no_aplikasi' => $no_apl,
                        'kategory_doc' => 'kelengkapan'
                    ]);


                    if (Tmparamtertr::session('role') == 'manageroperation') {
                        $arr_stat = [
                            'catatan_cabang' => $this->request->catat_otorisasi
                        ];
                    } else if (Tmparamtertr::session('role') == 'internalcontrol') {
                        $arr_stat = [
                            'catatan_pusat' => $this->request->catat_otorisasi
                        ];
                    }

                    if ($trstatus_otorisasi->count() > 0) {

                        $a = array_merge($arr_stat, [
                            'no_aplikasi' => $no_aplikasi,
                            'status_approve' => $status_approve,
                            'kategory_doc' => 'kelengkapan',
                            'keterangan' => $fval

                        ]);
                        $trstatus_otorisasi->first()->update($a);
                    } else {
                        $b = array_merge($arr_stat, [
                            'no_aplikasi' => $no_aplikasi,
                            'status_approve' => $status_approve,
                            'kategory_doc' => 'kelengkapan',
                            'keterangan' => $fval
                        ]);
                        Trstatus_otorisasi::create($b);
                    }
                    $pmanfaat++;
                }

                // jika status di revise ke marketin maka set file kelenkapan jadi null lagi
                if ($fval = 15 ||
                    $fval = 16 ||
                    $fval = 19
                ) {
                    Tmaplikasi::where([
                        'no_aplikasi' => $no_apl
                    ])->update(['document_kelengkapan' => '']);
                } else {
                    Tmaplikasi::where([
                        'no_aplikasi' => $no_apl
                    ])->update(['document_kelengkapan' => 1]);
                }
                Tmparamtertr::setstatus(
                    [
                        'no_ap' => $no_apl,
                        'status' => $fval,
                        'kode' => $fval,
                    ]
                );

                // dd($this->request->status_approve.'<br />'.$val);

                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di verifikasi'
                ]);
            } else {
                return response()->json([
                    'status' => 2,
                    'msg' => 'Gagal Permision denied otorisasi hanya cabagn dan kantor pusat ic'
                ]);
            }
        }
    }

    public function tableotorisasi($no_aplikasi)
    {
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
