@extends('backend.layout.master')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
@endpush
@section('content')
    <?php $unique_number = uniqid();?>
    <div class="page-section">
        <h1 class="text-display-1">Edit Course</h1>
    </div>
    <div class="tabbable paper-shadow relative" data-z="0.5">

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#"><i class="fa fa-fw fa-lock"></i> <span class="hidden-sm hidden-xs">Course</span></a></li>
        </ul>
        <!-- // END Tabs -->

        <!-- Panes -->
        <div class="tab-content">

            <div id="course" class="tab-pane active">
                <form  class="form-group" method="post" enctype="multipart/form-data" action="{{url('update_course' , $course->id)}}"  >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="unique_number" value="{{$unique_number}}">
                    <div class="mb-3" style="margin-bottom: 10px">
                        <label class="form-label" for="status">Category *</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @if($categories->isEmpty())
                                <option value="" selected disabled>No categories available</option>
                            @else
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group form-control-material">
                        <input type="text" name="title" id="title" placeholder="Course Title" class="form-control used" value="{{$course->title}}"  />
                        <label for="title">Title *</label>
                    </div>
                    @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="summernote">{{$course->description}} </textarea>
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <h3>Upload Files</h3>
                        <div id="myDropzone" class="dropzone"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="status">Status *</label>
                        <select class="form-control " name="status" id="status">
                            <option  value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-right">
                        <a href="{{url('courses')}}" class="btn btn-blue-grey-500" >Cancel</a>
                        <a type="submit" class="btn btn-primary">Update Course</a>
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
                var fetchFiles = function() {
                    $.ajax({
                        url: "{{ route('fetch_files') }}",
                        method: 'GET',
                        success: function(response) {
                            response.forEach(function(file) {
                                var mockFile = { name: file.name, size: file.size };
                                var url = file.path;
                                myDropzone.emit('addedfile', mockFile);
                                myDropzone.emit('thumbnail', mockFile, url);
                                myDropzone.emit('complete', mockFile);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                };

                // Call the fetchFiles function when Dropzone initializes
                fetchFiles();

                // Event listener for when a file is removed from Dropzone
                this.on("removedfile", function(file) {
                    // Handle file removal if needed
                });
            }
        });
    });
</script>









@endpush

