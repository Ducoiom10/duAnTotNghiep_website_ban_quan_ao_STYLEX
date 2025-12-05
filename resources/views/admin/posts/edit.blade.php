@extends('admin.layouts.app')
@section('title')
    Sửa bài viết
@endsection
@push('page-css')
    <link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .form-card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .form-card:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        }

        .form-card .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }

        .form-card .card-body {
            padding: 20px;
        }

        .card-title {
            font-weight: 600;
            font-size: 16px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #495057;
        }

        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
        }

        .btn-publish {
            padding: 10px 24px;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.3s;
        }

        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            height: 42px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 6px 8px;
        }

        .thumbnail-preview-container {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 6px;
            text-align: center;
            padding: 20px;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .thumbnail-preview-container:hover {
            background-color: #f1f3f5;
        }
         .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd !important;
            /* xanh dương Bootstrap */
            border: none !important;
            color: #fff !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 3px 8px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $subTitle ?? '' }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dasboard</a></li>
                            <li class="breadcrumb-item active">{{ $title ?? '' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Thông tin bài viết: <span class="text-danger">{{ $post->title }}</span>
                            </h4>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_hot" value="1"
                                    id="isHotSwitch" @checked($post->is_hot)>
                                <label class="form-check-label" for="isHotSwitch">
                                    Bài viết hot 🔥
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Tiêu đề</label>
                                <input type="title" class="form-control mb-2" placeholder="Nhập tiêu đề..."
                                    value="{{ $post->title }}" name="title">
                                @error('title')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Hình ảnh mới</label>
                                <input type="file" name="thumbnail" id="imageInput" accept="image/*"
                                    class="form-control">
                                <img class="mt-2" id="imagePreview"
                                    style="display: none; max-width: 100%; max-height: 300px;">
                                @error('thumbnail')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <label class="form-label">Mô tả bài viết</label>
                                </div>
                                <textarea id="description" name="description" class="form-control" id="" cols="30" rows="10">{{ $post->description }}</textarea>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="formGroupExampleInput">Nội dung bài viết</label>
                                </div>
                                <textarea class="mb-3" id="laraberg" name="content" hidden>{{ $post->content }}</textarea>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Hình đại diện
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-2">
                                @if($post->thumbnail)
                                    <img class="img-thumbnail" src="{{ Storage::url($post->thumbnail) }}" alt="Hình đại diện" style="max-width: 100%; height: auto;">
                                @else
                                    <div class="thumbnail-preview-container">
                                        <p class="text-muted mb-0">Chưa có hình đại diện</p>
                                        <small class="text-muted">Chọn ảnh mới ở trên để thay đổi</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Tuỳ chỉnh
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" name="status" id="post-status">
                                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Lưu nháp
                                    </option>
                                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Công
                                        khai</option>
                                    <option value="private" {{ $post->status == 'private' ? 'selected' : '' }}>Riêng tư
                                    </option>

                                    @if (strtotime($post->published_at) > time())
                                        <option value="scheduled" {{ $post->status == 'scheduled' ? 'selected' : '' }}>Hẹn
                                            giờ xuất bản</option>
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3" id="published-date-container"
                                style="{{ in_array($post->status, ['scheduled']) ? '' : 'display: none;' }}">
                                <label class="form-label">Ngày xuất bản</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                    <input type="datetime-local" name="published_at" class="form-control"
                                        value="{{ $post->published_at ? date('Y-m-d\TH:i', strtotime($post->published_at)) : now()->format('Y-m-d\TH:i') }}">
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-publish">
                                    <i class="ri-send-plane-fill me-1"></i> Cập nhật bài viết
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Danh mục
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-2">
                                <select class="select2-categories form-control" name="category_id"
                                    data-placeholder="Chọn danh mục">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $post->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Tags
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-2">
                                <select class="select2-tags form-control" name="tags[]" data-placeholder="Chọn tags"
                                    multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->name }}"
                                            {{ in_array($tag->id, $tagIds ?: []) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-warning">Quay lại danh sách</a>
                        <button type="submit" class="btn btn-primary ">Xuất bản</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
        <script>
        @once
        let myEditor;
        ClassicEditor.create(document.querySelector('#description'))
            .then(editor => {
                myEditor = editor;
            });

        document.querySelector('#postForm').addEventListener('submit', function() {
            document.querySelector('#description').value = myEditor.getData();
        });
        @endonce
    </script>
    <script>
        $('#post-status').on('change', function() {
            if ($(this).val() === 'scheduled') {
                $('#published-date-container').slideDown(200);
                if (!$('input[name="published_at"]').val()) {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    $('input[name="published_at"]').val(`${year}-${month}-${day}T${hours}:${minutes}`);
                }
            } else {
                $('#published-date-container').slideUp(200);
            }
        });

        $(document).ready(function() {
            if ($('#post-status').val() === 'scheduled') {
                $('#published-date-container').show();
            }

            let editorInstance;
            let selectedAiType = '';
            let currentEditingSection = 'description';
            let currentAjaxRequest = null;

            Laraberg.init('laraberg', {
                height: '600px',
                mediaUpload: handleMediaUpload
            });

            function handleMediaUpload(file) {
                return new Promise((resolve, reject) => {
                    if (file && file instanceof File) {
                        resolve({
                            id: new Date().getTime(),
                            url: URL.createObjectURL(file)
                        });
                    } else {
                        reject(new Error('Invalid file object'));
                    }
                });
            }

            $('#imageInput').on('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        $('#imagePreview').attr('src', reader.result).show();
                        $('#uploadPlaceholder').hide();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide();
                    $('#uploadPlaceholder').show();
                }
            });

            $('#postForm').on('submit', function() {
                var content = Laraberg.getContent();
                $('textarea[name="content"]').val(content);
            });

            $('.select2-categories').select2({
                placeholder: 'Chọn danh mục',
                allowClear: true,
                width: '100%',
                dropdownParent: $('.select2-categories').parent()
            });

            $('.select2-tags').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Chọn hoặc tạo thẻ mới',
                width: '100%',
                dropdownParent: $('.select2-tags').parent()
            });

            ClassicEditor.create($('#ckeditor-classic')[0], {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                    ],
                })
                .then(editor => {
                    editorInstance = editor;
                    editor.ui.view.editable.element.style.height = "200px";
                })
                .catch(console.error);
        });
    </script>
@endpush
