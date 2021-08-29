<?php

namespace Ismarianto\Ismarianto\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ismarianto\Ismarianto\Lib\StatuApp;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Cms\Models\Page;
use Ismarianto\Cms\Models\Post;
use Ismarianto\Dash\Models\Menu;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use Ismarianto\Ismarianto\Models\Tmoveride;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Trhubungan;
use Ismarianto\Ismarianto\Models\Tmaplikasi;
use Ismarianto\Ismarianto\Models\Trpenerimamanfaat;
use Ismarianto\Ismarianto\Traits\NasabahApirek;
use Ismarianto\Ismarianto\Traits\Overide;
use DataTables;
use Illuminate\Support\Facades\Session;
use Ismarianto\Ismarianto\Models\Tmsla;
use Ismarianto\Ismarianto\Models\Tmhadiah;
use Ismarianto\Ismarianto\Models\Trpenerima_manfaat;
use Carbon\Carbon;
use Ismarianto\Ismarianto\Lib\StatusApp;
use Ismarianto\Ismarianto\Models\Troveride;

class NasabahController extends Controller
{

    use NasabahApirek;
    use Overide;

    public $request;
    public $view;
    public $route;

    function __construct(Request $request)
    {

        $this->request = $request;
        $this->view = 'ismarianto::.nasabah.';
        $this->route = 'nasabah.';
    }

    public function index()
    {
        return view($this->view . 'index', [
            'title' => 'Data Nasabah'
        ]);
    }
    public function api()
    {
        $username = Session::get('username');
        $ref_cabang = Session::get('unit');
        $datanasabah = Tmnasabah::select(\DB::raw('tmnasabah.id as id'), 'tmnasabah.created_at', 'tmnasabah.updated_at', 'tmnasabah.no_aplikasi', 'tmnasabah.nama_sesuai_ktp', 'tmnasabah.users_id', 'tmstatus_aplikasi.keterangan_status')
            ->join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->join('tmparameter', 'tmaplikasi.tmparameter_id', '=', 'tmparameter.id')
            ->join('tmhadiah', 'tmhadiah.id', '=', 'tmaplikasi.tmhadiah_id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap')
            ->join('tmstatus_aplikasi', 'tmsla.tmstatus_aplikasi_id', '=', 'tmstatus_aplikasi.id')
            ->distinct();
        if (Tmparamtertr::session('role') == 'marketing') {
            $data = $datanasabah->where('tmaplikasi.tmref_cabang_id', $ref_cabang)
                ->where('tmnasabah.users_id', $username)
                ->get();
        } else {
            $data = $datanasabah->get();
        }
        // dd($data);
        return \DataTables::of($data)
            ->editColumn('action', function ($p) {
                $cek_overide = Tmoveride::where('no_aplikasi', $p->no_aplikasi)->first();
                $status = isset($cek_overide->status) ? $cek_overide->status : '';
                if ($status == 2) {
                    return  '<a href="' . route('nasabah.edit', $p->id) . '" class="btn btn-danger btn-sm" ><i class="fa fa-edit"></i>Revise Om Cabang</a> ';
                } else {
                    return '<a class="badge badge-warning">' . $p->keterangan_status . '</a>';
                }
            }, true)
            ->editColumn('j_penerimanfaat', function ($p) {
                $j = Trpenerimamanfaat::where('no_aplikasi', $p->no_aplikasi)->count();
                $url = Url('detilpmanfaat/' . $p->no_aplikasi);
                return  '<a class="btn btn-primary btn-sm" onclick="javascript:detail_pmanfaat(\'' . $url . '\')">' . $j . '</a>';
            }, true)
            ->editColumn('progress', function ($p) {
                $percent  = StatusApp::percentage($p->no_aplikasi);
                return $percent;
            }, true)
            ->editColumn('jenis', function ($p) {
                return 'Kosong';
            }, true)
            ->editColumn('user_marketing', function ($p) {
                return ($p->users_id) ? $p->users_id : 'Kosong';
            }, true)
            // Created_at Setting Time Create Nasabah
            ->editColumn('created_at', function ($p) {
                $phpdate = strtotime($p->created_at);
                $sqldate = date('Y-M-d', $phpdate);
                return $sqldate;
            }, true)
            ->addIndexColumn()
            ->rawColumns([
                'j_penerimanfaat',
                'progres',
                'jenis',
                'user_marketing',
                'created_at', 'action'
            ])
            ->toJson();
    }

