<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFExtractController;
use App\Http\Controllers\ProgressBarController;
use App\Http\Controllers\OpenAiChatController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
;
Route::get('pdf',[PDFExtractController::class,'extractPdf']);
Route::get('progress',[ProgressBarController::class,'index']);
Route::post('upload-pdf',[ProgressBarController::class,'uploadToSrv']);//upload
Route::get('open-api',[OpenAiChatController::class,'openApiChat']);//upload
