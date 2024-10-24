<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blogify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/homeStyle.css') }}">
</head>

<body>
    @include('layouts.navbar')
    <div class="container">
        @yield('content')
    </div>
    <!-- footer starts -->
    <footer>
        <p><strong>Blogify</strong></p>
        <p>Copyright @ 2024</p>
    </footer>
    <!-- footer ends -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
