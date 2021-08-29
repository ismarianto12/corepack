<?php

namespace Ismarianto\Ismarianto\Controllers;
//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexaplikasiController extends controller
{
    // use Tmparamtertr;
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::indexapp.'; // anda dapat mencustomize nama ismarianto sesuai nama folder dir anda
        $this->route   = 'index.';
        $this->primary_id = ''; //define you id primary
    }

    public function index()
    {
        $title =  'Welcome to ismarianto app package builder';
        $parsed =  '';
        $view = $this->view . '.index';
        return view(
            $view,
            [
                'title' => $title,
                'parsed' => $parsed
            ]
        );
    }

    public function api($verifikasi = null)
    {
        // jika ada penggunaan request datatable dan semacamnya
    }

    public function destroy()
    {
        // hapus data 
    }
}
