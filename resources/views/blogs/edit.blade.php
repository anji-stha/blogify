@extends('admin.layout.main')
@section('content')
    <style>
        #thumbnailPreview {
            max-width: 40%;
            height: auto;
            display: block;
            margin-top: 10px;
        }
    </style>
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
                <div id="responseMessage"></div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0">Update Blog</h5>
                            <a href="{{ route('blog.index') }}" class="btn btn-secondary ms-auto">Back</a>
                        </div>
                        <form action="{{ route('blog.update', ['id' => $blog->id]) }}" method="POST"
                            enctype="multipart/form-data" id="editBlogForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ $blog->title }}" />
                                            <div class="invalid-input" id="titleError" style="display: none;"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="{{ $blog->slug }}" />
                                            <div class="invalid-input" id="slugError" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <label for="status" class="form-label">Post Status</label>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="draft" value="draft"
                                                        {{ $blog->status === 'draft' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="draft">
                                                        Draft
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="publish" value="published"
                                                        {{ $blog->status === 'published' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="publish">
                                                        Publish
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="categories" class="form-label">Select
                                                        Categories</label>
                                                    @if ($categories->isNotEmpty())
                                                        <select name="categories[]" id="categories"
                                                            class="form-control select2" multiple="multiple">
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ $hasCategory->contains($category->name) ? 'selected' : '' }}>
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <p>No Categories Available</p>
                                                    @endif
                                                </div>
                                                <div class="invalid-input" id="categoryError" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tags" class="form-label">Select
                                                        Tags</label>
                                                    @if ($tags->isNotEmpty())
                                                        <select name="tags[]" id="tags" class="form-control select2"
                                                            multiple="multiple">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->id }}"
                                                                    {{ $hasTag->contains($tag->name) ? 'selected' : '' }}>
                                                                    {{ $tag->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <p>No tags available</p>
                                                    @endif
                                                    <div class="invalid-input" id="tagError" style="display: none;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                                    <div id="oldThumbnailContainer">
                                        @if ($blog->thumbnail)
                                            <img id="thumbnailPreview" src="{{ asset('storage/' . $blog->thumbnail) }}">
                                        @else
                                            <p>No thumbnail available</p>
                                        @endif
                                    </div>
                                    <div class="invalid-input" id="thumbnailError" style="display: none;"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Body</label>
                                    <textarea id="editor" name="content">{{ $blog->body }}</textarea>
                                    <div class="invalid-input" id="contentError" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value
            const slug = title.toLowerCase()
                .trim()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')

            document.getElementById('slug').value = slug
        })

        // Form submission
        document.getElementById('editBlogForm').addEventListener('submit', function(event) {
            event.preventDefault()

            const errorFields = document.querySelectorAll('.invalid-input')
            errorFields.forEach(field => {
                field.style.display = 'none'
            })
            errorFields.forEach(field => {
                field.innerHTML = ''
            })
            document.getElementById('responseMessage').innerText = ''

            const title = document.getElementById('title').value
            const thumbnail = document.getElementById('thumbnail').files[0]
            const slug = document.getElementById('slug').value
            const content = tinymce.get('editor').getContent();
            const selectCategories = document.getElementById('categories');
            const selectedCategories = Array.from(selectCategories.selectedOptions).map(option => option.values);
            const selectTags = document.getElementById('tags');
            const selectedTags = Array.from(selectTags.selectedOptions).map(option => option.value);
            let isValid = true

            if (title.trim() === '') {
                isValid = false
                document.getElementById('titleError').style.display = 'block'
                document.getElementById('titleError').style.color = 'red'
                document.getElementById('titleError').innerText = 'Title is required'
            }

            if (slug.trim() === '') {
                invalid = false
                document.getElementById('slugError').style.display = 'block'
                document.getElementById('slugError').style.color = 'red'
                document.getElementById('slugError').innerText = 'Slug is required'
            }

            if (selectedCategories.length === 0) {
                isValid = false
                document.getElementById('categoryError').style.display = 'block'
                document.getElementById('categoryError').style.color = 'red'
                document.getElementById('categoryError').innerText = 'At least one category must be selected'
            }

            if (selectedTags.length === 0) {
                isValid = false
                document.getElementById('tagError').style.display = 'block'
                document.getElementById('tagError').style.color = 'red'
                document.getElementById('tagError').innerText = 'At least one tag must be selected'
            }

            // If no thumbnail is selected, it means the user wants to keep the old thumbnail
            if (!thumbnail && !document.getElementById('thumbnailPreview')) {
                isValid = false;
                document.getElementById('thumbnailError').style.display = 'block';
                document.getElementById('thumbnailError').style.color = 'red';
                document.getElementById('thumbnailError').innerText = 'Thumbnail is required';
            } else {
                if (thumbnail) {
                    const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                    const maxSize = 2048 * 1024;

                    if (!allowedExtensions.includes(thumbnail.type)) {
                        isValid = false;
                        document.getElementById('thumbnailError').style.display = 'block';
                        document.getElementById('thumbnailError').style.color = 'red';
                        document.getElementById('thumbnailError').innerText =
                            'Invalid file type. Only JPG, JPEG, PNG, and WebP are allowed.';
                    }

                    if (thumbnail.size > maxSize) {
                        isValid = false;
                        document.getElementById('thumbnailError').style.display = 'block';
                        document.getElementById('thumbnailError').style.color = 'red';
                        document.getElementById('thumbnailError').innerText = 'File size must be less than 2MB';
                    }
                }

                if (isValid) {
                    document.getElementById('thumbnailError').style.display = 'none';
                }
            }

            if (content === '') {
                isValid = false
                document.getElementById('contentError').style.display = 'block'
                document.getElementById('contentError').style.color = 'red'
                document.getElementById('contentError').innerText = 'Content is required'
            }

            if (!isValid) {
                return
            }

            const formData = new FormData(this)
            formData.append('content', content)
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]); // Log the content field
            }

            const id = {{ $blog->id }}
            const url = `{{ route('blog.update', ':id') }}`.replace(':id', id)
            fetch(url, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.status === 'error') {
                        const errors = data.message
                        for (const field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                const errorDiv = document.getElementById(field + 'Error')
                                if (errorDiv) {
                                    errorDiv.style.display = 'block'
                                    errorDiv.style.color = 'red'
                                    errorDiv.innerText = errors[field][0]
                                }
                            }
                        }
                    } else {
                        document.getElementById('responseMessage').innerText = 'Blog updated successfully.'
                        document.getElementById('responseMessage').style.color = 'green'

                        errorFields.forEach(field => {
                            field.style.display = 'none'
                            field.innerHTML = ''
                        })

                        setTimeout(() => {
                            document.getElementById('responseMessage').innerText = ''
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error)
                    document.getElementById('responseMessage').innerText = 'An error occurred.'
                    document.getElementById('responseMessage').style.color = 'red'

                    setTimeout(() => {
                        document.getElementById('responseMessage').innerText = ''
                    }, 3000)
                })
        })

        $(document).ready(function() {
            // Initialize Select2
            $('#tags').select2({
                placeholder: 'Select tags', // Placeholder text
                allowClear: true // Allow clearing the selection
            });
            $('#categories').select2({
                placeholder: 'Select categories', // Placeholder text
                allowClear: true // Allow clearing the selection
            });
        });
    </script>
@endsection
