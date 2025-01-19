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
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0">Create Blog</h5>
                            <a href="{{ route('blog.index') }}" class="btn btn-secondary ms-auto">Back</a>
                        </div>
                        <form action="{{ route('blog.save') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
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
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <label for="status" class="form-label">Post Status</label>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="draft" value="draft" checked>
                                                    <label class="form-check-label" for="draft">
                                                        Draft
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="publish" value="published">
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
                                                    <label for="categories" class="form-label">Select Categories</label>
                                                    @if ($categories->isNotEmpty())
                                                        <select name="categories[]" id="categories"
                                                            class="form-select select2" multiple="multiple">
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                            <option value="create-new-category">Add New Category</option>
                                                        </select>
                                                    @else
                                                        <div class="alert alert-info" role="alert">
                                                            No Category available
                                                        </div>
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
                                                    <label for="tags" class="form-label">Select Tags</label>
                                                    @if ($tags->isNotEmpty())
                                                        <select name="tags[]" id="tags" class="form-select select2"
                                                            multiple="multiple">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->id }}">{{ $tag->name }}
                                                                </option>
                                                            @endforeach
                                                            <option value="create-new-tag">Add New Tag</option>
                                                        </select>
                                                    @else
                                                        <div class="alert alert-info" role="alert">
                                                            No tags available
                                                        </div>
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

    {{-- Modal for tag --}}
    <div class="modal fade" id="createTagModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createTagModalLabel">Create New Tag</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tagName" class="form-label">Tag Name</label>
                            <input type="text" class="form-control" placeholder="Tag Name" aria-label="Tag Name"
                                id="tagName" name="tagName">
                            @error('tagName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tagSlug" class="form-label">Tag Slug</label>
                            <input type="text" class="form-control" placeholder="Tag Slug" aria-label="Tag Slug"
                                id="tagSlug" name="tagSlug">
                            @error('tagSlug')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-tag" class="btn btn-primary">Save Tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal for category --}}
    <div class="modal fade" id="createCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createCategoryModalLabel">Create New Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" placeholder="Category Name"
                                aria-label="Category Name" id="categoryName" name="categoryName">
                            @error('categoryName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="categorySlug" class="form-label">Category Slug</label>
                            <input type="text" class="form-control" placeholder="Category Slug"
                                aria-label="Category Slug" id="categorySlug" name="categorySlug">
                            @error('categorySlug')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-category" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
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

            if (!thumbnail) {
                isValid = false
                document.getElementById('thumbnailError').style.display = 'block'
                document.getElementById('thumbnailError').style.color = 'red'
                document.getElementById('thumbnailError').innerText = 'Thumbnail is required'
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

            // Show modal when "Create New Tag" option is selected
            $('#tags').on('select2:select', function(e) {
                var selectedValue = e.params.data.id; // Get selected value

                if (selectedValue === 'create-new-tag') {
                    // Show the modal for creating a new tag
                    $('#createTagModal').modal('show');
                    $('#tags').val(null).trigger('change'); // Clear selection from Select2 dropdown
                }
            });

            // Show modal when "Create New Category" option is selected
            $('#categories').on('select2:select', function(e) {
                var selectedValue = e.params.data.id; // Get selected value

                if (selectedValue === 'create-new-category') {
                    // Show the modal for creating a new category
                    $('#createCategoryModal').modal('show');
                    $('#categories').val(null).trigger('change'); // Clear selection from Select2 dropdown
                }
            });
        });

        // Tag slug
        document.getElementById('tagName').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .trim()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')

            document.getElementById('tagSlug').value = slug;
        })

        // Save new tag
        document.getElementById('save-tag').addEventListener('click', function() {
            var name = document.getElementById('tagName').value;
            var slug = document.getElementById('tagSlug').value;

            if (name && slug) {
                fetch('/api/tag', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: name,
                            slug: slug
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            $('#createTagModal').modal('hide');
                            document.getElementById('tagName').value = '';
                            document.getElementById('tagSlug').value = '';
                            var newOption = new Option(data.tag.name, data.tag.id, false,
                                true);
                            $('#tags').append(newOption).trigger('change');
                        } else {
                            alert('Error saving tag');
                        }
                    })
                    .catch(errors => {
                        console.log(errors)
                        console.error('Error:', errors);
                        alert('Something went wrong');
                    });
            } else {
                alert('Please fill out both fields');
            }
        });

        // Category slug
        document.getElementById('categoryName').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .trim()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')

            document.getElementById('categorySlug').value = slug;
        })

        // Save new category
        document.getElementById('save-category').addEventListener('click', function() {
            var name = document.getElementById('categoryName').value;
            var slug = document.getElementById('categorySlug').value;

            if (name && slug) {
                fetch('/api/category', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: name,
                            slug: slug
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(data)
                            $('#createCategoryModal').modal('hide');
                            document.getElementById('categoryName').value = '';
                            document.getElementById('categorySlug').value = '';
                            var newOption = new Option(data.category.name, data.category.id, false,
                                true);
                            $('#categories').append(newOption).trigger('change');
                        } else {
                            alert('Error saving category');
                        }
                    })
                    .catch(errors => {
                        console.log(errors)
                        console.error('Error:', errors);
                        alert('Something went wrong');
                    });
            } else {
                alert('Please fill out both fields');
            }
        });
    </script>
@endsection
