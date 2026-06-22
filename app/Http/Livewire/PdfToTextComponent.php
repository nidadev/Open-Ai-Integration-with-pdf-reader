<?php

namespace App\Http\Livewire;

use App\Services\PdfIngestionService;
use Livewire\Component;
use Livewire\WithFileUploads;

class PdfToTextComponent extends Component
{
    use WithFileUploads;
    public $pdf_doc, $convertedText;

    protected $rules = [
        'pdf_doc' => ['required','mimes:pdf'],
    ];

    public function getFile()
    {
        $this->validate();
        $result = app(PdfIngestionService::class)->ingest($this->pdf_doc);

        $this->convertedText = $result['text'];
        $this->reset('pdf_doc');
        session()->flash('message', 'File created & converted Successfully');
    }

    public function render()
    {
        return view('livewire.pdf-to-text-component')->extends('layouts.app')->section('content');
    }
}
