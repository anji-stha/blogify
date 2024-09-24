@extends('admin.layout.main')
@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Role</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('index.role') }}">Roles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a class="btn btn-sm btn-danger" href="{{ route('index.role') }}">Back</a>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="{{ route('update.role', $roles->id) }}" method="POST">
                        @csrf
                        <div class="col-md-8">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="{{ old('name', $roles->name) }}" class="form-control"
                                id="name" name="name">
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
                                                    type="checkbox" name="permission[]"
                                                    id="permission-{{ $permission->id }}" value="{{ $permission->name }}"
                                                    class="form-check-input">
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
        </div>
    </div>
@endsection
