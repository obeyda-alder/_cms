<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Auth\AuthenticationException;
use App\Traits\CmsTrait;

trait HttpRequests
{
    use CmsTrait;

    protected static function bootHttpRequests()
    {
        //
    }
    public function loginRequest($url, $data = [])
    {
        try {
          $response = Http::post(config('app.api') . $url, $data);
        } catch (\Exception $e) {
            return back()->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => __('base.error_login_to_account')
            ]);
        }

        if (in_array($response->status(), [401, 201]) && !request()->routeIs('login')) {
            return false;
        }
        if($response->status()){
            return json_decode($response->body(), true);
        }
    }
    public function get($url, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token(),
            ])->get(config('app.api') . $url, $data);
        } catch (\Exception $e) {
            return back()->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => $e->getMessage()
            ]);
        }

        if ( in_array($response->status(), [401, 201])) {
            return back()->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => $response->status()
            ]);
        } else if (! $response->successful()) {
            return back()->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => $response->successful()
            ]);
        }
        return json_decode($response->body(), true);
    }
    public function post($url, $data = [])
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token(),
        ])->post(config('app.api') . $url, $data);

        dd($response);
        try {
        } catch (\Exception $e) {
            return back()->with('toastr', [
                'success'      => false,
                'type'         => 'error',
                'title'        => __('base.error'),
                'description'  => __('base.error_login_to_account')
            ]);
        }

        if (in_array($response->status(), [401, 201])) {
            return json_decode($response->body(), true);
        }
        if($response->status()){
            return json_decode($response->body(), true);
        }
    }
}
