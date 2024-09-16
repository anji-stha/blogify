@extends('layouts.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Permissions / Edit</h3>
            <a class="btn btn-sm btn-danger float-end" href="{{ route('index.permission') }}">Back</a>
        </div>
        <div class="card-body">
            <form class="row g-3" action="{{ route('update.permission', $permission->id) }}" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" value="{{ old('name', $permission->name) }}" class="form-control" id="name"
                        name="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-secondary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
