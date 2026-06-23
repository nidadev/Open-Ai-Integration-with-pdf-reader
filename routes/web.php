<?php

use App\Http\Livewire\ConvertFiletoText;
use App\Http\Livewire\PdfToTextComponent;
use App\Http\Controllers\PdfUploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 
*/

Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/pdf-text', '/upload-pdf');
Route::get('/upload-pdf' ,  PdfToTextComponent::class)->name('upload-pdf');
Route::post('/upload-pdf' ,  [PdfUploadController::class, 'store'])->name('upload-pdf.store');
Route::get('/convert-pdf' ,  ConvertFiletoText::class)->name('convert-pdf');
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
