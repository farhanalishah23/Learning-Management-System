@extends('backend.layout.master')
@push('css')
    <style>
        .error-bold {
            font-weight: bold;
        }
    </style>
    <style>
        .fa-star {
            cursor: pointer;
            color: #ccc; /* Default star color */
        }
        .fa-star.checked {
            color: #f39c12; /* Color for selected stars */
        }
    </style>
@endpush
@section('content')
    <div class="page-section">
        <h1 class="text-display-1">Testimonials</h1>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" >
            Add Testimonial
        </button>
    </div>
    <div class="panel panel-default">
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($testimonials as $key=>$test)
                <tr>
                    <td>{{++$key}}</td>
                    <td>
                        @if($test->image)
                            <img style="height: 50px" src="{{ asset('website') }}/{{$test->image ??''}}"  alt="no image">
                        @else
                            <img style="height: 50px" id="image-preview" src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg" alt="Default Profile Image" class="img-circle width-80">
                        @endif
                    </td>
                    <td>{{$test->name ??''}}</td>
                    <td>{{$test->created_at->format(env('DATE_FORMAT')) ?? ''}}</td>
                    <td>{{$test->status ??''}}</td>
                    <td>
                        <div  class="btn-group" role="group"  style="width: 100%">
                            <button style="margin-right: 5px"  class="btn btn-sm btn-info view_testimonial_button" testimonial_id="{{$test->id}}" testimonial_description = "{{ $test->description }}" testimonial_email = "{{ $test->email }}">View</button>
                            <button  style="margin-right: 5px"  class="btn btn-sm btn-success edit_testimonial_button" testimonial_id="{{$test->id}}" testimonial_name = "{{ $test->name }}" testimonial_email = "{{ $test->email }}" testimonial_description = "{{ $test->description }}" testimonial_image="{{ asset('website/' . $test->image) }}" testimonial_status = "{{ $test->status }}"  onchange="previewImage(event)">
                                Edit
                            </button>
                            <form class="deleteForm" action="{{ url('') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $test->id ??''}}">
                                <button class="btn btn-sm btn-danger deleteButton"   type="button">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" id="addtestmonialForm" method="post" enctype="multipart/form-data" action="{{ url('add_testimonial') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" id="name" type="text"  placeholder="Enter Title">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="email" id="email" type="email"  placeholder="Enter Email">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter description" ></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="image" id="image">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="ratings">Ratings <span class="text-danger">*</span></label>
                            <div id="rating">
                                <span class="fa fa-fw fa-star" data-value="1"></span>
                                <span class="fa fa-fw fa-star" data-value="2"></span>
                                <span class="fa fa-fw fa-star" data-value="3"></span>
                                <span class="fa fa-fw fa-star" data-value="4"></span>
                                <span class="fa fa-fw fa-star" data-value="5"></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add testmonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="get">
                    <input type="hidden" name="view_testimonial_id" id="view_testimonial_id">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="view_testimonial_email" id="view_testimonial_email" type="email" value=""  placeholder="Enter Email" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name=view_testimonial_description" id="view_testimonial_description"  value="" placeholder="Enter description" readonly></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" id="edittestmonialForm" method="post" enctype="multipart/form-data" action="{{ url('update_testimonial'), 0 }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="edit_testimonial_id" id="edit_testimonial_id">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="edit_testimonial_name" id="edit_testimonial_name" type="text"  placeholder="Enter Title">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="edit_testimonial_email" id="edit_testimonial_email" type="email"  placeholder="Enter Email">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="edit_testimonial_description" id="edit_testimonial_description" placeholder="Enter description" ></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="image">Image</label>
                            <input class="form-control" type="file" name="image" id="testimonial_image">
                            <img id="testimonial_img" class="testimonial_img" src="" alt="Testimonial Image" style="height: 70px; width: 70px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="edit_testimonial_status" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#addtestmonialForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    image: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "<span class='error-bold'>Please enter a name.</span>"
                    },
                    email: {
                        required: "<span class='error-bold'>Please enter a email.</span>"
                    },
                    description: {
                        required: "<span class='error-bold'>Please enter a description.</span>"
                    },
                    image: {
                        required: "<span class='error-bold'>Please select an image.</span>"
                    },
                    status: {
                        required: "<span class='error-bold'>Please select a status.</span>"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    error.addClass('text-danger');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    <script>
        $(document).on('click','.view_testimonial_button',function(e){
            e.preventDefault();
            var testimonial_id     = $(this).attr('testimonial_id');
            var testimonial_description   = $(this).attr('testimonial_description');
            var testimonial_email   = $(this).attr('testimonial_email');
            $('#view_testimonial_id').val(testimonial_id);
            $("textarea").val(testimonial_description);
            $('#view_testimonial_email').val(testimonial_email);
            $('.viewModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.viewModal').hide();
        });
        $(document).on('click','.edit_testimonial_button',function(e){
            e.preventDefault();
            var testimonial_id     = $(this).attr('testimonial_id');
            var testimonial_name   = $(this).attr('testimonial_name');
            var testimonial_email   = $(this).attr('testimonial_email');
            var testimonial_description   = $(this).attr('testimonial_description');
            var testimonial_status  = $(this).attr('testimonial_status');
            var testimonial_image   = $(this).attr('testimonial_image');
            $('#edit_testimonial_id').val(testimonial_id);
            $('#edit_testimonial_name').val(testimonial_name);
            $('#edit_testimonial_email').val(testimonial_email);
            $('#edit_testimonial_description').text(testimonial_description);
            $('#edit_testimonial_status').val(testimonial_status);
            $('#testimonial_img').attr('src', testimonial_image);
            $('.editModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.editModal').hide();
        });
    </script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('testimonial_img');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.fa-star').on('mouseover', function() {
                var value = $(this).data('value');
                updateStars(value, false); // Pass false for hover
            }).on('mouseout', function() {
                var currentValue = $('#rating_value').val();
                updateStars(currentValue, true); // Pass true to reset to selected value
            }).on('click', function() {
                var value = $(this).data('value');
                $('#rating_value').val(value); // Set hidden input value
                updateStars(value, true); // Update stars to selected value
            });

            function updateStars(value, isFinal) {
                $('.fa-star').each(function() {
                    var starValue = $(this).data('value');
                    if (starValue <= value) {
                        $(this).addClass('selected');
                    } else {
                        $(this).removeClass('selected');
                    }
                });
            }
        });
    </script>
@endpush
