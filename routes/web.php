<?php

use App\Http\Controllers\DownloadCSV;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('/admin');
});
Route::get('/download/csv', DownloadCSV::class)->name('download.csv');
