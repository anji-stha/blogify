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
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Trash Blogs</h4>
                    <a href="{{ route('blog.index') }}" class="btn btn-secondary ms-auto">Back</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">S.N</th>
                                    <th scope="col" class="text-center">Title</th>
                                    <th scope="col" class="text-center">Slug</th>
                                    <th scope="col" class="text-center">Description</th>
                                    <th>Status</th>
                                    <th scope="col" class="text-center">Created Date</th>
                                    <th colspan="2" class="text-center">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($blogs->isNotEmpty())
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ Str::ucfirst($blog->title) }}</td>
                                            <td>{{ $blog->slug }}</td>
                                            <td style="width: 50%;">{!! Str::words($blog->body, 50, '...') !!}</td>
                                            <td>{{ Str::ucfirst($blog->status) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('blog.restore', $blog->id) }}">Restore</a>
                                                <form action="{{ route('blog.permanentDelete') }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this blog permanently?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $blog->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete
                                                        Permanently</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $blogs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
