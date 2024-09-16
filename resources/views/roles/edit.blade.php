@extends('layouts.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Rples / Edit</h3>
            <a class="btn btn-sm btn-danger float-end" href="{{ route('index.role') }}">Back</a>
        </div>
        <div class="card-body">
            <form class="row g-3" action="{{ route('update.role', $roles->id) }}" method="POST">
                @csrf
                <div class="col-md-8">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" value="{{ old('name', $roles->name) }}" class="form-control" id="name"
                        name="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="container mt-4">
                    <div class="row">
                        @if ($permissions->isNotEmpty())
                            @foreach ($permissions as $permission)
                                <div class="col-md-3 mb-3">
                                    <div class="form-check">
                                        <input {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }}
                                            type="checkbox" name="permission[]" id="permission-{{ $permission->id }}"
                                            value="{{ $permission->name }}" class="form-check-input">
                                        <label for="permission-{{ $permission->id }}"
                                            class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
