@extends('layouts.main')
@section('content')
    <div class="card">
        <h3 class="card-header">Registration Form</h3>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="card-body">
            <form class="row g-3" action="{{ route('register', ['type' => 'viewer']) }}" method="POST">
                @csrf
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control" id="inputName" name="inputName" value="<?= old('inputName') ?>"
                        placeholder="">
                    <label for="inputName" class="form-label">First Name</label>
                    @if ($errors->has('inputName'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputName') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control" id="inputLName" name="inputLName"
                        value="<?= old('inputLName') ?>" placeholder="">
                    <label for="inputLName" class="form-label">Last Name</label>
                    @if ($errors->has('inputLName'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputLName') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                        value="<?= old('inputEmail') ?>" placeholder="">
                    <label for="inputEmail" class="form-label">Email</label>
                    @if ($errors->has('inputEmail'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputEmail') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder=""
                        value="<?= old('inputAddress') ?>">
                    <label for="inputAddress" class="form-label">Address</label>
                    @if ($errors->has('inputAddress'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputAddress') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="">
                    <label for="inputPassword" class="form-label">Password</label>
                    @if ($errors->has('inputPassword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputPassword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <input type="password" class="form-control" id="inputPassword_confirmation"
                        name="inputPassword_confirmation" placeholder="">
                    <label for="inputPassword_confirmation" class="form-label">Confirm Password</label>
                    @if ($errors->has('inputPassword_confirmation'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputPassword_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control" id="inputPhone" name="inputPhone"
                        value="<?= old('inputPhone') ?>" placeholder="">
                    <label for="inputPhone" class="form-label">Phone Number</label>
                    @if ($errors->has('inputPhone'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputPhone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-floating">
                    <select id="inputGender" name="inputGender" class="form-select">
                        <option value="" disabled selected>Choose...</option>
                        <option value="1" <?= old('inputGender') == 1 ? 'selected' : '' ?>>Male</option>
                        <option value="2" <?= old('inputGender') == 2 ? 'selected' : '' ?>>Female</option>
                        <option value="3" <?= old('inputGender') == 3 ? 'selected' : '' ?>>Others</option>
                    </select>
                    <label for="inputGender" class="form-label">Gender</label>
                    @if ($errors->has('inputGender'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('inputGender') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
@endsection
