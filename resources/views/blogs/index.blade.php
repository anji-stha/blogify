@extends('admin.layout.main')
@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Blogs
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
                    <a class="btn btn-sm btn-primary" href="{{ route('blog.create') }}">Create</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">S.N</th>
                                    <th scope="col" class="text-center">Title</th>
                                    <th scope="col" class="text-center">Description</th>
                                    <th scope="col" class="text-center">Created Date</th>
                                    <th colspan="2" class="text-center">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if ($roles->isNotEmpty())
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('edit.role', $role->id) }}">Edit</a>
                                                <form action="{{ route('delete.role') }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $role->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
