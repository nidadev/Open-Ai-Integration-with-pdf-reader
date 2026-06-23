<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI PDF Reader</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #141733;
        }
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.05);
        }
        .container {
            width: min(1040px, calc(100% - 32px));
            margin: 0 auto;
        }
        .navbar .container {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        .navbar-brand {
            color: #15184a;
            font-size: 20px;
            font-weight: 800;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .nav-link {
            color: #4b5563;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            padding: 9px 12px;
            border-radius: 6px;
        }
        .nav-link:hover { background: #f2f4fb; color: #15184a; }
        main { padding: 34px 0 52px; }
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 18px 50px rgba(17, 24, 39, 0.08);
            overflow: hidden;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: #fbfcff;
        }
        .card-header h4 {
            margin: 0;
            color: #15184a;
            font-size: 22px;
        }
        .card-body { padding: 24px; }
        .row { display: flex; gap: 16px; }
        .col { flex: 1; }
        .mb-3 { margin-bottom: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        label { font-weight: 800; color: #15184a; }
        .form-control {
            width: 100%;
            border: 1px solid #d7dce5;
            border-radius: 7px;
            min-height: 44px;
            padding: 10px 12px;
            color: #111827;
            background: #fff;
        }
        textarea.form-control { min-height: 180px; line-height: 1.5; }
        .is-invalid { border-color: #dc2626; }
        .invalid-feedback { color: #dc2626; font-size: 13px; }
        .alert {
            border-radius: 7px;
            padding: 12px 14px;
            font-weight: 700;
        }
        .alert-success { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .btn {
            border: 0;
            border-radius: 7px;
            padding: 12px 18px;
            font-weight: 800;
            cursor: pointer;
        }
        .btn-primary { background: #15184a; color: #fff; }
        .btn-primary:hover { background: #22266b; }
        .text-center { text-align: center; }
        .spinner-border { display: inline-block; margin-left: 6px; }
        .hero {
            padding: 48px 0;
        }
        .hero-panel {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 28px;
            align-items: center;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 34px;
            box-shadow: 0 18px 50px rgba(17, 24, 39, 0.08);
        }
        .eyebrow {
            color: #ef786e;
            font-weight: 800;
            letter-spacing: 0;
            margin-bottom: 10px;
        }
        h1 {
            color: #15184a;
            font-size: clamp(34px, 5vw, 54px);
            line-height: 1.02;
            margin: 0 0 16px;
        }
        .hero p {
            color: #4b5563;
            font-size: 17px;
            line-height: 1.6;
            margin: 0 0 22px;
        }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .button-link {
            display: inline-block;
            text-decoration: none;
            border-radius: 7px;
            padding: 12px 16px;
            font-weight: 800;
        }
        .button-link.primary { background: #15184a; color: #fff; }
        .button-link.secondary { background: #f2f4fb; color: #15184a; }
        .feature-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 12px;
        }
        .feature-list li {
            background: #f7f8fc;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            padding: 13px;
            color: #374151;
            font-weight: 700;
        }
        .policy-page { padding: 20px 0; }
        .policy-content {
            color: #374151;
            line-height: 1.65;
        }
        .policy-content h5 {
            color: #15184a;
            font-size: 18px;
            margin: 24px 0 8px;
        }
        .policy-content p { margin: 0 0 14px; }
        .policy-content a { color: #15184a; font-weight: 800; }
        @media (max-width: 760px) {
            .navbar .container { align-items: flex-start; flex-direction: column; padding: 14px 0; }
            .hero-panel { grid-template-columns: 1fr; padding: 24px; }
            .row { display: block; }
        }
    </style>
    @livewireStyles()
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">AI PDF Reader</a>
                <div class="nav-links">
                    <a class="nav-link" href="{{ route('upload-pdf') }}">Upload PDF</a>
                    <a class="nav-link" href="{{ route('convert-pdf') }}">Search PDF</a>
                    <a class="nav-link" href="{{ route('privacy-policy') }}">Privacy</a>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
    <x-toaster-hub />
    @livewireScripts(['asset_url' => url('/')])
</body>
</html>
