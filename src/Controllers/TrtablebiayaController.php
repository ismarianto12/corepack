<?php

namespace Ismarianto\Ismarianto\Controllers;

//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use DataTables;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Trbiayapenutupan;

use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Illuminate\Support\Carbon;

class TrtablebiayaController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    protected $relationprimary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'tazamcore::trtablebiaya.';
        $this->route   = 'tablebiaya.';
    }

    public function index()
    {
        $tmparameter = Tmparameter::get();
        return view(
            $this->view . 'index',
            [
                'title' => 'Parameter Ismarianto',
                'tmparemater' => $tmparameter
            ]
        );
    }

    public function api()
    {
        $data = Trbiayapenutupan::with('tmparameter');
        $tmparameter_id  = $this->request->tmparameter_id;
        if ($tmparameter_id == '') {
            $fdata = $data->where('trbiayapenutupan.tmparameter_id', $tmparameter_id);
        } else {
            $fdata = [];
        }
        $fdata = $data->get();
        return \DataTables::of($fdata)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })

            ->editColumn('parameter', function ($p) {
                $data = Tmparameter::where('id', $p->tmparameter_id)->first();
                return $data->nama_prog;
            })

            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-sm" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'parameter'])
            ->toJson();
    }
    public function create()
    {
        $tmparameter  = Tmparameter::get();
        return view($this->view . 'form_add', [
            'title' => 'Tambah Menu',
            'jenisnya' => PhareSpase::hubungan(),
            'tmparameter' => $tmparameter
        ]);
    }



    public function store()
    {
        try {
            $f = new Trbiayapenutupan;
            $f->tmparameter_id = $this->request->tmparameter_id;
            $f->dari_bulan = $this->request->dari_bulan;
            $f->ke_bulan = $this->request->ke_bulan;
            $f->nominal =  str_replace(',', '', $this->request->nominal);
            $f->users_id =  Tmparamtertr::session('username');
            $f->created_at = Carbon::now();
            $f->updated_at =  Carbon::now();

            $f->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Trbiayapenutupan $th) {
            return $th;
        }
    }

    public function edit($id)
    {
        $tmparameter = Tmparameter::get();
        $data = Trbiayapenutupan::findOrFail($id);
        return view($this->view . 'form_edit', [
            'id' => $data->id,
            'dari_bulan' => $data->dari_bulan,
            'ke_bulan' => $data->ke_bulan,
            'nominal' => str_replace(',', '', $data->nominal),
            'tmparameter' => $tmparameter,
            'tmparameter_id' => $data->tmparameter_id
        ]);
    }
    public function update($id)
    {
        try {
            $f = Trbiayapenutupan::find($id);

            $f->tmparameter_id = $this->request->tmparameter_id;
            $f->dari_bulan = $this->request->dari_bulan;
            $f->ke_bulan = $this->request->ke_bulan;
            $f->nominal =  str_replace(',', '', $this->request->nominal);
            $f->users_id =  Tmparamtertr::session('username');
            $f->created_at = Carbon::now();
            $f->updated_at =  Carbon::now();

            $f->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy()
    {
        try {
            if (is_array($this->request->id))
                Trbiayapenutupan::whereIn('id', $this->request->id)->delete();
            else
                Trbiayapenutupan::whereid($this->request->id)->delete();
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
}
