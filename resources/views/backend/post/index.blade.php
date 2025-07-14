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
            <!-- success and error message -->
            <div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

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


    <div class="container">
        <div class="row">

            <div>
                <table class="table table-dark table-striped">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">title</th>
                                <th scope="col">Description</th>
                                <th scope="col">image</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->description }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Image" width="100">
                                </td>
                                <td>
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-info">
                                        Edit
                                    </a>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
