<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;

class ProgressBarController extends Controller
{
    //
    public function index()
    {
        return view('progress');
    }
    public function uploadToSrv(Request $request)
    {
        //dd(request()->file);
        $request->validate([
            'file' => 'required',
        ]);

        $name = request()->file->getClientOriginalName();
        $request->file->move(public_path('upload'), $name);
        $file = new FileUpload;
        $file->name = $name;
        $file->save();

        return response()->json(['success' => 'uploaded']);
    }
}
