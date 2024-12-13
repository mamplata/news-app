<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NewsLetter App</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f7f7f7;
            /* Light background for a cozy feel */
        }

        .navbar-custom {
            background-color: #ac7a48;
            /* Soft cafe-like color */
        }

        .navbar-custom a {
            color: #5a3d35;
            /* Dark brown text for a coffee vibe */
        }

        .search-form .form-label {
            font-weight: bold;
            color: #5a3d35;
        }

        .card-custom {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            border-radius: 8px;
            /* Soft rounded corners */
        }

        .card-custom .card-body {
            padding: 20px;
            flex-grow: 1;
            background-color: white;
            border-radius: 8px;
        }

        .card-custom .btn-link {
            text-decoration: none;
            color: #f8d8b8;
        }

        .search-form button {
            background-color: #5a3d35;
            border: none;
            color: white;
            border-radius: 8px;
            /* Rounded button */
        }

        .search-form button:hover {
            background-color: #3e2b1f;
            /* Darker brown on hover */
        }

        .search-results p {
            color: #777;
        }

        /* Search inputs and button inline */
        .search-form .form-group {
            display: flex;
            align-items: center;
        }

        .search-form .form-control {
            border-radius: 8px;
            margin-right: 10px;
            /* Space between input and button */
        }

        /* Ensuring equal height of all cards */
        .card-custom .card-body {
            flex-grow: 1;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <header>
        @if (Route::has('login'))
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container-fluid">
                    <a class="navbar-brand text-white" href="{{ url('/') }}">NewsLetter App</a>
                    <div class="d-flex justify-content-end">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light text-white mx-2">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light text-white mx-2">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-light text-white mx-2">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </nav>
        @endif
    </header>

    <main>
        <div class="container py-5">
            <!-- Search Form -->
            <form method="GET" action="{{ route('news.search') }}" class="search-form">
                <div class="row mb-4 d-flex align-items-center">
                    <!-- Headline Search -->
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="headline" class="form-label">Headline</label>
                        <input type="text" id="headline" name="headline" class="form-control"
                            value="{{ request('headline') }}">
                    </div>

                    <!-- Author Search -->
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" id="author" name="author" class="form-control"
                            value="{{ request('author') }}">
                    </div>

                    <!-- Date Published Search -->
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="date_published" class="form-label">Date Published</label>
                        <input style="padding: .5rem .75rem;" type="date" id="date_published" name="date_published"
                            class="form-control" value="{{ request('date_published') }}">
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="submit_btn" class="form-label">Search</label>
                        <button type="submit" class="btn btn-primary w-100 p-2">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>
                </div>
            </form>


            <!-- Search Results -->
            <div class="search-results mt-4">
                @if (isset($news) && count($news) > 0)
                    <div class="row">
                        @foreach ($news as $news)
                            <div class="col-md-4">
                                <div class="card mb-4 card-custom">
                                    <div class="card-body">
                                        <strong class="card-title">{{ $news->headline }}</strong>
                                        <p class="card-text">
                                            <em class="text-muted">by {{ $news->author }} on
                                                {{ $news->date_published }}</em>
                                        </p>
                                        <p class="card-text">{{ Str::limit($news->content, 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">No results found.</p>
                @endif
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- jQuery for equal card height -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to adjust card heights
            function adjustCardHeights() {
                var maxHeight = 0;

                // Reset all card heights
                $('.card-custom').height('auto');

                // Find the maximum height of the cards
                $('.card-custom').each(function() {
                    var cardHeight = $(this).outerHeight();
                    if (cardHeight > maxHeight) {
                        maxHeight = cardHeight;
                    }
                });

                // Set all cards to the maximum height
                $('.card-custom').height(maxHeight);
            }

            // Call the function when the page loads
            adjustCardHeights();

            // Re-adjust card heights when the window is resized
            $(window).resize(function() {
                adjustCardHeights();
            });
        });
    </script>
</body>

</html>