    public function create()
    {
        $hubungan = Trhubungan::get();
        $tazamprogram = Tmparameter::get();
        return view($this->view . '.form_add', [
            'title' => 'Nasabah Baru',
            'tmhadiah' => Tmhadiah::get(),
            'program' => $tazamprogram,
            'hubungan' => $hubungan
        ]);
    }

    public function store()
    {
        try {

            $no_aplikasi_id = Tmparamtertr::generate();
            $data = new Tmnasabah;
            $data->no_aplikasi = $no_aplikasi_id;
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
            $data->umur_peserta = $this->request->umur_peserta;
            $data->users_id = session::get('username');
            $data->save();

            // insert aplikasi 
            $aplikasi = new Tmaplikasi;
            $aplikasi->no_aplikasi = $data->no_aplikasi;
            $aplikasi->tmhadiah_id = $this->request->hadiah;
            $aplikasi->tmparameter_id = $this->request->tmparameter_id;
            $aplikasi->tmref_cabang_id = Session::get('unit');
            $aplikasi->save();

            // dd($no_aplikasi_id);

            $jpmanfaat = $this->request->penerima_manfaat;
            for ($i = 1; $i <= $jpmanfaat; $i++) {
                Trpenerimamanfaat::Insert([
                    'no_aplikasi' => $no_aplikasi_id,
                    'nama' => $this->request->input('nama_penerima_manfaat_' . $i),
                    'usia' => $this->request->input('usia_penerima_manfaat_' . $i),
                    'hubungan' => $this->request->input('hubungan_penerima_manfaat_' . $i),
                    'tmhadiah_id' => $this->request->input('pilihan_hadiah_penerima_manfaat_' . $i),
                    'no_hp' => $this->request->input('no_hp_penerima_manfaat_' . $i),
                    'email' => $this->request->input('email_penerima_manfaat_' . $i),
                    'alamat' => $this->request->input('alamat_penerima_manfaat_' . $i),
                    'users_id' => session::get('username'),
                ]);
            }
            $rsover  = $this->cekoveride($no_aplikasi_id);
            // dd($rsover);

            if (!empty($rsover['peserta']) || !empty($rsover['pmanfaat'])) {
                $overideid = 1;
                $ovrmsg = [
                    'pmanfaat' => isset($rsover['pmanfaat']) ? $rsover['pmanfaat'] : '',
                    'peserta' => isset($rsover['peserta']) ? $rsover['peserta'] : ''
                ];

                Tmparamtertr::setstatus(
                    [
                        'no_ap' => $no_aplikasi_id,
                        'status' => 2,
                        'kode' => 2,
                    ]
                );
            } else {
                $ovrmsg  =  [
                    'pmanfaat' => '',
                    'peserta' => ''
                ];
                // create sebagai aplikasi baru aplicant jika tidak ada overide
                $parameter = Tmparameter::find($this->request->tmparameter_id);
                // dd($parameter['otomatis_slik']);
                if ($parameter['otomatis_slik'] == 1) {
                    Tmparamtertr::setstatus(
                        [
                            'no_ap' => $no_aplikasi_id,
                            'status' => 7,
                            'kode' => 7,
                        ]
                    );
                    $overideid = 0;
                } else {
                    $overideid = 0;
                    Tmparamtertr::setstatus(
                        [
                            'no_ap' => $no_aplikasi_id,
                            'status' => 12,
                            'kode' => 12,
                        ]
                    );
                }
                // else {
                //     $this->doprocessRekInduk($data->no_aplikasi);
                //     $this->doprocessSMS($data->no_aplikasi);
                // }
                Tmaplikasi::where(['no_aplikasi' => $no_aplikasi_id])->first()->update([
                    'overide' => $overideid,
                    'tmref_cabang_id' => Session::get('unit')
                ]);
            }

            $parameter = Tmparameter::find($this->request->tmparameter_id);
            // dd($parameter['otomatis_slik']);
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
                'msg_overide' => $ovrmsg
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function testover($no_aplikasi)
    {
        $rsover  = $this->cekoveride($no_aplikasi);
        return $rsover;
    }

    public function edit($id)
    {
        // case only if nasabah overide
        $data = Tmnasabah::findOrfail($id);
        $overide = Tmoveride::where('no_aplikasi', $data->no_aplikasi)->firstOrFail();
        if ($overide->status != 2) {
            return abort(404, 'Data overide tidak ada dengan status di revise');
        }


        $tazamprogram = Tmparameter::get();

        $data_penerima_manfaat =  Trpenerimamanfaat::select(\DB::raw('count(no_aplikasi) as jmanfaat'))->where('no_aplikasi', $data->no_aplikasi)->first();
        $jcount = ($data_penerima_manfaat->jmanfaat);

        $hadiah = Tmhadiah::get();

        $aplikasi = Tmaplikasi::where('no_aplikasi', $data->no_aplikasi)->first();
        $mhubungan = Trhubungan::get();
        // dd($aplikasi);
        //komponnent yang di perlukan untuk status ini 

        $overpeserta = Tmoveride::where([
            'no_aplikasi' => $data->no_aplikasi,
            'jenis' => 'peserta'
        ])->first();
        $overpmanfaat = Tmoveride::where([
            'no_aplikasi' => $data->no_aplikasi,
            'jenis' => 'pmanfaat'
        ])->first();


        $catatan_revise_peserta  = $overpeserta->catatan_cabang;
        $catatan_revise_pmanfaat =  $overpmanfaat;

        // status overide
        $overide_status = isset($overide->status) ? $overide->status : 0;

        return view($this->view . '.form_edit', [
            'data_penerima_manfaat' => $data_penerima_manfaat->first(),
            'title' => 'Edit data nasabah ' . $data->no_aplikasi,
            'program' => $tazamprogram,
            'tmhadiah' => Tmhadiah::get(),
            'jumlah_penerima_manfaat' => $jcount,
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
            'kategori_nasabah' => $data->kategori_nasabah,
            'tujuan_penggunaan' => $data->tujuan_penggunaan,
            'nama_kelurahan' => $data->nama_kelurahan,
            'nominal_setor_tunai' => $data->nominal_setor_tunai,
            'users_id' => $data->users_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'umur_peserta' => $data->umur_peserta,
            'status_peserta' => $data->status_peserta,
            'hadiah' => $hadiah,
            'tmparameter_id' => $aplikasi->tmparameter_id,
            'tmhadiah_id' => $aplikasi->tmhadiah_id,
            'hubungan' => $mhubungan,
            // /jika status overide
            'catatan_revise_peserta' => $catatan_revise_peserta,
            'catatan_revise_pmanfaat' => $catatan_revise_pmanfaat,
            'overide_status' => $overide_status,
            'keterangan_overide' => isset($overpeserta->keterangan_overide) ? $overpeserta->keterangan_overide : [],
        ]);
    }

    public function update($id, Request $request)
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
            $data->umur_peserta = $this->request->umur_peserta;

            $data->save();

            $jpmanfaat = $this->request->penerima_manfaat;
            $overidepmanfaat = Tmoveride::where([
                'no_aplikasi' => $data->no_aplikasi,
                'jenis' => 'pmanfaat',
            ])->first();
            if ($overidepmanfaat) {
                for ($i = 1; $i <= $jpmanfaat; $i++) {
                    Trpenerimamanfaat::where('no_aplikasi', $data->no_aplikasi)->update([
                        'no_aplikasi' => $this->request->input('no_aplikasi'),
                        'nama' => $this->request->input('nama_penerima_manfaat_' . $i),
                        'usia' => $this->request->input('usia_penerima_manfaat_' . $i),
                        'hubungan' => $this->request->input('hubungan_penerima_manfaat_' . $i),
                        'tmhadiah_id' => $this->request->input('tmhadiah_id_' . $i),
                        'no_hp' => $this->request->input('no_hp_penerima_manfaat_' . $i),
                        'email' => $this->request->input('email_penerima_manfaat_' . $i),
                        'alamat' => $this->request->input('alamat_penerima_manfaat_' . $i),
                        'tgl_lahir' => $this->request->input('tgl_lahir_' . $i),
                    ]);
                }
            }

            $rsover  = $this->cekoveride($data->no_aplikasi);
            if (count($rsover) > 0) {
                $overideid = 1;
                $ovrmsg = [
                    'pmanfaat' => isset($rsover['pmanfaat']) ? $rsover['pmanfaat'] : '',
                    'peserta' => isset($rsover['peserta']) ? $rsover['peserta'] : ''
                ];
            } else {
                $overideid = 0;
                Tmparamtertr::setstatus(
                    [
                        'no_ap' => $data->no_aplikasi,
                        'status' => 11,
                        'kode' => 11,
                    ]
                );
            }
            // by pass ke upload document peserta 
            // Tmparameter::where(['no_aplikasi' => $data->no_aplikasi])->first()->update([
            //     'tmoveveride_id' => $overideid,
            //     'tmref_cabang_id' => Session::get('unit')
            // ]);

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil simpan',
                'msg_overide' => $ovrmsg
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function jum_penerima_manfaat()
    {
        if ($this->request->ajax()) {
            $passed = $this->request->jumlah_penerima_manfaat;
            $nomor_aplikasi = $this->request->no_aplikasi;
            $data_penerima_manfaat =  Trpenerimamanfaat::where('no_aplikasi', $nomor_aplikasi);
            $hadiah = Tmhadiah::get();
            $hubungan = Trhubungan::get();

            $hasdata = [];
            $j = 1;
            $loopingdata = $data_penerima_manfaat->get();
            foreach ($loopingdata as $hasdatas) {
                $hasdata['no_aplikasi'][$j] = $hasdatas['no_aplikasi'];
                $hasdata['nama'][$j] = $hasdatas['nama'];
                $hasdata['usia'][$j] = $hasdatas['usia'];
                $hasdata['hubungan'][$j] = $hasdatas['hubugnan'];
                $hasdata['tmhadiah_id'][$j] = $hasdatas['tmhadiah_id'];
                $hasdata['no_hp'][$j] = $hasdatas['no_hp'];
                $hasdata['email'][$j] = $hasdatas['email'];
                $hasdata['alamat'][$j] = $hasdatas['alamat'];
                $j++;
            }
            return view('ismarianto::nasabah.jum_penerima_manfaat', [
                'data_penerima_manfaat' => $data_penerima_manfaat,
                'passed' => $passed,
                'tmhadiah' => $hadiah,
                'hubungan' => $hubungan,
                'nomor_aplikasi' => $nomor_aplikasi,
                'hasdata' => $hasdata,
            ]);
        }
    }

    public function jum_penerima_edit()
    {
        if ($this->request->ajax()) {
            $passed = $this->request->jumlah_penerima_manfaat;
            $nomor_aplikasi = $this->request->no_aplikasi;
            $data_penerima_manfaat =  Trpenerimamanfaat::where('no_aplikasi', $nomor_aplikasi);
            $hadiah = Tmhadiah::get();
            $hubungan = Trhubungan::get();

            // get data penerima manfaat
            $overpmanfaat = Tmoveride::where(
                [
                    'no_aplikasi' => $nomor_aplikasi,
                    'jenis' => 'pmanfaat'
                ]
            );
            if ($overpmanfaat->count() > 0) {
                $catatan  = $overpmanfaat->first()->keterangan_overide;
                $status   = 0;
            } else {
                $catatan  = [];
                $status   = '';
            }

            $j = 1;
            $loopingdata = $data_penerima_manfaat->get();
            foreach ($loopingdata as $hasdatas) {
                $overidepmanfaat = Tmoveride::where([
                    'no_aplikasi' => $nomor_aplikasi,
                    'jenis' => 'pmanfaat',
                ])->first();

                // $hasdata[$j]['no_aplikasi']['val'] = $hasdatas['no_aplikasi'];
                // $hasdata[$j]['nama']['val'] = $hasdatas['nama'];
                // $hasdata[$j]['usia']['val'] = $hasdatas['usia'];
                // $hasdata[$j]['hubungan']['val'] = $hasdatas['hubugnan'];
                // $hasdata[$j]['tmhadiah_id']['val'] = $hasdatas['tmhadiah_id'];
                // $hasdata[$j]['no_hp']['val'] = $hasdatas['no_hp'];
                // $hasdata[$j]['email']['val'] = $hasdatas['email'];
                // $hasdata[$j]['alamat']['val'] = $hasdatas['alamat'];
                if (!$overidepmanfaat) {
                    $hasdata[$j]['overide_status']['val'] = '';
                    $hasdata[$j]['catatan_cabang']['val'] = '';
                    $hasdata[$j]['catatan_pusat']['val'] = '';
                    $hasdata[$j]['keterangan_overide']['val'] = '';
                } else {
                    $hasdata[$j]['overide_status']['val'] = $overidepmanfaat['status'];
                    $hasdata[$j]['catatan_cabang']['val'] = $overidepmanfaat['catatan_cabang'];
                    $hasdata[$j]['catatan_pusat']['val'] = $overidepmanfaat['catatan_pusat'];
                    $hasdata[$j]['keterangan_overide']['val'] = $overidepmanfaat['status'];
                }
                $j++;
            }
            $fhasdata = isset($hasdata) ? $hasdata : [];
            return view('ismarianto::nasabah.jum_penerima_manfaat_edit', [
                'tmhadiah' => $hadiah,
                'hubungan' => $hubungan,
                'data_penerima_manfaat' => $loopingdata,
                'passed' => $passed,
                'nomor_aplikasi' => $nomor_aplikasi,
                'hasdata' => $fhasdata,
                'catatan' => $catatan,
                'status' => $status
            ]);
        }
    }

    // function get detail and more data 
    function getdatailnasabah($no_apl)
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
            'tmhadiah.jenis_hadiah'

        )->join('tmaplikasi', 'tmaplikasi.no_aplikasi', '=', 'tmnasabah.no_aplikasi')
            ->join('tmparameter', 'tmparameter.id', '=', 'tmaplikasi.tmparameter_id')
            ->join('tmhadiah', 'tmaplikasi.tmhadiah_id', '=', 'tmhadiah.id')
            ->join('tmsla', 'tmnasabah.no_aplikasi', '=', 'tmsla.no_ap', 'left')
            ->join('tmstatus_aplikasi', 'tmstatus_aplikasi.id', '=', 'tmsla.tmstatus_aplikasi_id')
            ->where('tmnasabah.no_aplikasi', $no_apl)
            ->firstOrFail();

        $no_aplikasinasabah = $nasabah->no_aplikasi;

        $penmanfaat = Trpenerima_manfaat::where('trpenerima_manfaat.no_aplikasi', $no_aplikasinasabah)->get();


        return view($this->view . 'detail_nasabah', [
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
            'pmanfaat_data' => $penmanfaat,
        ]);
    }


