<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    public function index(Request $request)
    {
        if(session()->get('login') == 'logged_in_successfully'){
            return view('backend.dashboard.dashboard');
        }else {
            return redirect()->route('login')->with('toastr', [
                'success'      => false,
                'type'         => 'danger',
                'title'        => __('base.error'),
                'description'  => __('base.error_login_to_account')
            ]);
        }
    }
}
