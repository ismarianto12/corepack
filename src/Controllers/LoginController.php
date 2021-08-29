<?php

namespace Ismarianto\Ismarianto\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use Ismarianto\Cms\Models\Page;
use Ismarianto\Cms\Models\Post;
use Ismarianto\Dash\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
// use Ismarianto\Ismarianto\Blender\LoginActions as Lg;
use Ismarianto\Ismarianto\Traits\LoginActions as Lg;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illum   inate\Http\Response
     */


    use Lg;


    public function AuthProcessed(Request $request)
    {
        return $this->DoprocessLogin($request);
    }
}
