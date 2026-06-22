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
Route::get('/pdf-text' ,  PdfToTextComponent::class)->name('pdf-text');
Route::post('/pdf-text' ,  [PdfUploadController::class, 'store'])->name('pdf-text.upload');
Route::get('/convert-pdf' ,  ConvertFiletoText::class)->name('convert-pdf');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
