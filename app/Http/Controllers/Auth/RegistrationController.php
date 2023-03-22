<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\Helpers\HttpRequests;
use Illuminate\Database\Events\ModelsPruned;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    use HttpRequests;

    public function __construct()
    {
        //
    }
    public function form ()
    {
        try {
            if(session()->get('login') != null && session()->get('login') == 'logged_in_successfully') {
                return redirect()->route('dashboard')->with('toastr', [
                    'success'      => false,
                    'type'         => 'success',
                    'title'        => __('base.error'),
                    'description'  => __('base.error_login_to_account')
                ]);
            }else{
                return view('backend.auth.login');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => __('base.error_login_to_account')
            ]);
        }
    }
    public function login(Request $request)
    {
        $data = ['email' => $request->email,'password' => $request->password];
        $conn = $this->loginRequest('auth/login', $data);
        if($conn && isset($conn['success']) && $conn['success']){
            session([
                'login'              => 'logged_in_successfully',
                '_token'             => $conn['data']['access_token'],
                'expires_token_in'   => $conn['data']['expires_in'],
                '_user'               => $conn['data']['user'],
            ]);

            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login')->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => __('base.error_login_to_account')
            ]);
        }
    }
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
