<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/', function () {
    return response()->json([
        'message' => 'SORRY!',
        'status' => 'Internal server error!'
    ], 500);

});

Route::any('{url}', function(){
    return redirect('/api');
})->where('url', '.*');
