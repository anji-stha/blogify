<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <div class="container mx-auto p-2" style="max-width: 50%; margin-top:50px">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Email Verification</h1>
            </div>
            @if (session('status') == 'verification-link-sent')
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                    A new email verification link has been emailed to you!
                </p>
            @endif
            <div class="card-body">
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <p>Please verify your email address by clicking the link we sent to your email.</p>
                    <button class="btn btn-secondary" type="submit">Resend Verification Email</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
