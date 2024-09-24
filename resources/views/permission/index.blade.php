@extends('admin.layout.main')
@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Permissions</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Permissions
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
                    <a class="btn btn-sm btn-primary" href="{{ route('create.permission') }}">Create</a>
                </div>
                @include('message')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">S.N</th>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Created Date</th>
                                    <th colspan="2" class="text-center">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $key => $permission)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('edit.permission', $permission->id) }}">Edit</a>
                                                <form action="{{ route('delete.permission') }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $permission->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
