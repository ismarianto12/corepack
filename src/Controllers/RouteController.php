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

class RouteController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    protected $primary_id;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'ismarianto::error_handle.';
        $this->route   = 'parameter.';
        $this->primary_id = PhareSpase::createtazamid();
    }

    public function acces403()
    {
        return view(
            $this->view . '403',
            ['title' => 'Halaman yang anda cari tidak di temukan']
        );
    }
    public function acces404()
    {
    }
}
