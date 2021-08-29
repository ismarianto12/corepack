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
// use Ismarianto\Ismarianto\Models\Tmupload_document;
use Ismarianto\Ismarianto\Models\Tmwilayah;
use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Tmhadiah;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;
use Ismarianto\Ismarianto\Lib\StatusApp;
use Ismarianto\Ismarianto\Models\Tmupload_jaminan;
use Ismarianto\Ismarianto\Models\Trotorisasi;

class UploadkelengkapanController extends Controller
{
    // use Tmparamtertr;
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'tazamcore::tmkelengkapan.';
        $this->route   = 'parameter.';
        $this->primary_id = PhareSpase::createtazamid();
    }

    public function index()
    {
        // dd(Session::get('RF.subfolder'));
        return view(
            $this->view . 'index',
            [
                'title' => 'Upload Document dan kelengkapan Nasabah',

            ]
        );
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
            'tmnasabah.created_at',
            'tmstatus_aplikasi.keterangan_status',
            'tmaplikasi.overide',

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
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 11);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 12);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 13);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 14);
                $query->Orwhere('tmsla.tmstatus_aplikasi_id', 15);
            })
            ->where(function ($query) {
                $query->Orwhere('tmaplikasi.document_kelengkapan', null);
                $query->Orwhere('tmaplikasi.document_kelengkapan', 0);
            })
            ->distinct();

        if (Tmparamtertr::session('role') == 'marketing') {
            $data = $sql->where('tmaplikasi.tmref_cabang_id', $ref_cabang)
                ->where('tmnasabah.users_id', $username)
                ->get();
        } else {
            $data = $sql->get();
        }
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "'  />";
            })
            ->editColumn('action', function ($p) {
                $url = route('uploaddankelengkapan.datailkonfirm', $p->no_aplikasi);
                $fuck = Tmupload_document::select('keterangan_file')->where([
                    'no_aplikasi' => $p->no_aplikasi
                ])->first();
                $confirm = isset($fuck->keterangan_file) ? $fuck->keterangan_file : '';
                if ($confirm != '') {
                    return '<p><button class="btn btn-primary btn-sm" onclick="javascript:kirimdata(\'' . $url . '\')"><i class="fas fa-paper-plane"></i></button>
                    <a href="' . route('uploaddankelengkapan.edit', $p->id) . '" class="btn btn-success btn-sm"><i class="fa fa-user-check"></i></a><p>';
                } else {
                    return  '
                    <p><a href="' . route('uploaddankelengkapan.edit', $p->id) . '" class="btn btn-success btn-sm"><i class="fa fa-user-check"></i></a><p>';
                }
            }, true)
            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return  '<a href="" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i>' . $percent . '</a> ';
            }, true)
            ->editColumn('waktu_input', function ($p) {
                $g = date('Y-m-d H:i:s', strtotime($p->created_at));
                return $g;
            }, true)
            ->editColumn('j_manfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<button class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</button>';
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

        return view($this->view . 'konfirmasi_kirim', [
            'title' => 'Konfirmasi data',
            'no_aplikasi' => $no_apliasi,
            'data' => $data
        ]);
    }

    public function actionconfirm()
    {
        $no_aplikasi = $this->request->no_aplikasi;
        Tmaplikasi::where('no_aplikasi', $no_aplikasi)->update([
            'document_kelengkapan' => '1'
        ]);

        Tmparamtertr::setstatus(
            [
                'no_ap' => $no_aplikasi,
                'status' => 14,
                'kode' => 14,
            ]
        );
        return response()->json([
            'status' => 1,
            'msg' => 'data berhasil di simpan'
        ]);
    }


    public function edit($id)
    {    // create folder aaccess

        // dd(Session::get('RF.subfolder'));
        $nasabah = Tmnasabah::find($id);
        $pmanfat = Trpenerima_manfaat::where('no_aplikasi', $nasabah->no_aplikasi);
        $tmhadiah = Tmhadiah::get();

        $tmapalikasi = Tmaplikasi::where('no_aplikasi', $nasabah->no_aplikasi)->first();

        $fieldcolump  = Tmparameterdoc::Where([
            'kode' => 'peserta',
            'category' => 'document'
        ])->get();
        $fieldcolumpm  = Tmparameterdoc::Where([
            'kode' => 'pmanfaat',
            'category' => 'document'

        ])->get();

        $tmhadiah_penmanfaat = isset($pmanfat->first()->tmhadiah_id) ? $pmanfat->first()->tmhadiah_id : "";
        $tmhadiah_peserta = ($tmapalikasi->tmhadiah_id) ? $tmapalikasi->tmhadiah_id : "";
        $document = Tmparameterdoc::where([
            'tmparameter_doc.category' => 'document',
            'tmparameter_doc.kode' => 'peserta',
            'tmparameter_doc.tmhadiah_id' => $tmhadiah_peserta,
        ])->get();

        $receipents_docs = Tmparameterdoc::where([
            'tmparameter_doc.category' => 'document',
            'tmparameter_doc.kode' => 'pmanfaat',
            'tmparameter_doc.tmhadiah_id' => $tmhadiah_penmanfaat,
        ])->get();

        $j = 0;
        foreach ($document as $datadoc) {
            $upload_jaminan = Tmupload_document::where([
                'tmparameter_doc_id' => $datadoc['id'],
                'no_aplikasi' => $nasabah->no_aplikasi,
                'status_file' => 'peserta'
            ])->first();
            // getstatus if overide
            $documentpeserta[$j]['id_par']['val'] = $datadoc['id'];
            $documentpeserta[$j]['nama_doc']['val'] = $datadoc['nama_doc'];
            $documentpeserta[$j]['category']['val'] = $datadoc['category'];
            $documentpeserta[$j]['status']['val'] = $datadoc['status'];
            $documentpeserta[$j]['tmhadiah_id']['val'] = $datadoc['tmhadiah_id'];
            $documentpeserta[$j]['no_aplikasi']['val'] = isset($upload_jaminan['no_aplikasi']) ? $upload_jaminan['no_aplikasi'] : '';
            $documentpeserta[$j]['keterangan_file']['val'] = isset($upload_jaminan['keterangan_file']) ? $upload_jaminan['keterangan_file'] : '';
            $documentpeserta[$j]['idfilepeserta']['val'] = isset($upload_jaminan['id']) ? $upload_jaminan['id'] : '';

            //  catatan jika status file upload overide 

            $getotorisasi_nama_file  = isset($upload_jaminan->nama_file) ? $upload_jaminan->nama_file : '';
            if ($getotorisasi_nama_file != '') {
                $datafile = '<div class="alert alert-danger">' . $upload_jaminan->catatan_cabang . '</div>';
            } else {
                $datafile = '';
            }
            $keteranganoveride = isset($datafile) ? $datafile : '';
            $documentpeserta[$j]['file_overide']['val'] = $keteranganoveride;

            $documentpeserta[$j]['nama_file']['val'] = isset($upload_jaminan->nama_file) ? $upload_jaminan->nama_file  : '';
            $documentpeserta[$j]['tmparameter_doc_id']['val'] = isset($upload_jaminan->tmparameter_doc_id) ? $upload_jaminan->tmparameter_doc_id : '';
            $documentpeserta[$j]['users_id']['val'] = isset($upload_jaminan->users_id) ? $upload_jaminan->users_id : '';
            $j++;
        }
        // this action documet for reciepients
        $n = 0;

        // dd($receipents_docs);
        foreach ($receipents_docs as $docs_parctipans) {
            $pmupload_jaminan = Tmupload_document::where([
                'tmparameter_doc_id' => $docs_parctipans['id'],
                'no_aplikasi' => $nasabah->no_aplikasi,
                'status_file' => 'pmanfaat'
            ])->first();

            // dd($pmupload_jaminan['id']);
            $parsed_data[$n]['id_par']['val'] = $docs_parctipans['id'];
            $parsed_data[$n]['nama_doc']['val'] = $docs_parctipans['nama_doc'];
            $parsed_data[$n]['category']['val'] = $docs_parctipans['category'];
            $parsed_data[$n]['status']['val'] = $docs_parctipans['status'];
            $parsed_data[$n]['tmhadiah_id']['val'] = $docs_parctipans['tmhadiah_id'];
            $parsed_data[$n]['no_aplikasi']['val'] = isset($pmupload_naminan['no_aplikasi']) ? $pmupload_jaminan['no_aplikasi'] : '';
            $parsed_data[$n]['keterangan_file']['val'] = isset($pmupload_jaminan['keterangan_file']) ? $pmupload_jaminan['keterangan_file'] : '';
            $parsed_data[$n]['idfilepmanfaat']['val'] = isset($pmupload_jaminan['id']) ? $pmupload_jaminan['id'] : '';
            $parsed_data[$n]['nama_file']['val'] = isset($pmupload_jaminan->nama_file) ? $pmupload_jaminan->nama_file  : '';
            $parsed_data[$n]['tmparameter_doc_id']['val'] = isset($pmupload_jaminan->tmparameter_doc_id) ? $pmupload_jaminan->tmparameter_doc_id : '';
            $parsed_data[$n]['users_id']['val'] = isset($pmupload_jaminan->users_id) ? $pmupload_jaminan->users_id : '';

            // get detail data apabila overide di kembalikan ke marketing
            $namafilepmanfaat = isset($pmupload_jaminan['nama_file']) ? $pmupload_jaminan['nama_file'] : '';
            if ($namafilepmanfaat != '') {
                $datafile = '<div class="alert alert-danger">' . $pmupload_jaminan->catatan_cabang . '</div>';
            } else {
                $datafile = '';
            }
            $keteranganoveride = isset($datafile) ? $datafile : '';
            $parsed_data[$n]['file_overide_pmanfaat']['val'] = $keteranganoveride;
            $n++;
        }
        $parcipcant_docs  = isset($documentpeserta) ? $documentpeserta  : [];
        $recipients_docs  = isset($parsed_data) ? $parsed_data  : [];


        // dd($nasabah->tmparameter_id);
        $tmparametername = Tmparameter::find($tmapalikasi->tmparameter_id);
        // dd($recipients_docs); 
        $tmparameter = Tmparameter::get();
        $getpenerimamanfaat = Trpenerima_manfaat::where('no_aplikasi', $nasabah->no_aplikasi)->get();

        return view($this->view . 'form_edit', [
            // settitledata
            'title' => 'Upload document dan kelengkapan data nasabah',
            'parcipcant_docs' => $parcipcant_docs,
            'recipients_docs' => $recipients_docs,
            'tmparametername' => $tmparametername->nama_prog,
            // data  fiel document untuk peserta   
            // data field document untuk peneruma manfaat 
            'fieldcolump' => $fieldcolump,
            'fieldcolumpm' => $fieldcolumpm,
            'getpenerimamanfaat' => $getpenerimamanfaat,
            'nasabah' => $nasabah,
            'id' => $nasabah->id,
            'no_aplikasi' => $nasabah->no_aplikasi,
            'tmparameter_id' => $tmparametername->id,
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
            'pmanfaat_data' => $pmanfat->get(),
            'program' => $tmparameter,
            'tmhadiah' => $tmhadiah,
            'tmhadiah_id' => $tmapalikasi->tmhadiah_id
        ]);
    }



    public function delelete_file()
    {
        $id  = $this->request->id_file;
        $parameter  = $this->request->parameter;

        $data = Tmupload_document::find($id);
        if ($parameter == 'file_upload_peserta') {
            $pmanfat = Trpenerimamanfaat::where('no_aplikasi', $data->no_aplikasi)->first();
            $nama_penerima_manfaat = $pmanfat->nama;
        }
        $setname = $data->nama_file;
        if ($parameter == 'file_upload_peserta') {
            @unlink('./uploads/document/' . $parameter . '/' . $this->request->no_aplikasi . '/' . $setname);
        } else if ($parameter == 'file_upload_penerimamanfaat') {
            @unlink('./uploads/document/' . $parameter . '/' . $this->request->no_aplikasi . '_' . $nama_penerima_manfaat . '/' . $setname);
        }
        $data->delete();
        return response()->json([
            'deleted' => 1,
            'data berhasil di hapus'
        ]);
    }


    function table_file_nasabah()
    {
        $no_aplikasi = $this->request->no_aplikasi;
        $status = $this->request->status;
        $data = Tmupload_document::select(
            'tmupload_document.id',
            'tmupload_document.tmparameter_id',
            'tmupload_document.no_aplikasi',
            'tmupload_document.keterangan_file',
            'tmupload_document.nama_file',
            'tmupload_document.users_id',
            'tmupload_document.tmparameter_doc_id',
            'tmupload_document.status_file',
            'tmparameter_doc.nama_doc'
        )->join(
            'tmparameter_doc',
            'tmparameter_doc.id',
            '=',
            'tmupload_document.tmparameter_doc_id',
            'left'
        )->where([
            'status_file' => $status,
            'no_aplikasi' => $no_aplikasi,
        ]);

        return view('nasabah::table_upload.nasabah', [
            'data' => $data,
            'no_aplikasi' => $no_aplikasi
        ]);
    }
    function table_file_penerima_manfaat()
    {
        $no_aplikasi = $this->request->no_aplikasi;
        $trpenerima_manfaat_id = $this->request->trpenerima_manfaat_id;
        $status = $this->request->status;
        $data = Tmupload_document::select(
            'tmupload_document.id',
            'tmupload_document.tmparameter_id',
            'tmupload_document.no_aplikasi',
            'tmupload_document.keterangan_file',
            'tmupload_document.nama_file',
            'tmupload_document.users_id',
            'tmupload_document.tmparameter_doc_id',
            'tmupload_document.status_file',
            'tmupload_document.trpenerima_manfaat_id',
            'tmparameter_doc.nama_doc'
        )->join(
            'tmparameter_doc',
            'tmparameter_doc.id',
            '=',
            'tmupload_document.tmparameter_doc_id',
            'left'
        )->where([
            'status_file' => $status,
            'tmupload_document.trpenerima_manfaat_id' => $trpenerima_manfaat_id,
            'no_aplikasi' => $no_aplikasi,
        ]);

        $rdata = $data->get();
        $id_manfaat  = isset($data->first()->trpenerima_manfaat_id) ? $data->first()->trpenerima_manfaat_id : '0';
        $tpnerima    = Trpenerima_manfaat::find($id_manfaat);

        // dd($rdata);

        return view('nasabah::table_upload.penerima_manfaat', [
            'data' => $rdata,
            'no_aplikasi' => $no_aplikasi,
            'nama_penerima_manfaat' => 'kosong'
        ]);
    }


    public function update($id)
    {
        try {
            $data = Tmnasabah::find($id);
            $data->no_ktp = $this->request->no_ktp;
            $data->nama_sesuai_ktp = $this->request->nama_sesuai_ktp;
            $data->tempat_lahir_ktp = $this->request->tempat_lahir_ktp;
            $data->tanggal_lahir_ktp = $this->request->tanggal_lahir_ktp;
            $data->jenis_kelamin_ktp = $this->request->jenis_kelamin_ktp;
            $data->pekerjaan_ktp = $this->request->pekerjaan_ktp;
            $data->status_pernikahan_ktp = $this->request->status_pernikahan_ktp;
            $data->alamat_sesuai_ktp = $this->request->alamat_sesuai_ktp;
            $data->rt_rw_ktp = $this->request->rt_rw_ktp;
            $data->kelurahan_ktp = $this->request->kelurahan_ktp;
            $data->kecamatan_ktp = $this->request->kecamatan_ktp;
            $data->kode_kota_kabupaten_ktp = $this->request->kode_kota_kabupaten_ktp;
            $data->kota_kabupaten_ktp = $this->request->kota_kabupaten_ktp;
            $data->kode_provinsi_ktp = $this->request->kode_provinsi_ktp;
            $data->provinsi_ktp = $this->request->provinsi_ktp;
            $data->kode_pos_ktp = $this->request->kode_pos_ktp;
            $data->alamat_domisili = $this->request->alamat_domisili;
            $data->rt_rw_domisili = $this->request->rt_rw_domisili;
            $data->kelurahan_domisili = $this->request->kelurahan_domisili;
            $data->kecamatan_domisili = $this->request->kecamatan_domisili;
            $data->kota_kabupaten_domisili = $this->request->kota_kabupaten_domisili;
            $data->provinsi_domisili = $this->request->provinsi_domisili;
            $data->kode_pos_domisili = $this->request->kode_pos_domisili;
            $data->jenis_penduduk = $this->request->jenis_penduduk;
            $data->kewarganegaraan = $this->request->kewarganegaraan;
            $data->nama_ibu_kandung_ktp = $this->request->nama_ibu_kandung_ktp;
            $data->agama = $this->request->agama;
            $data->no_hp = $this->request->no_hp;
            $data->email = $this->request->email;
            $data->tlp_rumah = $this->request->tlp_rumah;
            $data->penghasilan_perbulan = $this->request->penghasilan_perbulan;
            $data->penghasilan_pertahun = $this->request->penghasilan_pertahun;
            $data->pengeluaran_pertahun = $this->request->pengeluaran_pertahun;
            $data->status_tempat_tinggal = $this->request->status_tempat_tinggal;
            $data->jumlah_tanggungan = $this->request->jumlah_tanggungan;
            $data->kategori_nasabah = $this->request->kategori_nasabah;
            $data->tujuan_penggunaan = $this->request->tujuan_penggunaan;
            $data->nama_kelurahan = $this->request->nama_kelurahan;
            $data->save();

            //  save file peserta dan pmanfaat
            $tmaplikasi_id = Tmaplikasi::where('no_aplikasi', $data->no_aplikasi)->first();
            $peserta_file = $this->request->post('peserta');
            foreach ($peserta_file as $val => $key) {
                $pesertadata[] = [
                    'tmparameter_id' => $tmaplikasi_id->tmparameter_id,
                    'tmparameter_doc_id' => $val,
                    'no_aplikasi' => $data->no_aplikasi,
                    'keterangan_file' => $key,
                    'nama_file' => $key,
                    'status_file' => 'peserta',

                ];
            }
            $idfilepeserta = $this->request->input('idfilepeserta');

            $vpeserta =  Tmupload_document::where([
                'no_aplikasi' => $data->no_aplikasi,
                'status_file' => 'peserta',
            ])->WhereIn('id', $idfilepeserta);
            // start statement peserta saja 
            $fpesertadata = isset($pesertadata) ? $pesertadata : [];
            if ($vpeserta->count() > 0) {
                if (count($fpesertadata) > 0) {
                    $k = 0;
                    foreach ($idfilepeserta as $key => $jj) {
                        if (!empty($jj)) {
                            Tmupload_document::where('id', $jj)->update($fpesertadata[$k]);
                        }
                        $k++;
                    }
                }
            } else {
                if (count($fpesertadata) > 0) {
                    Tmupload_document::insert($fpesertadata);
                }
            }
            // edn statement peserta saja
            $fpmanfaat = $this->request->input('fpmanfaat');
            if (!empty($fpmanfaat)) {
                foreach ($fpmanfaat as $fpmanfaatval => $fpmanfaatkey) {
                    $fileid = substr($fpmanfaatval, 1);
                    $pmanfatdata[] = [
                        'tmparameter_id' => $tmaplikasi_id->tmparameter_id,
                        'tmparameter_doc_id' => $fileid,
                        'no_aplikasi' => $data->no_aplikasi,
                        'keterangan_file' => $fpmanfaatkey,
                        'nama_file' => $fpmanfaatkey,
                        'status_file' => 'pmanfaat',
                        'trpenerima_manfaat_id' => $this->request->trpenerima_manfaat_id,

                    ];
                }
            }
            // start penerimamanfaat saja 
            // pecah/


            $idfilepmanfaat = $this->request->input('idfilepmanfaat');
            $qpmanfat =  Tmupload_document::where([
                'no_aplikasi' => $data->no_aplikasi,
                'status_file' => 'pmanfaat',
            ])->whereIn('id', $idfilepmanfaat);

            $fpmanfatdata = isset($pmanfatdata) ? $pmanfatdata : [];
            if ($qpmanfat->count() > 0) {
                if (count($fpmanfatdata) > 0) {
                    $j = 0;
                    foreach ($idfilepmanfaat as $k => $l) {
                        if (!empty($val)) {
                            Tmupload_document::where('id', $l)->update($fpmanfatdata[$j]);
                        }
                        $j++;
                    }
                }
            } else {
                if (count($fpesertadata) > 0) {
                    Tmupload_document::insert($fpmanfatdata);
                }
            }
            // end penerimamanfaat saja 
            $f = Trpenerima_manfaat::where(['no_aplikasi' => $data->no_aplikasi])->get();
            $j = 1;
            foreach ($f as $d) {
                Trpenerima_manfaat::updated([
                    'nama' => $this->request->input('nama_' . $j),
                    'usia' => $this->request->input('usia_' . $j),
                    'hubungan' => $this->request->input('hubungan_'),
                    // 'tmhadiah_id' => $this->request->input('tmhadiah_id_' . $j),
                    'no_hp' => $this->request->input('no_hp_' . $j),
                    'email' => $this->request->input('email_' . $j),
                    'alamat' => $this->request->input('alamat_' . $j),

                ], [
                    'id' =>  $this->request->input('idnya_' . $j),
                ]);
                $j++;
            }
            Tmparamtertr::setstatus(
                [
                    'no_ap' => $data->no_aplikasi,
                    'status' => 12,
                    'kode' => 12,
                ]
            );
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil di simpan'
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // get wilyyah provinsi
    public function provinsi()
    {
        $data = Tmwilayah::select('kode_provinsi', 'nama_provinsi')->groupBy('kode_provinsi')->get();
        return response()->json($data);
    }

    public function kabupaten()
    {
        $id = $this->request->kode_provinsi;
        $data = Tmwilayah::where('kode_provinsi', $id)->get();
        return response()->json($data);
    }
}
