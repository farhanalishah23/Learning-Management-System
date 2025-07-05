@extends('backend.layout.master')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
@endpush
@section('content')
    <?php $unique_number = uniqid();?>
    <div class="page-section">
        <h1 class="text-display-1">Create New Course</h1>
    </div>
    <div class="tabbable paper-shadow relative" data-z="0.5">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#"><i class="fa fa-fw fa-lock"></i> <span class="hidden-sm hidden-xs">Course</span></a></li>
        </ul>
        <div class="tab-content">
            <div id="course" class="tab-pane active">
                <form class="form-group" id="course-form" method="post" enctype="multipart/form-data" action="{{url('store_course')}}">
                    @csrf
                    <input type="hidden" name="unique_number" value="{{$unique_number}}">
                    <div class="mb-3 " style="margin-bottom: 10px" >
                        <label class="form-label" for="category_id">Category *</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @if($categories->isEmpty())
                                <option value="" selected disabled>No categories available</option>
                            @else
                                <option value="" selected disabled>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group form-control-material">
                        <input type="text" name="title" id="title" placeholder="Course Title" class="form-control used" value="{{ old('title')}}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="summernote">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <h3>Upload Files</h3>
                        <div id="myDropzone" class="dropzone"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="status">Status *</label>
                        <select class="form-control" name="status" id="status">
                            <option value="" selected disabled>Select Status</option>
                            <option value="active" >Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <a href="{{url('courses')}}" class="btn btn-blue-grey-500">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var myDropzone = new Dropzone("#myDropzone", {
                url: "{{ url('upload_post_attachment') }}",
                paramName: "file",
                maxFilesize: 40,
                maxFiles: 5,
                acceptedFiles: 'image/*,audio/*,video/*,.pdf',
                addRemoveLinks: true,
                dictRemoveFile: "Remove",
                init: function() {
                    this.on("complete", function(file) {
                    });
                    this.on("sending", function(file, xhr, formData) {
                        formData.append('unique_number', "{{$unique_number}}");
                    });
                }
            });

            var formData = new FormData();
            formData.append('unique_number', "{{$unique_number}}");

            @if(isset($courseAttachments))
            @foreach($courseAttachments as $imageUrl)
            var mockFile = { name: "{{ asset('website').'/'.$imageUrl->file }}", size: 12345 };
            myDropzone.emit("addedfile", mockFile);
            myDropzone.emit("thumbnail", mockFile, "{{ asset('website').'/'.$imageUrl->file }}");
            myDropzone.emit("complete", mockFile);
            @endforeach
            @endif
            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append('unique_number', "{{$unique_number}}");
            });
            myDropzone.on("removedfile", function(file) {
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#course-form").validate({
                rules: {
                    category_id: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    category_id: {
                        required: "Please select a category"
                    },
                    title: {
                        required: "Please enter a title"
                    },
                    description: {
                        required: "Please enter a description"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endpush
