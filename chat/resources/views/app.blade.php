<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Admin</title>
    <!-- Add Bootstrap CSS for styling -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.min.css') }}">
</head>

<body>
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.min.js') }}">

    @yield('scripts')
</body>

</html>
