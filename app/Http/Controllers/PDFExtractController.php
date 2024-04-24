<?php

namespace App\Http\Controllers;
use App\Models\FileUpload;
use Illuminate\Http\Request;

class PDFExtractController extends Controller
{
    //
    public function extractPdf()
    {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseContent(file_get_contents(public_path('upload\1.pdf')));
        //$parser->parseFile(public_path('upload\1.pdf'));
        //dd($pdf);
        
        $text = $pdf->getText();
        echo $text."<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
    }
}
