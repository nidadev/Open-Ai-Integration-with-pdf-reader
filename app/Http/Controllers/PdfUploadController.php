<?php

namespace App\Http\Controllers;

use App\Services\PdfIngestionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PdfUploadController extends Controller
{
    public function store(Request $request, PdfIngestionService $pdfIngestion): RedirectResponse
    {
        $validated = $request->validate([
            'pdf_doc' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        try {
            $result = $pdfIngestion->ingest($validated['pdf_doc']);
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'pdf_doc' => 'The PDF could not be processed: ' . $exception->getMessage(),
                ]);
        }

        $uploadedPdfIds = $request->session()->get('uploaded_pdf_ids', []);
        $uploadedPdfIds[] = $result['pdf']->id;
        $request->session()->put('uploaded_pdf_ids', array_values(array_unique($uploadedPdfIds)));

        return back()->with([
            'message' => 'File created & converted successfully.',
            'convertedText' => $result['text'],
        ]);
    }
}
