<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\HttpRequests;

class CheckToken
{
    use HttpRequests;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $check_token = $this->post('auth/refresh', [], session()->get('_token'));
        // if(isset($check_token['message']) && $check_token['message'] != 'fail'){
            return $next($request);
        // }else{
            // session()->flush();
            // return route('dashboard');
        // }
    }
}
