<?php

namespace Ismarianto\Ismarianto\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use DataTales;
use Ismarianto\Ismarianto\Models\Tmmodul;
use Ismarianto\Ismarianto\Models\Tmlevelakses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ModulappController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::modulapp.';
        $this->route   = 'modulapp.';
    }

    public function index()
    {
        $level = Tmlevelakses::get();

        return view(
            'ismarianto::modulapp.index',
            [
                'title' => 'Modul ismarianto',
                'level' => $level
            ]
        );
    }

    public function api()
    {
        $level = $this->request->level_id;

        $data = Tmmodul::where('id_parent', 0);
        if ($level != '') {
            $fdata =  $data->where(\DB::Raw("CHARINDEX('" . $level . "', [level])"), '>', 0)->get();
        } else {
            $fdata = $data->get();
        }
        return \DataTables::of($fdata)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->editColumn('level', function ($p) {
                if ($p->level != '') {
                    $levelakses = str_replace('.', '<br /><b>', ucfirst($p->level) . '</b>');
                } else {
                    $levelakses = '';
                }
                return $levelakses;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id','level'])
            ->toJson();
    }
    public function create()
    {
        $fonts = PhareSpase::fontawesome();
        $level = Tmlevelakses::get();

        return view('ismarianto::modulapp.form_add', [
            'title' => 'Tambah Menu',
            'font' => $fonts,
            'level' => $level
        ]);
    }

    public function store()
    {
        // $this->request->validate([
        //     'nama_menu' => 'unique:tmmdoul,nama_menu|required',
        // ]);

        try {
            $levelakses = implode('.', $this->request->level_akses);

            $fdata = new Tmmodul();
            $fdata->id_parent = 0;
            $fdata->nama_menu = $this->request->nama_menu;
            $fdata->icon = $this->request->icon;
            $fdata->link = $this->request->link;
            $fdata->aktif = $this->request->aktif;
            $fdata->urutan = $this->request->urutan;
            $fdata->position = $this->request->position;
            $fdata->level = $levelakses;
            $fdata->users_id = Session::get('username');

            $fdata->save();

            return response()->json([
                'status' => 2,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th; // return response()->json([
            //     'status' => 2,
            //     'msg' => $th,
            // ]);
        }
    }

    public function edit($id)
    {
        $f = Tmmodul::findOrFail($id);
        $fonts = PhareSpase::fontawesome();
        $level = Tmlevelakses::get();

        // dd($f->level);
        return view('ismarianto::modulapp.form_edit', [
            'title' => 'Tambah Menu',
            'id' => $f->id,
            'id_parent' => $f->id_parent,
            'nama_menu' => $f->nama_menu,
            'icon' => $f->icon,
            'link' => $f->link,
            'aktif' => $f->aktif,
            'urutan' => $f->urutan,
            'position' => $f->position,
            'level_akses' => $f->level,
            'users_id' => $f->users_id,
            'created_at' => $f->created_at,
            'updated_at' => $f->updated_at,
            'font' => $fonts,
            'level' => $level

        ]);
    }
    public function update($id)
    {
        try {
            $fdata = Tmmodul::find($id);
            $levelakses = implode('.', $this->request->level_akses);


            $fdata->id = $this->request->id;
            $fdata->id_parent = $this->request->id_parent;
            $fdata->id_parent = 0;
            $fdata->nama_menu = $this->request->nama_menu;
            $fdata->icon = $this->request->icon;
            $fdata->link = $this->request->link;
            $fdata->aktif = $this->request->aktif;
            $fdata->urutan = $this->request->urutan;
            $fdata->position = $this->request->position;
            $fdata->level = $levelakses;
            $fdata->users_id = Session::get('username');

            $fdata->save();
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
    public function destroy()
    {

        try {
            if (is_array($this->request->id))
                Tmmodul::whereIn('id', $this->request->id)->delete();
            else
                Tmmodul::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Tmmodul $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
