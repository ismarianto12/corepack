<?php

namespace Ismarianto\Ismarianto\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use DataTales;
use Ismarianto\Ismarianto\Models\Tmmodul;
use Carbon\Carbon;
// use Tmparameterdoc;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;
use Ismarianto\Ismarianto\Models\Tmhadiah;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class TmtableparameterController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::table_doc.';
        $this->route   = 'modulapp.';
    }


    public function index()
    {

        $hadiah  = Tmhadiah::get();
        $catdoc  =  [
            'document' => 'Document Kelengkapan',
            'jaminan' => 'DOcument Jaminan Peserta '
        ];
        return view(
            $this->view,
            [
                'title' => 'Sub Modul ismarianto',
                'jenis_hadiah' => $hadiah,
                'catdoc' => $catdoc
            ]
        );
    }

    public function api()
    {
        $data = Tmparameterdoc::with('tmparameter')->get();
        return \DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id'])
            ->toJson();
    }
    public function create()
    {
        $hadiah  = Tmhadiah::get();
        $catdoc  =  [
            'document' => 'Document Kelengkapan',
            'jaminan' => 'DOcument Jaminan Peserta '
        ];
        $kode = [
            'Peserta' => "Perserta",
            'Pmanfaat' => "Penerima Manfaat"
        ];
        $fkode = $this->request->fkode;
        $category = $this->request->category;
        return view($this->view . 'form_add', [
            'title' => 'Tambah Parameter Document',
            'jenis_hadiah' => $hadiah,
            'tmhadiah_id' => $this->request->tmhadiah_id,
            'catdoc' => $catdoc,
            'kode' => $kode,
            'fkode' => $fkode,
            'category' => $category

        ]);
    }

    public function store()
    {
        try {

            $idnya =  Tmparameterdoc::select(\DB::raw('max(id) as idnya'))->first();
            $id  = ($idnya->idnya > 0) ?  $idnya->idnya + 1 : 1;

            $fdata = new Tmparameterdoc;
            $fdata->id = $id;
            $fdata->kode = $this->request->kode;
            $fdata->nama_doc = $this->request->nama_doc;
            $fdata->category = $this->request->category;
            $fdata->status = $this->request->status;
            $fdata->tmhadiah_id = $this->request->tmhadiah_id;
            $fdata->tmparameter_id = $this->request->tmparameter_id;
            $fdata->users_id = Session::get('username');
            $fdata->created_at = Carbon::now()->format('Y-m-d h:i:s');
            $fdata->updated_at = Carbon::now()->format('Y-m-d h:i:s');
            $fdata->save();

            // DB::unprepared('SET IDENTITY_INSERT tmparameter_doc OFF');

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
            // return response()->json([
            //     'status' => 2,
            //     'msg' => $th,
            // ]);
        }
    }

    public function edit($id)
    {
        $parent = Tmmodul::where('id_parent', 0)->get();
        $fonts = PhareSpase::fontawesome();

        $f = Tmmodul::findOrFail($id);
        // dd($f);
        return view('ismarianto::submodulapp.form_edit', [
            'title' => 'Tambah Menu',
            'id' => $f->id,
            'id_parent' => $f->id_parent,
            'font' => $fonts,
            'nama_menu' => $f->nama_menu,
            'parent' => $parent,
            'icon' => $f->icon,
            'link' => $f->link,
            'aktif' => $f->aktif,
            'urutan' => $f->urutan,
            'position' => $f->position,
            'level' => $f->level,
            'users_id' => $f->users_id,
            'created_at' => $f->created_at,
            'updated_at' => $f->updated_at,
        ]);
    }
    public function update($id)
    {
        try {
            Tmparameterdoc::unprepared('SET IDENTITY_INSERT tmparameter_doc ON');

            $fdata = Tmparameterdoc::find($id);
            $fdata->kode = $this->request->kode;
            $fdata->nama_doc = $this->request->nama_doc;
            $fdata->category = $this->request->category;
            $fdata->status = $this->request->status;
            $fdata->tmhadiah_id = $this->request->tmhadiah_id;
            $fdata->tmparameter_id = $this->request->tmparameter_id;
            $fdata->users_id = Session::get('username');
            $fdata->created_at = Carbon::now()->format('Y-m-d h:i:s');
            $fdata->updated_at = Carbon::now()->format('Y-m-d h:i:s');
            $fdata->save();
            Tmparameterdoc::unprepared('SET IDENTITY_INSERT tmparameter_doc OFF');


            return response()->json([
                'status' => 2,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 2,
                'msg' => $th,
            ]);
        }
    }
    public function destroy(Request $request)
    {
        // dd($this->request->id);
        try {
            if (is_array($this->request->id))
                Tmparameterdoc::whereIn('id', $this->request->id)->delete();
            else
                Tmparameterdoc::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Tmparameterdoc $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
