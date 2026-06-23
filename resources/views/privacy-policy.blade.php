@extends('layouts.app')

@section('content')
<section class="policy-page">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Privacy Policy</h4>
            </div>
            <div class="card-body policy-content">
                <p><strong>Effective date:</strong> June 23, 2026</p>

                <p>
                    AI PDF Reader helps users upload PDF files, extract text, and search or ask questions about
                    the uploaded document content.
                </p>

                <h5>Information we collect</h5>
                <p>
                    When you use the app, you may choose to upload PDF files from your device. The app may process
                    the file name, extracted PDF text, and search questions you enter so the document can be read
                    and searched.
                </p>

                <h5>How we use information</h5>
                <p>
                    Uploaded files and extracted text are used only to provide the PDF reading, conversion, and
                    search features. We do not sell your uploaded documents or personal information.
                </p>

                <h5>AI processing</h5>
                <p>
                    If an AI service is configured, document text and questions may be sent to that service to
                    generate answers. If AI is not available, the demo may use local pattern matching instead.
                </p>

                <h5>Data storage</h5>
                <p>
                    Uploaded PDFs and extracted text may be stored on the server as needed for the app session and
                    demo functionality. Do not upload confidential, financial, legal, medical, or highly sensitive
                    documents unless you are comfortable with this processing.
                </p>

                <h5>Third-party services</h5>
                <p>
                    The app may use hosting services and, when configured, an AI API provider to process document
                    questions. These providers process data only as needed to deliver the app features.
                </p>

                <h5>Children's privacy</h5>
                <p>
                    This app is not intended for children under 13. We do not knowingly collect personal
                    information from children under 13.
                </p>

                <h5>Contact</h5>
                <p>
                    If you have questions about this Privacy Policy, please contact:
                    <a href="mailto:nidaned2004@yahoo.com">nidaned2004@yahoo.com</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
