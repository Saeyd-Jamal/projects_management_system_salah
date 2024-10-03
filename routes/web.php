<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/in', function () {
    $data = \App\Models\User::all();
    return view('in', compact('data'));
})->name('1');


Route::get('/api/data', function () {
    return \App\Models\User::all(); // قم بإرجاع البيانات من قاعدة البيانات
});
require __DIR__.'/dashboard.php';
