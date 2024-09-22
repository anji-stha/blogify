@if (Session::has('success'))
    <ul class="navbar-nav ms-auto">
        <p class="nav-item alert {{ Session::get('alert-class', 'alert-info') }}">
            {{ Session::get('success') }}
        </p>
    </ul>
@endif
@if (Session::has('error'))
    <ul class="navbar-nav ms-auto">
        <p class="nav-item alert {{ Session::get('alert-class', 'alert-danger') }}">
            {{ Session::get('error') }}
        </p>
    </ul>
@endif
