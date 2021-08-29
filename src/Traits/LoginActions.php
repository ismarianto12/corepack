<?php


/**
 *@author ismarianto 
 */

namespace Ismarianto\Ismarianto\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;
use Closure;

trait LoginActions
{

    public function index()
    {
        // none  
        return view('ismarianto::login');
    }
    public function DoprocessLogin()
    {
        // none 
    }
    function change_pass()
    {
        // none 

    }
    function logout()
    {
        // none 

    }
}
