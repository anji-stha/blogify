@extends('layouts.main')
@section('content')
    <div class="card">
        <h3 class="card-header">Login Form</h3>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="card-body">
            <form class="row g-3" action="{{ route('authenticate') }}" method="POST">
                @csrf
                <div class="col-md-12 form-floating">
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>"
                        placeholder="">
                    <label for="email" class="form-label">Email Address</label>
                    @if ($errors->has('email'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-12 form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="">
                    <label for="password" class="form-label">Password</label>
                    @if ($errors->has('password'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Remember me
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
