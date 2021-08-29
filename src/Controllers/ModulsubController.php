<?php

namespace Ismarianto\Ismarianto\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use DataTales;
use Ismarianto\Ismarianto\Models\Tmmodul;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Tmlevelakses;
use Illuminate\Support\Facades\Session;

class ModulsubController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        if (Tmparamtertr::session('role') != 'admin') {
            redirect()->route('404');
        }
        $this->request = $request;
        $this->view    = 'ismarianto::modulapp.';
        $this->route   = 'modulapp.';
    }


    public function index()
    {

        $level = Tmlevelakses::get();
        return view(
            'ismarianto::submodulapp.index',
            ['title' => 'Sub Modul ismarianto', 'level' => $level]
        );
    }

    public function api()
    {
        $level = $this->request->level_id;
        $data = Tmmodul::where('id_parent', '!=', 0);
        if ($level) {
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
            ->editColumn('induk_menu', function ($p) {
                $menu =  Tmmodul::where(
                    [
                        'id' => $p->id_parent,
                        'id_parent' => 0
                    ]
                )->first();
                return '<b>' . $menu->nama_menu . '<b>';
            })
            ->editColumn('akses', function ($p) {
                if ($p->level != '') {
                    $levelakses = str_replace('.', '<br /><b>', ucfirst($p->level) . '</b>');
                } else {
                    $levelakses = '';
                }
                return $levelakses;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'akses', 'induk_menu'])
            ->toJson();
    }
    public function create()
    {
        $fonts = PhareSpase::fontawesome();
        $parent = Tmmodul::where('id_parent', '=', 0)->get();
        $level = Tmlevelakses::get();

        return view('ismarianto::submodulapp.form_add', [
            'title' => 'Tambah Menu',
            'level' => $level,
            'parent' => $parent,
            'font' => $fonts,
        ]);
    }

    public function store()
    {

        try {
            $fdata = new Tmmodul;
            $flvevel = implode('.', $this->request->level_akses);

            $fdata->id_parent = $this->request->id_parent;
            $fdata->nama_menu = $this->request->nama_menu;
            $fdata->icon = $this->request->icon;
            $fdata->link = $this->request->link;
            $fdata->aktif = $this->request->aktif;
            $fdata->urutan = $this->request->urutan;
            $fdata->level = $flvevel;
            $fdata->users_id = Tmparamtertr::session('username');
            // $fdata->created_at = $this->request->created_at;
            // $fdata->updated_at = $this->request->updated_at; 
            $fdata->save();
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
        $level = Tmlevelakses::get();
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
            'level' => $level,
            'users_id' => $f->users_id,
            'created_at' => $f->created_at,
            'updated_at' => $f->updated_at,
            'level_akses' => $f->level,
        ]);
    }
    public function update($id)
    {

        $fdata = Tmmodul::find($id);
        $flvevel = implode('.', $this->request->level_akses);
        $fdata->id_parent = $this->request->id_parent;
        $fdata->nama_menu = $this->request->nama_menu;
        $fdata->icon = $this->request->icon;
        $fdata->link = $this->request->link;
        $fdata->aktif = $this->request->aktif;
        $fdata->urutan = $this->request->urutan;
        $fdata->level = $flvevel;
        $fdata->users_id = Session::get('username');


        $fdata->save();
        return response()->json([
            'status' => 2,
            'msg' => 'data berhasil disimpan',
        ]);
    }
    public function destroy(Request $request)
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
