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
use Ismarianto\Ismarianto\Models\Trhubungan;

class TrhubunganController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::trhubungan.';
        $this->route   = 'trhubungan.';
        $this->primary_id = PhareSpase::createtazamid();
    }

    public function index()
    {
        return view(
            $this->view . 'index',
            [
                'title' => 'Hubungan Parameter',
            ]
        );
    }

    public function api()
    {
        $data = Trhubungan::get();
        return \DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-sm" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id'])
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
            // dd('ss');
            $id = Trhubungan::select(\DB::raw('max(id) as idnya'))->first();

            $getid = ($id->idnya) ? $id->idnya + 1 : 1;
            $f = new Trhubungan;
            $f->id = $getid;
            $f->nama_hubungan = $this->request->nama_hubungan;
            // $f->user_id = Session::get('username');
            $f->create_at = Carbon::now();
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
        $data = Trhubungan::find($id);

        return view($this->view . 'form_edit', [
            'title' => 'Tambah Menu',
            'nama_hubungan' => $data->nama_hubungan,
            'user_id' => $data->user_id,
            'create_at' => $data->create_at,
            'update_at' => $data->update_at,

        ]);
    }
    public function update($id)
    {
        try {
            $f = Trhubungan::find($id);
            $f->id = $this->request->id;
            $f->nama_hubungan = $this->request->nama_hubungan;
            $f->create_at = $this->request->create_at;
            $f->user_id = Session::get('username');
            $f->update_at = Carbon::now();
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
                Trhubungan::whereIn('id', $this->request->id)->delete();
            else
                Trhubungan::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Trhubungan $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
