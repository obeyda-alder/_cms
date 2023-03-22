<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserTypesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( $request->user() ) return $next($request);

        if ( ! empty( $types ) )
            if ( in_array('GUEST', $types) )
                if ( ! auth()->check() ) return $next($request);

        if ( ! \Auth::check() )
            goto Redirect;

        if ( empty( $types ) )
            goto Redirect;

        foreach ($types as $key => $type) {
            if ( $type != 'GUEST' )
                if ( $request->user()->isAn( $type ) ) return $next($request);

        }

        Redirect :
            if ($request->is('*/admin/*')) return redirect()->route('login');

            if ( ! auth()->check() ) return redirect()->route('login');
    }
}
