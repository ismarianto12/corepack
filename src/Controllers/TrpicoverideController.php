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

class TrpicoverideController extends Controller
{
    // use Tmparamtertr;
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::trpicoveride.';
        $this->route   = 'trpicoveride.';
    }

    public function index()
    {

        $tmparameter = Tmparameter::get();

        return view(
            $this->view . 'index',
            [
                'title' => 'User PIC Overide',
                'tmparameter' => $tmparameter
            ]
        );
    }

    public function api()
    {
        $data = Truseroveride::get();
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
        $tmparameter = Tmparameter::get();
        dd($tmparameter);
        return view($this->view . 'form_add', [
            'title' => 'Tambah Menu',
            'jenisnya' => PhareSpase::hubungan(),
            'tmparameter' => $tmparameter
        ]);
    }


    public function store()
    {
        try {
            $f = new Truseroveride;
            $f->name = $this->request->name;
            $f->username = $this->request->username;
            $f->permision = $this->request->permision;
            $f->users_id = $this->request->users_id;
            $f->created_at = $this->request->created_at;
            $f->updated_at = $this->request->updated_at;
            $f->users_id = Session::get('username');
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
            $f = Truseroveride::find($id);
            $f->name = $this->request->name;
            $f->username = $this->request->username;
            $f->permision = $this->request->permision;
            $f->users_id = $this->request->users_id;
            $f->created_at = $this->request->created_at;
            $f->updated_at = $this->request->updated_at;
            $f->users_id = Session::get('username');
            $f->created_at = Carbon::now();
            $f->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Truseroveride $th) {
            return $th;
        }
    }

    public function destroy()
    {

        try {
            if (is_array($this->request->id))
                Truseroveride::whereIn('id', $this->request->id)->delete();
            else
                Truseroveride::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Truseroveride $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
