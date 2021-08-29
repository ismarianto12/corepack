<?php

namespace Ismarianto\Ismarianto\Controllers;

//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use DataTables;
use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Models\Tmparameter;
// use
use Ismarianto\Ismarianto\Models\Tmupload_document;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Ismarianto\Ismarianto\Models\Tmupload_jaminan;

use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Troveride;
use Ismarianto\Ismarianto\Models\Trotorisasi;
use Ismarianto\Ismarianto\Lib\StatusApp;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;

class KelengkapanjaminanController extends controller
{
    // use Tmparamtertr;
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
        $title =  'Document dan jaminan nasabah';
        $parsed =  '';
        $view = $this->view . '.index';
        return view(
            $view,
            [
                'title' => $title,
                'parsed' => $parsed
            ]
        );
    }
    public function edit($no_apl, $page = null)
    {

        // 

        $nasabah = Tmnasabah::select('tmaplikasi.tmhadiah_id', 'tmnasabah.no_aplikasi')->join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmstatus_aplikasi.id', '=', 'tmsla.tmstatus_aplikasi_id')
            ->where('tmnasabah.no_aplikasi', $no_apl)
            ->first();
        // data
        $no_aplikasinasabah = $nasabah->no_aplikasi;
        $penmanfaat = Trpenerima_manfaat::where('trpenerima_manfaat.no_aplikasi', $no_aplikasinasabah)->get();

        $document = Tmparameterdoc::where([
            'tmparameter_doc.category' => 'jaminan',
            'tmparameter_doc.kode' => 'Peserta',
            'tmparameter_doc.tmhadiah_id' => $nasabah->tmhadiah_id,
        ])->get();

        // @dd($document->count());
        // dd($no_apl);

        $j = 0;
        foreach ($document as $datadoc) {
            $upload_jaminan = Tmupload_jaminan::where([
                'tmparameter_doc_id' => $datadoc['id'],
                'no_aplikasi' => $no_apl
            ])->first();

            $parsed_data[$j]['id_par']['val'] = $datadoc['id'];
            $parsed_data[$j]['nama_doc']['val'] = $datadoc['nama_doc'];
            $parsed_data[$j]['category']['val'] = $datadoc['category'];
            $parsed_data[$j]['status']['val'] = $datadoc['status'];
            $parsed_data[$j]['tmhadiah_id']['val'] = $datadoc['tmhadiah_id'];
            $parsed_data[$j]['no_aplikasi']['val'] = isset($upload_jaminan['no_aplikasi']) ? $upload_jaminan['no_aplikasi'] : '';
            $parsed_data[$j]['keterangan_file']['val'] = isset($upload_jaminan['keterangan_file']) ? $upload_jaminan['keterangan_file'] : '';
            $parsed_data[$j]['nama_file']['val'] = isset($upload_jaminan->nama_file) ? $upload_jaminan->nama_file  : '';
            $parsed_data[$j]['tmparameter_doc_id']['val'] = isset($upload_jaminan->tmparameter_doc_id) ? $upload_jaminan->tmparameter_doc_id : '';
            $parsed_data[$j]['users_id']['val'] = isset($upload_jaminan->users_id) ? $upload_jaminan->users_id : '';
            $j++;
        }
        $fparsed_data  = isset($parsed_data) ? $parsed_data  : [];

        $view_parsing = $this->view . 'form_edit';
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
            //line penerima manfaat
            'pmanfaat_data' => $penmanfaat,
            'document' => $fparsed_data,
            'title' => "Upload data jaminan"
        ]);
    }


    public function datailkonfirm($no_apliasi)
    {
        $data = Tmnasabah::select(
            'tmnasabah.id',
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            'tmstatus_aplikasi.keterangan_status',
            'tmaplikasi.overide'
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->where('tmnasabah.no_aplikasi', $no_apliasi)->first();

        return view($this->view . 'kirimdata', [
            'title' => 'Konfirmasi data',
            'no_aplikasi' => $no_apliasi,
            'data' => $data
        ]);
    }

    public function actionconfirm()
    {
        $no_aplikasi = $this->request->no_aplikasi;
        Tmaplikasi::where('no_aplikasi', $no_aplikasi)->update([
            'document_jaminan' => '1'
        ]);

        Tmparamtertr::setstatus(
            [
                'no_ap' => $no_aplikasi,
                'status' => 24,
                'kode' => 24,
            ]
        );
        return response()->json([
            'status' => 1,
            'msg' => 'data berhasil di simpan'
        ]);
    }


    // this line un used function 
    public function form_verifikasi($no_apl, $page = null)
    {
        $nasabah = Tmnasabah::join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmstatus_aplikasi.id', '=', 'tmsla.tmstatus_aplikasi_id')
            ->where('tmnasabah.no_aplikasi', $no_apl)
            // ->where('tmstatus_aplikasi.id', 5)   
            ->first();
        // data
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

            $parsed_data[$j]['otorisasi_cabang']['val'] = isset($upload_jaminan['otorisasi_cabang']) ? $upload_jaminan['otorisasi_cabang'] : '';
            $parsed_data[$j]['catatan_cabang']['val'] = isset($upload_jaminan['catatan_cabang']) ? $upload_jaminan['catatan_cabang'] : '';
            // 
            $parsed_data[$j]['otorisasi_pusat']['val'] = isset($upload_jaminan['otorisasi_pusat']) ? $upload_jaminan['otorisasi_pusat'] : '';
            $parsed_data[$j]['catatan_pusat']['val'] = isset($upload_jaminan['catatan_pusat']) ? $upload_jaminan['catatan_pusat'] : '';
            $j++;
        }


        // dd($parsed_data);
        $level = Tmparamtertr::session('role');
        $view_parsing = 'ismarianto::verifikasi_kelengkapan.form_edit';
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
            //line penerima manfaat
            'pmanfaat_data' => $penmanfaat,
            'document' => $parsed_data,
            'level' => $level

        ]);
    }



    public function table_upload($no_apl)
    {
        $nasabah = Tmnasabah::join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmstatus_aplikasi.id', '=', 'tmsla.tmstatus_aplikasi_id')
            ->where('tmnasabah.no_aplikasi', $no_apl)
            // ->where('tmstatus_aplikasi.id', 5)   
            ->first();
        $document = Tmupload_jaminan::select(
            'tmparameter_doc.id as id_par',
            'tmparameter_doc.kode',
            'tmparameter_doc.nama_doc',
            'tmparameter_doc.category',
            'tmparameter_doc.status',
            'tmparameter_doc.tmhadiah_id',
            'tmparameter_doc.users_id',
            'tmupload_jaminan.id',
            'tmupload_jaminan.tmparameter_id',
            'tmupload_jaminan.no_aplikasi',
            'tmupload_jaminan.keterangan_file',
            'tmupload_jaminan.nama_file',
            'tmupload_jaminan.tmparameter_doc_id',
            'tmupload_jaminan.users_id',
            'tmupload_jaminan.created_at',
            'tmupload_jaminan.updated_at'
        )
            ->where('tmupload_jaminan.tmhadiah_id.', $nasabah->tmhadiah_id)
            ->join('tmupload_jaminan.no_aplikasi', $nasabah->no_aplikasi)
            ->join(
                'tmparameter_doc',
                'tmparameter_doc.id',
                '=',
                'tmupload_jaminan.tmparameter_id',
                'left'
            )->get();
        return view('ismarianto::datajaminan.table_upload', [
            'document' => $document,
            'nasabah' => $nasabah
        ]);
    }

    public function simpan_data($no_apl)
    {
        try {
            $tmaplikasi_id = Tmaplikasi::where('no_aplikasi', $no_apl)->first();
            $peserta_file = $this->request->post('peserta');
            foreach ($peserta_file as $val => $key) {


                $dojaminan = Tmupload_jaminan::where([
                    'no_aplikasi' => $no_apl,
                    'tmparameter_doc_id' => $val
                ]);

                $datainsert = [
                    'tmparameter_id' => $tmaplikasi_id->tmparameter_id,
                    'tmparameter_doc_id' => $val,
                    'no_aplikasi' => $tmaplikasi_id->no_aplikasi,
                    'keterangan_file' => $key,
                    'nama_file' => $key,
                    'users_id' => Session::get('username'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                if ($dojaminan->count() > 0) {
                    $dojaminan->first()->update($datainsert);
                } else {
                    Tmupload_jaminan::insert($datainsert);
                }
            }

            Tmparamtertr::setstatus(
                [
                    'no_ap' => $no_apl,
                    'status' => 25,
                    'kode' => 25,
                ]
            );
            return response()->json([
                'status' => 1,
                'msg' => 'Data jaminan peserta berhasil disimpan'
            ]);
        } catch (Tmupload_jaminan $th) {
            throw $th;
        }
    }
    public function delete_file($no_apl)
    {
        if ($this->request->ajax()) {
            $id = $this->request->id;
            $data = Tmupload_jaminan::where('tmparameter_doc_id', $id);
            if ($data->count() > 0) {

                $ff = $data->first();
                $data->delete();
                @unlink(public_path() . '/uploads/document/kelengkapan_jaminan/' . $no_apl . '/', $ff['keterangan_file']);
                return response()->json([
                    'upload' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } else {
                return response()->json([
                    'upload' => 1,
                    'msg' => 'destinationfile not found err:404_'
                ]);
            }
        }
    }
    private function action($verfikasi, $no_aplikasi)
    {
        if ($verfikasi != '') {
            $action = '<a href="" class="btn btn-info btn-sm" id="lengkapi" data-id="' . $no_aplikasi . '" title="Verifikasi Jamninan Nasabah"><i class="fa fa-check"></i></a> ';
        } else {
            $url = route('dokumenjaminan.datailkonfirm', $no_aplikasi);
            $fuck = Tmupload_jaminan::select('keterangan_file')
                ->where('no_aplikasi', $no_aplikasi)->first();

            $confirm = isset($fuck->keterangan_file) ? $fuck->keterangan_file : '';
            if ($confirm != '') {
                $action = '<p><button class="btn btn-primary btn-sm" onclick="javascript:kirimdata(\'' . $url . '\')"><i class="fas fa-paper-plane"></i></button>
                <a href="' . route('dokumenjaminan.edit', $no_aplikasi) . '" class="btn btn-success btn-sm"><i class="fa fa-user-check"></i></a><p>';
            } else {
                $action =  '
                <p><a href="' . route('dokumenjaminan.edit', $no_aplikasi) . '" class="btn btn-success btn-sm"><i class="fa fa-user-check"></i></a><p>';
            }
        }
        return $action;
    }

    public function api($verifikasi = null)
    {
        $sql = Tmnasabah::select(
            'tmnasabah.id',
            'tmnasabah.nama_sesuai_ktp',
            'tmnasabah.no_aplikasi',
            'tmnasabah.users_id',
            'tmnasabah.created_at',
            'tmstatus_aplikasi.keterangan_status',
            'tmaplikasi.overide'
        )->join('tmaplikasi', 'tmnasabah.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->whereNotExists(function ($query) {
                $query->select('tmoveride.no_aplikasi')
                    ->from('tmoveride')
                    ->whereRaw('tmaplikasi.no_aplikasi = tmoveride.no_aplikasi');
            })
            ->where(function ($query) {
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 19);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 20);
                // sikon
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 23);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 24);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 25);
            })
            ->where(function ($query) {
                $query->Orwhere('tmaplikasi.document_jaminan', null);
                $query->Orwhere('tmaplikasi.document_jaminan', 0);
            })
            ->distinct();

        $data = $sql->get();

        return \DataTables::of($data)
            ->editColumn('action', function ($p) use ($verifikasi) {
                return  $this->action($verifikasi, $p->no_aplikasi);
            }, true)

            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return  '<a href="" class="btn btn-danger btn-sm" id="lengkapi" data-id="' . $percent . '"><i class="fa fa-refresh"></i>' . $percent . '</a> ';
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<a class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</a>';
            }, true)
            ->editColumn('waktu_input', function ($p) {
                $g = date('Y-M-D H:i:s', strtotime($p->created_at));
                return $g;
            }, true)
            ->editColumn('user_id', function ($p) {
                return $p->users_id;
            }, true)
            ->editColumn('status', function ($p) {
                return $p->keterangan_status;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'progress', 'waktu_input', 'user_id', 'status', 'j_manfaat'])
            ->toJson();
    }



    public function verifikasidata($no_apl)
    {
        if ($this->request->ajax()) {
            $level = Tmparamtertr::session('role');
            if (in_array($level, ['manageroperation', 'internalcontrol'])) {

                $status = $this->request->status;
                $catatan = $this->request->catatan;

                $no = 0;
                $j = 1;
                foreach ($catatan as $key => $val) {
                    foreach ($status as $stat => $statval) {
                        $pardata[$j]['catatan']['val'] = $val;
                        $pardata[$j]['status']['val'] = $statval;
                        $pardata[$j]['tmparameter_doc_id']['val'] = $stat;
                        $pardata[$j]['nama_file']['val'] = $stat;
                        $j++;
                    }
                }

                foreach ($pardata as $val => $key) {
                    if ($level == 'manageroperation') {
                        $arrdata = [
                            'no_aplikasi' => $no_apl,
                            'otorisasi_cabang' => $key['status']['val'],
                            'catatan_cabang' => $key['catatan']['val'],
                            'kategori_file' => 'Jaminan',
                            'nama_file' =>  $key['tmparameter_doc_id']['val'],
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                        ];
                    } elseif ($level == 'internalcontrol') {
                        $arrdata = [
                            'no_aplikasi' => $no_apl,
                            'otorisasi_pusat' =>  $key['status']['val'],
                            'catatan_pusat' => $key['catatan']['val'],
                            'kategori_file' => 'Jaminan',
                            'nama_file' =>  $key['tmparameter_doc_id']['val'],
                            'tmparameter_doc_id' => $key['tmparameter_doc_id']['val'],
                        ];
                    }
                    $d = Trotorisasi::where('tmparameter_doc_id', $key['tmparameter_doc_id']['val']);
                    if ($d->count() > 0) {
                        Trotorisasi::updated(
                            $arrdata,
                            [
                                'tmparameter_doc_id' => $key['tmparameter_doc_id']['val']
                            ]
                        );
                    } else {
                        Trotorisasi::insert($arrdata);
                    }
                    $no++;
                }
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


    public function destroy()
    {

        try {
            if (is_array($this->request->id)) {
                $data =  Tmupload_jaminan::whereIn('id', $this->request->id);
                foreach ($data->get() as $datas) {
                }
            } else {
                $data = Tmupload_jaminan::whereid($this->request->id);
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            }
        } catch (Tmupload_jaminan $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
