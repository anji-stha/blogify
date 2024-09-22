@extends('layouts.main')
@section('content')
    @if (Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
            {{ Session::get('message') }}
        </p>
    @endif
    <div class="card">
        <p> Simplicity is the essence of happiness. - Cedric Bledsoe </p>
        Don't be a slave to you mind,
        Make your mind your slave.
    </div>
@endsection
