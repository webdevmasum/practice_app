<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Onno head er content -->
</head>

<body class="font-sans antialiased">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Post</h1>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">
                    Back to Dashboard
                </a>
                <a href="{{ route('post.create') }}" class="btn btn-info">
                    Create Post
                </a>
            </div>
        </div>
    </div>

</body>

</html>