    public function detilpmanfaat($no_aplikasi)
    {

        $data  = Trpenerimamanfaat::select(
            'trpenerima_manfaat.no_aplikasi',
            'trpenerima_manfaat.nama',
            'trpenerima_manfaat.usia',
            'trpenerima_manfaat.tmhadiah_id',
            'trpenerima_manfaat.hubungan',
            'trpenerima_manfaat.no_hp',
            'trpenerima_manfaat.email',
            'trpenerima_manfaat.alamat',
            'trpenerima_manfaat.users_id',
            'trpenerima_manfaat.created_at',
            'trpenerima_manfaat.updated_at',
            'trpenerima_manfaat.tmparameter_id',
            'trpenerima_manfaat.tgl_lahir',
            'tmhadiah.jenis_hadiah',
        )->join('tmaplikasi', 'trpenerima_manfaat.no_aplikasi', '=', 'tmaplikasi.no_aplikasi')
            ->join('tmhadiah', 'trpenerima_manfaat.tmhadiah_id', '=', 'tmhadiah.id')
            ->where('trpenerima_manfaat.no_aplikasi', $no_aplikasi)
            ->distinct()
            ->get();
        // get
        $trhubungan = Trhubungan::get();
        $tmhadiah = Tmhadiah::get();

        return view($this->view . '.detail_penerima_manfaat', [
            'data' => $data,
            'hubungan' => $trhubungan,
            'tmhadiah' => $tmhadiah,
        ]);
    }
    public function pr($no_aplikasi)
    {
        $percent  = StatusApp::percentage($no_aplikasi);
        return $percent;
    }
    public function devrest()
    {
        Tmnasabah::truncate();
        Tmaplikasi::truncate();
        Tmsla::truncate();
        Tmoveride::truncate();
        Trpenerimamanfaat::truncate();
    }
    public function destroy()
    {
        if (is_array($this->request->id)) {
            try {
                $par = Tmnasabah::whereIn('id', $this->request->id);
                $par->delete();
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }
}
