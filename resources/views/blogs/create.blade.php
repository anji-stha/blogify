@extends('admin.layout.main')
@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Blogs</h3>
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
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">
                                Create Blog
                            </div>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" />
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" />
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category</label>
                                        <div class="row">
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="categories[]"
                                                                id="category-{{ $category->id }}"
                                                                value="{{ $category->name }}" class="form-check-input">
                                                            <label for="category-{{ $category->id }}"
                                                                class="form-check-label">{{ $category->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tags" class="form-label">Tags</label>
                                        <div class="row">
                                            @if ($tags->isNotEmpty())
                                                @foreach ($tags as $tag)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="tags[]"
                                                                id="tag-{{ $tag->id }}" value="{{ $tag->name }}"
                                                                class="form-check-input">
                                                            <label for="tag-{{ $tag->id }}"
                                                                class="form-check-label">{{ $tag->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="image" name="image">
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Body</label>
                                    <textarea id="editor" name="content"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
