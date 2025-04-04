<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Support\Facades\Response;

Route::get('/manifest.json', function () {
    return Response::json(json_decode(file_get_contents(public_path('manifest.json'))));
});

Route::get('/service-worker.js', function () {
    return response()->file(public_path('service-worker.js'));
});


Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '.*');

