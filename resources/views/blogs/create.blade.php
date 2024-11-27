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
                <div id="responseMessage"></div>
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
                        <form action="{{ route('blog.save') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" />
                                    <div class="invalid-input" id="titleError" style="display: none;"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" />
                                    <div class="invalid-input" id="slugError" style="display: none;"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <label for="category" class="form-label">Category</label>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if ($categories->isNotEmpty())
                                                        @foreach ($categories as $category)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="categories[]"
                                                                        id="category-{{ $category->id }}"
                                                                        value="{{ $category->id }}"
                                                                        class="form-check-input">
                                                                    <label for="category-{{ $category->id }}"
                                                                        class="form-check-label">{{ $category->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
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
                                            <div class="card-header">
                                                <label for="tags" class="form-label">Tags</label>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if ($tags->isNotEmpty())
                                                        @foreach ($tags as $tag)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="tags[]"
                                                                        id="tag-{{ $tag->id }}"
                                                                        value="{{ $tag->id }}"
                                                                        class="form-check-input">
                                                                    <label for="tag-{{ $tag->id }}"
                                                                        class="form-check-label">{{ $tag->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No tags available</p>
                                                    @endif
                                                </div>
                                                <div class="invalid-input" id="tagError" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                                    <div class="invalid-input" id="thumbnailError" style="display: none;"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Body</label>
                                    <textarea id="editor" name="content"></textarea>
                                    <div class="invalid-input" id="contentError" style="display: none;"></div>
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
        document.getElementById('blogForm').addEventListener('submit', function(event) {
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
            const categories = document.querySelectorAll('input[name="categories[]"]:checked')
            const tags = document.querySelectorAll('input[name="tags[]"]:checked')
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

            if (categories.length === 0) {
                isValid = false
                document.getElementById('categoryError').style.display = 'block'
                document.getElementById('categoryError').style.color = 'red'
                document.getElementById('categoryError').innerText = 'At least one category must be selected'
            }

            if (tags.length === 0) {
                isValid = false
                document.getElementById('tagError').style.display = 'block'
                document.getElementById('tagError').style.color = 'red'
                document.getElementById('tagError').innerText = 'At least one tag must be selected'
            }

            if (!thumbnail) {
                isValid = false
                document.getElementById('thumbnailError').style.display = 'block'
                document.getElementById('thumbnailError').style.color = 'red'
                document.getElementById('thumbnailError').innerText = 'Thumbnail is required'
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

            fetch("{{ route('blog.save') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
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
                        document.getElementById('responseMessage').innerText = 'Form submitted successfully.'
                        document.getElementById('responseMessage').style.color = 'green'

                        document.getElementById('blogForm').reset()
                        tinymce.get('editor').setContent('')

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
    </script>
@endsection
