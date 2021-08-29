<?php

namespace Ismarianto\Ismarianto\Controllers;

//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;

use DataTables;
use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;
use Ismarianto\Ismarianto\Models\Truseroveride;
use Ismarianto\Ismarianto\Models\Tmhadiah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Ismarianto\Ismarianto\Models\Trbiayapenutupan;

class TmparameterController extends Controller
{
    // use Tmparamtertr;
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'tazamcore::tmparameter.';
        $this->route   = 'parameter.';
        $this->primary_id = PhareSpase::createtazamid();
    }

    public function index()
    {
        return view(
            $this->view . 'index',
            [
                'title' => 'Paramater Ismarianto',
            ]
        );
    }

    public function api()
    {
        $data = Tmparameter::get();
        return \DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-sm" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->editColumn('status', function ($p) {
                $active = ($p->active == 1) ? 'Active' : 'Deactivated';
                $ar = ($p->active == 1) ? 'actived(0,' . $p->id . ')' : 'actived(1,' . $p->id . ')';
                $class = ($p->active == 1) ? 'info' : 'danger';
                return '<button class="btn btn-' . $class . ' btn-sm" onclick="' . $ar . '"><i class="fa fa-check"></i>' . $active . ' </button>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'status', 'action'])
            ->toJson();
    }
    public function create()
    {
        $picoveride = Truseroveride::get();
        $tmhhadiah = Tmhadiah::get();

        return view($this->view . 'form_add', [
            'title' => 'Tambah Menu',
            'jenisnya' => PhareSpase::hubungan(),
            'user_overide_jenhadiah' =>  $picoveride,
            'user_overide_jenhadiah_manfaat' => $picoveride,
            'tmhhadiah' => $tmhhadiah
        ]);
    }


    public function store()
    {
        try { 

            $overide_penerima_manfaat = implode('.', $this->request->overide_penerima_manfaat);
            $jenis_hubungan_manfaat = implode('.', $this->request->jenis_hubungan_manfaat);
            $overide_hubungan = implode('.', $this->request->overide_hubungan);
            $user_overide_jenhadiah_peserta = ($this->request->user_overide_jenhadiah_peserta) ? implode('.', $this->request->user_overide_jenhadiah_peserta) : '';
            $user_overide_jenhadiah_manfaat = ($this->request->user_overide_jenhadiah_manfaat) ? implode('.', $this->request->user_overide_jenhadiah_manfaat) : '';
            $overide_usia = implode('.', $this->request->overide_usia);

            $jenis_hadiah_peserta = ($this->request->jenis_hadiah_peserta) ? $this->request->jenis_hadiah_peserta : '';
            $jenis_hadiah_manfaat = ($this->request->jenis_hadiah_manfaat) ? $this->request->jenis_hadiah_manfaat : '';


            $tmhadiah_id = $jenis_hadiah_peserta . '.' . $jenis_hadiah_manfaat;


            $f = new Tmparameter;
            $f->id = $this->primary_id;
            $f->kode_prog = $this->request->kode_prog;
            $f->nama_prog = $this->request->nama_prog;
            $f->usia_peserta_min = $this->request->usia_peserta_min;
            $f->usia_peserta_max = $this->request->usia_peserta_max;
            $f->overide_usia = $overide_usia;
            $f->usia_penerima_manfaat_min = $this->request->usia_penerima_manfaat_min;
            $f->usia_penerima_manfaat_manmax = $this->request->usia_penerima_manfaat_manmax;
            $f->overide_penerima_manfaat = $overide_penerima_manfaat;
            $f->jumlah_penerima_manfaat = $this->request->jumlah_penerima_manfaat;
            $f->jenis_hubungan_manfaat = $jenis_hubungan_manfaat;
            $f->overide_hubungan = $overide_hubungan;
            $f->setoran_awal = str_replace('.', '', $this->request->setoran_awal);
            $f->nilai_manfaat_hadiah = str_replace('.', '', $this->request->nilai_manfaat_hadiah);
            $f->indikasi_manfaat = $this->request->indikasi_manfaat;
            $f->pajak_hadiah = $this->request->pajak_hadiah;
            $f->jangka_waktu = $this->request->jangka_waktu;
            $f->kode_rek_haji_pmanfaat = $this->request->kode_rek_haji_pmanfaat;
            $f->kode_prouduk_rencana = $this->request->kode_prouduk_rencana;
            $f->kode_rek_haji_rthj = $this->request->kode_rek_haji_rthj;
            $f->setoran_rutin =  str_replace('.', '', $this->request->setoran_rutin);
            $f->saldo_rencana =  str_replace('.', '', $this->request->saldo_rencana);
            $f->tgl_pendebetan = $this->request->tgl_pendebetan;
            $f->setoran_awwal_lanjutan =  str_replace('.', '', $this->request->setoran_awwal_lanjutan);
            $f->biayahadiah =  str_replace('.', '', $this->request->biayahadiah);
            $f->debet_biaya_hadiah = str_replace('.', '', $this->request->debet_biaya_hadiah);
            $f->kredit_biaya_hadiah = str_replace('.', '', $this->request->kredit_biaya_hadiah);
            $f->jenis_amortisasi = str_replace('.', '', $this->request->jenis_amortisasi);
            $f->beban_pajak = str_replace('.', '', $this->request->beban_pajak);
            $f->biaya_pengurusan = str_replace('.', '', $this->request->biaya_pengurusan);
            $f->debet_biaya_pengurusan = str_replace('.', '', $this->request->debet_biaya_pengurusan);
            $f->kredit_biaya_pengurusan = str_replace('.', '', $this->request->kredit_biaya_pengurusan);
            $f->biaya_perencanaan = str_replace('.', '', $this->request->biaya_perencanaan);
            $f->debet_biaya_perencanaan = $this->request->debet_biaya_perencanaan;
            $f->kredit_biaya_perencanaan = $this->request->kredit_biaya_perencanaan;
            $f->cara_pendebetan = $this->request->cara_pendebetan;
            $f->jenis_hadiah_peserta = $this->request->jenis_hadiah_peserta;
            $f->jenis_hadiah_manfaat = $this->request->jenis_hadiah_manfaat;
            $f->user_overide_jenhadiah_peserta = $user_overide_jenhadiah_peserta;
            $f->user_overide_jenhadiah_manfaat = $user_overide_jenhadiah_manfaat;
            $f->status_slik = $this->request->status_slik;
            $f->pengecekan_saldo = $this->request->pengecekan_saldo;
            // cek pengecekan saldo yang berlaku 
            $f->insentif_awal_marketing = str_replace('.', '', $this->request->insentif_awal_marketing);
            $f->insentif_pihakke3 = str_replace('.', '', $this->request->insentif_pihakke3);
            $f->insentif_bulanan_marketing = str_replace('.', '', $this->request->insentif_bulanan_marketing);
            $f->insentif_bulanan_pihak3 = str_replace('.', '', $this->request->insentif_bulanan_pihak3);
            $f->tmhadiah_id = $tmhadiah_id;
            $f->save();


            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    } // table upload data 
    public function gettype($par)
    {
        $filter = [
            'category' => $par['category'],
            'kode' => $par['kode'],
            'tmhadiah_id' => $par['tmhadiah_id']
        ];

        $data = Tmparameterdoc::where($filter)->get();
        return response()->json($data);
    }
    public function gettable_document()
    {
        $category = $this->request->category;
        $kode = $this->request->kode;
        $tmhadiah_id   = $this->request->tmhadiah_id;
        $parameter      = $this->request->parameter;
        $fkode = ($kode == 'Peserta') ? 1 : 2;
        if ($parameter == 'add') {
            $doc = Tmparameterdoc::where('kode', '=', $kode)
                ->where('category', '=', $category)
                ->where('tmhadiah_id', '=',  $tmhadiah_id)
                ->where('tmparameter_id', '=', null)
                ->get();
        } else if ($parameter == 'edit') {

            $tmparameter_id = $this->request->tmparameter_id;
            $doc = Tmparameterdoc::where('tmparameter_id', '=', $tmparameter_id)
                ->where('kode', '=', $kode)
                ->where('category', '=', $category)
                ->where('tmhadiah_id', '=',  $tmhadiah_id)->get();
        }
        return view('tazamcore::table_doc.index', [
            'doc' => $doc,
            'category' => $category,
            'fkode' => $fkode,
            'kode' => $this->request->kode,
            'parameter' => $this->request->parameter,
            'tmhadiah_id' => $this->request->tmhadiah_id,
        ]);
    }
    public function setactive()
    {
        $id = $this->request->id;
        $f = Tmparameter::find($id);
        $f->active = $this->request->active;
        $f->save();
        return response()->json([
            'status' => 1,
            'msg' => 'data berhasil disimpan',
        ]);
    }

    public function edit($id)
    {
        $data = Tmparameter::findOrFail($id);
        $picoveride = Truseroveride::get();
        $tmhhadiah = Tmhadiah::get();
        return view($this->view . 'form_edit', [
            'title' => 'Edit data Parameter',
            'jenisnya' => PhareSpase::hubungan(),
            'useroveride' =>  $picoveride,
            'tmhhadiah' => $tmhhadiah,
            // edit acction acesss 
            'id' => $data->id,
            'kode_prog' => $data->kode_prog,
            'nama_prog' => $data->nama_prog,
            'usia_peserta_min' => $data->usia_peserta_min,
            'usia_peserta_max' => $data->usia_peserta_max,
            'overide_usia' => $data->overide_usia,
            'usia_penerima_manfaat_min' => $data->usia_penerima_manfaat_min,
            'usia_penerima_manfaat_manmax' => $data->usia_penerima_manfaat_manmax,
            'overide_penerima_manfaat' => ($data->overide_penerima_manfaat) ?  $data->overide_penerima_manfaat : '',
            'jumlah_penerima_manfaat' => $data->jumlah_penerima_manfaat,
            'jenis_hubungan_manfaat' => ($data->jenis_hubungan_manfaat) ?  $data->jenis_hubungan_manfaat : '',
            'overide_hubungan' => $data->overide_hubungan,
            'setoran_awal' => $data->setoran_awal,
            'nilai_manfaat_hadiah' => $data->nilai_manfaat_hadiah,
            'indikasi_manfaat' => $data->indikasi_manfaat,
            'pajak_hadiah' => $data->pajak_hadiah,
            'jangka_waktu' => $data->jangka_waktu,
            'kode_rek_haji_pmanfaat' => $data->kode_rek_haji_pmanfaat,
            'kode_prouduk_rencana' => $data->kode_prouduk_rencana,
            'kode_rek_haji_rthj' => $data->kode_rek_haji_rthj,
            'setoran_rutin' => $data->setoran_rutin,
            'saldo_rencana' => $data->saldo_rencana,
            'tgl_pendebetan' => $data->tgl_pendebetan,
            'setoran_awwal_lanjutan' => $data->setoran_awwal_lanjutan,
            'biayahadiah' => $data->biayahadiah,
            'debet_biaya_hadiah' => $data->debet_biaya_hadiah,
            'kredit_biaya_hadiah' => $data->kredit_biaya_hadiah,
            'jenis_amortisasi' => $data->jenis_amortisasi,
            'beban_pajak' => $data->beban_pajak,
            'biaya_pengurusan' => $data->biaya_pengurusan,
            'debet_biaya_pengurusan' => $data->debet_biaya_pengurusan,
            'kredit_biaya_pengurusan' => $data->kredit_biaya_pengurusan,
            'biaya_perencanaan' => $data->biaya_perencanaan,
            'debet_biaya_perencanaan' => $data->debet_biaya_perencanaan,
            'kredit_biaya_perencanaan' => $data->kredit_biaya_perencanaan,
            'cara_pendebetan' => $data->cara_pendebetan,
            'jenis_hadiah_peserta' => $data->jenis_hadiah_peserta,
            'jenis_hadiah_manfaat' => $data->jenis_hadiah_manfaat,
            'user_overide_jenhadiah_peserta' => $data->user_overide_jenhadiah_peserta,
            'user_overide_jenhadiah_manfaat' => $data->user_overide_jenhadiah_manfaat,
            'status_slik' => $data->status_slik,
            'pengecekan_saldo' => $data->pengecekan_saldo,
            'insentif_awal_marketing' => $data->insentif_awal_marketing,
            'insentif_pihakke3' => $data->insentif_pihakke3,
            'insentif_bulanan_marketing' => $data->insentif_bulanan_marketing,
            'insentif_bulanan_pihak3' => $data->insentif_bulanan_pihak3,
            'users_id' => $data->users_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'active' => $data->active,
            'tmhadiah_id' => $data->tmhadiah_id,
        ]);
    }
    public function update($id)
    {
        try {
            $overide_penerima_manfaat = implode('.', $this->request->overide_penerima_manfaat);
            $jenis_hubungan_manfaat = implode('.', $this->request->jenis_hubungan_manfaat);
            $overide_hubungan = implode('.', $this->request->overide_hubungan);
            $user_overide_jenhadiah_peserta = ($this->request->user_overide_jenhadiah_peserta) ? implode('.', $this->request->user_overide_jenhadiah_peserta) : '';
            $user_overide_jenhadiah_manfaat = ($this->request->user_overide_jenhadiah_manfaat) ? implode('.', $this->request->user_overide_jenhadiah_manfaat) : '';
            $overide_usia = implode('.', $this->request->overide_usia);

            $jenis_hadiah_peserta = ($this->request->jenis_hadiah_peserta) ? $this->request->jenis_hadiah_peserta : '';
            $jenis_hadiah_manfaat = ($this->request->jenis_hadiah_manfaat) ? $this->request->jenis_hadiah_manfaat : '';


            $tmhadiah_id = $jenis_hadiah_peserta . '.' . $jenis_hadiah_manfaat;

            $f = Tmparameter::find($id);
            $f->kode_prog = $this->request->kode_prog;
            $f->nama_prog = $this->request->nama_prog;
            $f->usia_peserta_min = $this->request->usia_peserta_min;
            $f->usia_peserta_max = $this->request->usia_peserta_max;
            $f->overide_usia = $overide_usia;
            $f->usia_penerima_manfaat_min = $this->request->usia_penerima_manfaat_min;
            $f->usia_penerima_manfaat_manmax = $this->request->usia_penerima_manfaat_manmax;
            $f->overide_penerima_manfaat = $overide_penerima_manfaat;
            $f->jumlah_penerima_manfaat = $this->request->jumlah_penerima_manfaat;
            $f->jenis_hubungan_manfaat = $jenis_hubungan_manfaat;
            $f->overide_hubungan = $overide_hubungan;
            $f->setoran_awal = str_replace('.', '', $this->request->setoran_awal);
            $f->nilai_manfaat_hadiah = str_replace('.', '', $this->request->nilai_manfaat_hadiah);
            $f->indikasi_manfaat = $this->request->indikasi_manfaat;
            $f->pajak_hadiah = $this->request->pajak_hadiah;
            $f->jangka_waktu = $this->request->jangka_waktu;
            $f->kode_rek_haji_pmanfaat = $this->request->kode_rek_haji_pmanfaat;
            $f->kode_prouduk_rencana = $this->request->kode_prouduk_rencana;
            $f->kode_rek_haji_rthj = $this->request->kode_rek_haji_rthj;
            $f->setoran_rutin =  str_replace('.', '', $this->request->setoran_rutin);
            $f->saldo_rencana =  str_replace('.', '', $this->request->saldo_rencana);
            $f->tgl_pendebetan = $this->request->tgl_pendebetan;
            $f->setoran_awwal_lanjutan =  str_replace('.', '', $this->request->setoran_awwal_lanjutan);
            $f->biayahadiah =  str_replace('.', '', $this->request->biayahadiah);
            $f->debet_biaya_hadiah = str_replace('.', '', $this->request->debet_biaya_hadiah);
            $f->kredit_biaya_hadiah = str_replace('.', '', $this->request->kredit_biaya_hadiah);
            $f->jenis_amortisasi = str_replace('.', '', $this->request->jenis_amortisasi);
            $f->beban_pajak = str_replace('.', '', $this->request->beban_pajak);
            $f->biaya_pengurusan = str_replace('.', '', $this->request->biaya_pengurusan);
            $f->debet_biaya_pengurusan = str_replace('.', '', $this->request->debet_biaya_pengurusan);
            $f->kredit_biaya_pengurusan = str_replace('.', '', $this->request->kredit_biaya_pengurusan);
            $f->biaya_perencanaan = str_replace('.', '', $this->request->biaya_perencanaan);
            $f->debet_biaya_perencanaan = $this->request->debet_biaya_perencanaan;
            $f->kredit_biaya_perencanaan = $this->request->kredit_biaya_perencanaan;
            $f->cara_pendebetan = $this->request->cara_pendebetan;
            $f->jenis_hadiah_peserta = $this->request->jenis_hadiah_peserta;
            $f->jenis_hadiah_manfaat = $this->request->jenis_hadiah_manfaat;
            $f->user_overide_jenhadiah_peserta = $user_overide_jenhadiah_peserta;
            $f->user_overide_jenhadiah_manfaat = $user_overide_jenhadiah_manfaat;
            $f->status_slik = $this->request->status_slik;
            $f->pengecekan_saldo = $this->request->pengecekan_saldo;
            $f->insentif_awal_marketing = str_replace('.', '', $this->request->insentif_awal_marketing);
            $f->insentif_pihakke3 = str_replace('.', '', $this->request->insentif_pihakke3);
            $f->insentif_bulanan_marketing = str_replace('.', '', $this->request->insentif_bulanan_marketing);
            $f->insentif_bulanan_pihak3 = str_replace('.', '', $this->request->insentif_bulanan_pihak3);
            $f->tmhadiah_id = $tmhadiah_id;
            $f->users_id = Session::get('username');
            $f->updated_at = Carbon::now();
            $f->created_at = Carbon::now();
            $f->save();


            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }




    public function show($id)
    {

        $data = Tmparameter::findOrFail($id);
        $picoveride = Truseroveride::get();
        $tmhhadiah = Tmhadiah::get();

        return view($this->view . 'form_show', [
            'title' => 'Edit data Parameter',
            'jenisnya' => PhareSpase::hubungan(),
            'useroveride' =>  $picoveride,
            'tmhhadiah' => $tmhhadiah,
            // edit acction acesss 
            'id' => $data->id,
            'kode_prog' => $data->kode_prog,
            'nama_prog' => $data->nama_prog,
            'usia_peserta_min' => $data->usia_peserta_min,
            'usia_peserta_max' => $data->usia_peserta_max,
            'overide_usia' => $data->overide_usia,
            'usia_penerima_manfaat_min' => $data->usia_penerima_manfaat_min,
            'usia_penerima_manfaat_manmax' => $data->usia_penerima_manfaat_manmax,
            'overide_penerima_manfaat' => ($data->overide_penerima_manfaat) ?  $data->overide_penerima_manfaat : '',
            'jumlah_penerima_manfaat' => $data->jumlah_penerima_manfaat,
            'jenis_hubungan_manfaat' => ($data->jenis_hubungan_manfaat) ?  $data->jenis_hubungan_manfaat : '',
            'overide_hubungan' => $data->overide_hubungan,
            'setoran_awal' => $data->setoran_awal,
            'nilai_manfaat_hadiah' => $data->nilai_manfaat_hadiah,
            'indikasi_manfaat' => $data->indikasi_manfaat,
            'pajak_hadiah' => $data->pajak_hadiah,
            'jangka_waktu' => $data->jangka_waktu,
            'kode_rek_haji_pmanfaat' => $data->kode_rek_haji_pmanfaat,
            'kode_prouduk_rencana' => $data->kode_prouduk_rencana,
            'kode_rek_haji_rthj' => $data->kode_rek_haji_rthj,
            'setoran_rutin' => $data->setoran_rutin,
            'saldo_rencana' => $data->saldo_rencana,
            'tgl_pendebetan' => $data->tgl_pendebetan,
            'setoran_awwal_lanjutan' => $data->setoran_awwal_lanjutan,
            'biayahadiah' => $data->biayahadiah,
            'debet_biaya_hadiah' => $data->debet_biaya_hadiah,
            'kredit_biaya_hadiah' => $data->kredit_biaya_hadiah,
            'jenis_amortisasi' => $data->jenis_amortisasi,
            'beban_pajak' => $data->beban_pajak,
            'biaya_pengurusan' => $data->biaya_pengurusan,
            'debet_biaya_pengurusan' => $data->debet_biaya_pengurusan,
            'kredit_biaya_pengurusan' => $data->kredit_biaya_pengurusan,
            'biaya_perencanaan' => $data->biaya_perencanaan,
            'debet_biaya_perencanaan' => $data->debet_biaya_perencanaan,
            'kredit_biaya_perencanaan' => $data->kredit_biaya_perencanaan,
            'cara_pendebetan' => $data->cara_pendebetan,
            'jenis_hadiah_peserta' => $data->jenis_hadiah_peserta,
            'jenis_hadiah_manfaat' => $data->jenis_hadiah_manfaat,
            'user_overide_jenhadiah_peserta' => $data->user_overide_jenhadiah_peserta,
            'user_overide_jenhadiah_manfaat' => $data->user_overide_jenhadiah_manfaat,
            'status_slik' => $data->status_slik,
            'pengecekan_saldo' => $data->pengecekan_saldo,
            'insentif_awal_marketing' => $data->insentif_awal_marketing,
            'insentif_pihakke3' => $data->insentif_pihakke3,
            'insentif_bulanan_marketing' => $data->insentif_bulanan_marketing,
            'insentif_bulanan_pihak3' => $data->insentif_bulanan_pihak3,
            'users_id' => $data->users_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'active' => $data->active,
            'tmhadiah_id' => $data->tmhadiah_id,
        ]);
    }

    public function getdetail_hadiah()
    {
        if ($this->request->ajax()) {
            $id = $this->request->tmparameter_id;
            $data  = Tmparameter::find($id);
            // if(is_array($data->tmha))
        }
    }

    public function jumlah_rekening($id = null)
    {
        // j_peserta
        if ($this->request->json()) {
            $jumlahdata = $this->request->jumlah_rekening;
            if ($id != '') {
                return view('tazamcore::tmparameter.kode_rek_jumlah', [
                    'jumlah_data' => $jumlahdata
                ]);
            } else {
                return view('tazamcore::tmparameter.kode_rek_jumlah', [
                    'jumlah_data' => $jumlahdata
                ]);
            }
        }
    }

    public function destroy()
    {

        try {
            if (is_array($this->request->id))
                Tmparameter::whereIn('id', $this->request->id)->delete();
            else
                Tmparameter::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Tmparameter $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }

    public function dialog()
    {

        return require_once public_path() . '/vendor/ismarianto/dash/dependencies/filemanager/dialog.php';
    }
}
