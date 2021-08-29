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

class Tmparameter_docController extends Controller
{
    // use Tmparamtertr;
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'tazamcore::tmparameterdoc.';
        $this->route   = 'parameter_doc.';
    }

    public function index()
    {
        $tmparameter = Tmparameter::get();
        $tmhadiah    = Tmhadiah::get();
        return view(
            $this->view . 'index',
            [
                'title' => 'Paramter Data Document',
                'tmparemater' => $tmparameter,
                'tmhadiah' => $tmhadiah
            ]
        );
    }

    public function api()
    {
        $tmparameter_id = $this->request->tmparameter_id;
        $data = Tmparameterdoc::with('tmparameter');
        if ($tmparameter_id) {
            if ($this->request->tmhadiah_id) {
                $fdata = $data->where([
                    'tmparameter_doc.tmparameter_id' => $tmparameter_id,
                    'tmhadiah_id' => $this->request->tmhadiah_id
                ]);
            }
            if ($this->request->category && $this->request->tmhadiah_id) {
                $fdata = $data->where([
                    'tmparameter_doc.tmparameter_id' => $tmparameter_id,
                    'category' => $this->request->category,
                    'tmhadiah_id' => $this->request->tmhadiah_id
                ]);
            }
            $fdata = $data->where('tmparameter_doc.tmparameter_id', $tmparameter_id);
        } else {
            $fdata = [];
        }
        return \DataTables::of($fdata)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-sm" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->editColumn('jenisnya', function ($p) {
                if ($p->kode == 'pmanfaat') {
                    return 'Penerima Manfaat';
                } else if ($p->kode == 'peserta') {
                    return  'Peserta';
                }
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'jenisnya'])
            ->toJson();
    }
    public function create()
    {
        $tmparameter = Tmparameter::get();
        $tmhadiah = Tmhadiah::get();

        return view($this->view . 'form_add', [
            'title' => 'Tambah Menu',
            'tmparameter' => $tmparameter,
            'tmhadiah' => $tmhadiah
        ]);
    }

    public function store()
    {
        try {
            $id = Tmparameterdoc::select(\DB::raw('max(id) as idnya'))->first();

            $getid = ($id->idnya) ? $id->idnya + 1 : 1;
            $f = new Tmparameterdoc;

            $f->id = $getid;
            $f->kode =  $this->request->category;
            $f->nama_doc = $this->request->nama_doc;
            $f->category = $this->request->category;
            $f->status = $this->request->status;
            $f->tmhadiah_id = $this->request->tmhadiah_id;
            $f->tmparameter_id = $this->request->tmparameter_id;
            $f->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function edit($id)
    {
        $data = Tmparameterdoc::find($id);
        $tmparameter = Tmparameter::get();
        $tmhadiah  = Tmhadiah::get();
        return view($this->view . 'form_edit', [
            'id' => $data->id,
            'kode' => $data->kode,
            'nama_doc' => $data->nama_doc,
            'category' => $data->category,
            'status' => $data->status,
            'tmhadiah_id' => $data->tmhadiah_id,
            'tmparameter_id' => $data->tmparameter_id,
            'users_id' => $data->users_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'tmhadiah' => $tmhadiah,
            'tmparameter' => $tmparameter
        ]);
    }
    public function update($id)
    {
        try {
            $f = Tmparameterdoc::find($id);
            $f->kode = $this->request->category;
            $f->nama_doc = $this->request->nama_doc;
            $f->category = $this->request->category;
            $f->status = $this->request->status;
            $f->tmhadiah_id = $this->request->tmhadiah_id;
            $f->tmparameter_id = $this->request->tmparameter_id;
            $f->users_id = Session::get('username');
            $f->updated_at = Carbon::now();
            $f->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function jumlah_rekening($id = null)
    {
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
        dd($this->request->id);
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
