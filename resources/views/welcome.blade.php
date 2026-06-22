@extends('layouts.app')

@section('content')
<section class="hero">
    <div class="container">
        <div class="hero-panel">
            <div>
                <div class="eyebrow">OpenAI PDF Search Demo</div>
                <h1>Ask questions from uploaded PDF documents.</h1>
                <p>
                    Upload a PDF, extract its text, create searchable document chunks, then ask natural-language
                    questions against the document content.
                </p>
                <div class="actions">
                    <a class="button-link primary" href="{{ route('pdf-text') }}">Upload PDF</a>
                    <a class="button-link secondary" href="{{ route('convert-pdf') }}">Search PDF</a>
                </div>
            </div>
            <ul class="feature-list">
                <li>PDF text extraction</li>
                <li>Embedding/vector search workflow</li>
                <li>OpenAI-powered answers when an API key is configured</li>
                <li>Local demo fallback when no API key is available</li>
            </ul>
        </div>
    </div>
</section>
@endsection
