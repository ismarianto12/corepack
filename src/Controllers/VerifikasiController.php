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
use Ismarianto\Ismarianto\Models\Tmparameter as ModelsTmparameter;
use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Ismarianto\Ismarianto\Models\Tmupload_jaminan;

use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Tmsla;
use Ismarianto\Ismarianto\Models\Troveride;
use Ismarianto\Ismarianto\Models\Trotorisasi;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;
use Ismarianto\Ismarianto\Models\Trstatus_otorisasi;

class VerifikasiController extends controller
{

    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::datajaminan.';
        $this->route   = 'datajaminan.';
        $this->primary_id = PhareSpase::createtazamid();
    }
    public function index()
    {
        $title = 'Verifikasi document jamiman';

        $parsed =  'veryfied';
        $view = 'ismarianto::verifikasi_kelengkapan.index';
        return view(
            $view,
            [
                'title' => $title,
                'parsed' => $parsed
            ]
        );
    }
    public function api($verifikasi = null)
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
        }
        return \DataTables::of($data)
            ->editColumn('action', function ($p) use ($verifikasi) {
                return '<a href="" class="btn btn-info btn-sm" id="lengkapi" data-id="' . $p->no_aplikasi . '" title="Verifikasi Jamninan Nasabah"><i class="fa fa-check"></i></a> ';
            }, true)
            ->editColumn('progress', function ($p) {

                $percent  = StatusApp::percentage($p->no_aplikasi);
                return  '<a href="" class="btn btn-warning btn-sm" id="lengkapi" data-id="' . $p->no_aplikasi . '"><i class="fa fa-refresh"></i>' . $percent . '</a> ';
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<button class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</button>';
            }, true)

            ->editColumn('waktu_input', function ($p) {
                $g = date('Y-m-d H:i:s', strtotime($p->created_at));
                return $g;
            }, true)
            ->editColumn('user_id', function ($p) {
                return ucfirst($p->users_id);
            }, true)
            ->editColumn('status', function ($p) {
                return '<b>(' . $p->keterangan_status . ')</b>';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'progress', 'waktu_input', 'user_id', 'status', 'j_manfaat'])
            ->toJson();
    }

    public function edit($no_apl, $page = null)
    {
        $nasabah = Tmnasabah::select(
            'tmaplikasi.tmhadiah_id',
            'tmnasabah.no_aplikasi',

            'tmnasabah.id',
            'tmnasabah.no_aplikasi',
            'tmnasabah.no_ktp',
            'tmnasabah.nama_sesuai_ktp',
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
            'tmnasabah.kecamatan_domisili',
            'tmnasabah.kota_kabupaten_domisili',
            'tmnasabah.provinsi_domisili',
            'tmnasabah.kode_pos_domisili',
            'tmnasabah.jenis_penduduk',
            'tmnasabah.kewarganegaraan',
            'tmnasabah.nama_ibu_kandung_ktp',
            'tmnasabah.agama',
            'tmnasabah.no_hp',
            'tmnasabah.email',
            'tmnasabah.tlp_rumah',
            'tmnasabah.penghasilan_perbulan',
            'tmnasabah.penghasilan_pertahun',
            'tmnasabah.pengeluaran_pertahun',
            'tmnasabah.status_tempat_tinggal',
            'tmnasabah.jumlah_tanggungan',
            'tmnasabah.kategori_nasabah',
            'tmnasabah.tujuan_penggunaan',
            'tmnasabah.nama_kelurahan',
            'tmnasabah.umur_peserta',
            'tmnasabah.status_peserta',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            'tmnasabah.updated_at',
            'tmhadiah.jenis_hadiah',
            'tmparameter.nama_prog',
            'tmaplikasi.tmparameter_id'

        )->join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id')
            ->join('tmhadiah', 'tmaplikasi.tmhadiah_id', '=', 'tmhadiah.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap', 'left')
            ->join('tmstatus_aplikasi', 'tmstatus_aplikasi.id', '=', 'tmsla.tmstatus_aplikasi_id')
            ->where('tmnasabah.no_aplikasi', $no_apl)
            ->firstOrFail();
        // data

        // dd($nasabah);
        $no_aplikasinasabah = $nasabah->no_aplikasi;

        $penmanfaat = Trpenerima_manfaat::where('trpenerima_manfaat.no_aplikasi', $no_aplikasinasabah)->get();

        $document = Tmparameterdoc::where([
            'tmparameter_doc.category' => 'jaminan',
            'tmparameter_doc.kode' => 'Peserta',
            'tmparameter_doc.tmhadiah_id' => $nasabah->tmhadiah_id,
        ])->get();

        // @dd($document->count());
        $j = 0;
        foreach ($document as $datadoc) {
            $ffilejaminan = Tmupload_jaminan::where('no_aplikasi', $no_aplikasinasabah)->first();

            $upload_jaminan = Trotorisasi::where([
                'kategori_file' => 'Jaminan',
                'tmparameter_doc_id' => $datadoc['id'],
                'no_aplikasi' => $no_apl
            ])->first();

            $parsed_data[$j]['id_par']['val'] = $datadoc['id'];
            $parsed_data[$j]['nama_doc']['val'] = $datadoc['nama_doc'];
            $parsed_data[$j]['category']['val'] = $datadoc['category'];
            $parsed_data[$j]['status']['val'] = $datadoc['status'];
            $parsed_data[$j]['tmhadiah_id']['val'] = $datadoc['tmhadiah_id'];
            $parsed_data[$j]['keterangan_file']['val'] =  $ffilejaminan['keterangan_file'];

            $parsed_data[$j]['otorisasi_cabang']['val'] = isset($upload_jaminan['otorisasi_cabang']) ? $upload_jaminan['otorisasi_cabang'] : '';
            $parsed_data[$j]['catatan_cabang']['val'] = isset($upload_jaminan['catatan_cabang']) ? $upload_jaminan['catatan_cabang'] : '';
            // 
            $parsed_data[$j]['otorisasi_pusat']['val'] = isset($upload_jaminan['otorisasi_pusat']) ? $upload_jaminan['otorisasi_pusat'] : '';
            $parsed_data[$j]['catatan_pusat']['val'] = isset($upload_jaminan['catatan_pusat']) ? $upload_jaminan['catatan_pusat'] : '';
            $j++;
        }

        $fparsed_data = isset($parsed_data) ? $parsed_data : [];

        $approve_status = Trstatus_otorisasi::where('no_aplikasi', $no_apl)->first();
        $level = Tmparamtertr::session('role');
        $view_parsing = 'ismarianto::verifikasi_kelengkapan.form_edit';

        $trstatus_otorisasi = Trstatus_otorisasi::where([
            'no_aplikasi' => $no_apl,
            'kategory_doc' => 'Jaminan',
        ])->first();

        $filejaminan = Tmupload_jaminan::where('no_aplikasi', $no_apl)->get();

        return view($view_parsing, [
            'id' => $nasabah->id,
            'no_aplikasi' => $nasabah->no_aplikasi,
            'tmparameter_id' => $nasabah->tmparameter_id,
            'no_ktp' => $nasabah->no_ktp,
            'nama_sesuai_ktp' => $nasabah->nama_sesuai_ktp,
            'tempat_lahir_ktp' => $nasabah->tempat_lahir_ktp,
            'tanggal_lahir_ktp' => $nasabah->tanggal_lahir_ktp,
            'jenis_kelamin_ktp' => $nasabah->jenis_kelamin_ktp,
            'pekerjaan_ktp' => $nasabah->pekerjaan_ktp,
            'status_pernikahan_ktp' => $nasabah->status_pernikahan_ktp,
            'alamat_sesuai_ktp' => $nasabah->alamat_sesuai_ktp,
            'rt_rw_ktp' => $nasabah->rt_rw_ktp,
            'kelurahan_ktp' => $nasabah->kelurahan_ktp,
            'kecamatan_ktp' => $nasabah->kecamatan_ktp,
            'kode_kota_kabupaten_ktp' => $nasabah->kode_kota_kabupaten_ktp,
            'kota_kabupaten_ktp' => $nasabah->kota_kabupaten_ktp,
            'kode_provinsi_ktp' => $nasabah->kode_provinsi_ktp,
            'provinsi_ktp' => $nasabah->provinsi_ktp,
            'kode_pos_ktp' => $nasabah->kode_pos_ktp,
            'alamat_domisili' => $nasabah->alamat_domisili,
            'rt_rw_domisili' => $nasabah->rt_rw_domisili,
            'kelurahan_domisili' => $nasabah->kelurahan_domisili,
            'kecamatan_domisili' => $nasabah->kecamatan_domisili,
            'kota_kabupaten_domisili' => $nasabah->kota_kabupaten_domisili,
            'provinsi_domisili' => $nasabah->provinsi_domisili,
            'kode_pos_domisili' => $nasabah->kode_pos_domisili,
            'jenis_penduduk' => $nasabah->jenis_penduduk,
            'kewarganegaraan' => $nasabah->kewarganegaraan,
            'nama_ibu_kandung_ktp' => $nasabah->nama_ibu_kandung_ktp,
            'agama' => $nasabah->agama,
            'no_hp' => $nasabah->no_hp,
            'email' => $nasabah->email,
            'tlp_rumah' => $nasabah->tlp_rumah,
            'penghasilan_perbulan' => $nasabah->penghasilan_perbulan,
            'penghasilan_pertahun' => $nasabah->penghasilan_pertahun,
            'pengeluaran_pertahun' => $nasabah->pengeluaran_pertahun,
            'status_tempat_tinggal' => $nasabah->status_tempat_tinggal,
            'jumlah_tanggungan' => $nasabah->jumlah_tanggungan,
            'kategori_nasabah' => $nasabah->kategori_nasabah,
            'tujuan_penggunaan' => $nasabah->tujuan_penggunaan,
            'nama_kelurahan' => $nasabah->nama_kelurahan,
            'umur_peserta' => $nasabah->umur_peserta,
            'status_peserta' => $nasabah->status_peserta,
            'hadiah' => ($nasabah->tmhadiah_id == 1) ? 'Haji' : 'Lainya',
            'jenis_hadiah' => $nasabah->jenis_hadiah,
            //line penerima manfaat
            'pmanfaat_data' => $penmanfaat,
            'document' => $fparsed_data,
            'approve_status' => isset($approve_status['status_approve']) ? $approve_status['status_approve'] : '',
            'level' => $level,
            'status_approve' => '', //($trstatus_otorisasi->status_approve) ? $trstatus_otorisasi->status_approve : ' ',
            'tmparametername' => $nasabah->nama_prog,
            'kode_prog' => $nasabah->kode_prog,
            'tmparameter_id' => $nasabah->tmparameter_id,
            'filejaminan' => $filejaminan
        ]);
    }
    public function update($no_apl)
    {
        if ($this->request->ajax()) {
            $level = Tmparamtertr::session('role');
            if (in_array($level, ['manageroperation', 'internalcontrol'])) {

                $status = $this->request->status;
                $catatan = $this->request->catatan;
                $no = 0;
                $j = 1;

                $jf = 0;
                foreach ($status as $stat => $statval) {
                    $fileny = Tmparameterdoc::find($stat);
                    $pardata[$jf]['catatan']['val'] = $this->request->input('catatan_' . $jf);
                    $pardata[$jf]['status']['val'] = $statval;
                    $pardata[$jf]['tmparameter_doc_id']['val'] = $stat;
                    $pardata[$jf]['nama_file']['val'] = $fileny['nama_doc'];
                    $jf++;
                }

                $parameter_doc  = '';
                foreach ($pardata as $val => $key) {

                    if ($level == 'manageroperation') {
                        $sesuai[] =  $key['status']['val'] == 0 ? $key['status']['val'] : 0;
                        $tidak_sesuai[] =   $key['status']['val'] == 1 ? $key['status']['val'] : 0;
                        $arrdata = [
                            'no_aplikasi' => $no_apl,
                            'otorisasi_cabang' => $key['status']['val'],
                            'catatan_cabang' => $key['catatan']['val'],
                            'kategori_file' => 'Jaminan',
                            'nama_file' =>  $key['nama_file']['val'],
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                        ];
                    } elseif ($level == 'internalcontrol') {
                        $sesuai[] =  $key['status']['val'] == 0 ? $key['status']['val'] : 0;
                        $tidak_sesuai[] =   $key['status']['val'] == 1 ? $key['status']['val'] : 0;
                        $arrdata = [
                            'no_aplikasi' => $no_apl,
                            'otorisasi_pusat' =>  $key['status']['val'],
                            'catatan_pusat' => $key['catatan']['val'],
                            'kategori_file' => 'Jaminan',
                            'nama_file' =>  $key['nama_file']['val'],
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                        ];
                    }
                    $d = Trotorisasi::where(
                        [
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                            'no_aplikasi' => $no_apl,
                        ]
                    );
                    if ($d->count() > 0) {
                        $d->first()->update($arrdata);
                    } else {
                        Trotorisasi::create($arrdata);
                    }
                    $no++;
                    $parameter_doc  .=  $key['tmparameter_doc_id']['val'];
                }
                $no_aplikasi = $no_apl;
                $status_approve = $this->request->status_approve;

                $trstatus_otorisasi = Trstatus_otorisasi::where([
                    'no_aplikasi' => $no_apl,
                    'kategory_doc' => 'jaminan'
                ]);
                $data =  [
                    1 => 'Di teruskan ke Pusat',
                    2 => 'Revise Ke marketing',
                    3 => 'Approved Pusat',
                    4 => 'Reject',
                    5 => 'Revise Ke Cabang'

                ];
                if ($trstatus_otorisasi->count() > 0) {

                    $trstatus_otorisasi->first()->update([
                        'no_aplikasi' => $no_aplikasi,
                        'status_approve' => $status_approve,
                        'kategory_doc' => 'jaminan',
                        'keterangan' => $data[$status_approve]

                    ]);
                } else {
                    Trstatus_otorisasi::create([
                        'no_aplikasi' => $no_aplikasi,
                        'status_approve' => $status_approve,
                        'kategory_doc' => 'jaminan',
                        'keterangan' => $data[$status_approve]
                    ]);
                }
                switch ($status_approve) {
                    case 1:
                        $val =  27;
                        break;
                    case 2:
                        $val =  28;
                        break;
                    case 3:
                        $val =  29;

                        break;
                    case 4:
                        $val =  30;

                        break;
                    case 5:
                        $val = 31;
                        break;
                    default:
                        $val = 0;
                        break;
                }
                Tmparamtertr::setstatus(
                    [
                        'no_ap' => $no_apl,
                        'status' => $val,
                        'kode' => $val,
                    ]
                );
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


    // get count function 
    public function jaminanbelumupload()
    {
        $data = Tmnasabah::select(
            \DB::raw('count(tmnasabah.id) as jumlahnya')
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->whereNotExists(function ($query) {
                $query->select('tmoveride.no_aplikasi')
                    ->from('tmoveride')
                    ->whereRaw('tmaplikasi.no_aplikasi = tmoveride.no_aplikasi');
            })->where(function ($sql) {
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 1);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 2);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 3);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 4);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 5);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 6);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 7);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 8);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 9);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 10);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 11);
            })
            ->distinct()->first();

        return response()->json($data->jumlahnya);
    }
    public function otorisasirek()
    {
        $data = Tmnasabah::select(
            \DB::raw('count(tmnasabah.id) as jumlahnya')
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->whereNotExists(function ($query) {
                $query->select('tmoveride.no_aplikasi')
                    ->from('tmoveride')
                    ->whereRaw('tmaplikasi.no_aplikasi = tmoveride.no_aplikasi');
            })->where(function ($sql) {
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 14);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 15);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 16);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 17);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 18);
                $sql->OrWhere('tmsla.tmstatus_aplikasi_id', 19);
            })
            ->distinct()->first();

        return response()->json($data->jumlahnya);
    }
    public function lengkap()
    {
        $data = Tmnasabah::select(
            \DB::raw('count(tmnasabah.id) as jumlahnya')
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->whereNotExists(function ($query) {
                $query->select('tmoveride.no_aplikasi')
                    ->from('tmoveride')
                    ->whereRaw('tmaplikasi.no_aplikasi = tmoveride.no_aplikasi');
            })->where('tmsla.tmstatus_aplikasi_id', 33)
            ->distinct()->first();

        return response()->json($data->jumlahnya);
    }


    public function notifikasi()
    {
        // if (Tmparamtertr::session('role') == 'manageroperation') {
        //     $data =  Tmsla::where(function ($where) {
        //         $where->Orwhere('tmstatus_aplikasi_id', 20);
        //         $where->Orwhere('tmstatus_aplikasi_id', 20);
        //     })->get();
        // } else if (Tmparamtertr::session('role') == 'internalcontrol') {
        //     $data =  Tmsla::where(function ($where) {
        //         $where->Orwhere('tmstatus_aplikasi_id', 23);
        //         $where->Orwhere('tmstatus_aplikasi_id', 24);
        //     })->get();
        // }
        // return response()->json(['data' => $data]);
        return  null;
    }

    public function destroy($no_apl)
    {
    }
}
