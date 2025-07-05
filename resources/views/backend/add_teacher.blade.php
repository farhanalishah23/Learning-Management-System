@extends('backend.layout.master')
@push('css')
    <style>
    #email-error {
    padding: 1px 2px;
    font-size: 10px;
    margin-top: 3px;
    }
    </style>
@endpush
@section('content')
<div class="page-section third">
    <!-- Tabbable Widget -->
    <div class="tabbable paper-shadow relative" data-z="0.5">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#"><i class="fa fa-fw fa-lock"></i> <span class="hidden-sm hidden-xs">Manage Account</span></a></li>
        </ul>
        <div class="tab-content">
            <div id="account" class="tab-pane active">
                <form id="teacher-form" class="form-horizontal form-group teacher-form" enctype="multipart/form-data" method="post" action="{{ url('store_teacher') }}">
                    @csrf
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">Image</label>
                        <div class="col-md-6">
                            <div class="media v-middle">
                                <div class="media-left">
                                    <div class="icon-block width-100 bg-grey-100">
                                        <img id="image-preview" src="#" alt="Image Preview" style="max-width: 100%; display: none;">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <label for="file-upload" class="btn btn-white btn-sm paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>
                                        Add Image
                                        <i class="fa fa-upload"></i>
                                        <input id="file-upload" name="image" type="file" style="display: none;" onchange="previewImage(event)" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="form-control-material">
                                <div class="input-group">
                                    <input class="form-control" name="name" type="text" placeholder="Enter Title" value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">Email <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="form-control-material">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Your Email" required>
                                </div>
                                <div id="email-error" class="alert alert-danger" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label">Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="form-control-material">
                                <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="status" class="col-md-2 control-label">Status<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="form-control-material">
                                <select class="form-control " name="status" id="status">
                                    <option  value="" disabled selected>Select Status</option>
                                    <option  value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group margin-none">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>Add Teacher</button>
                            <button  href="{{url('teachers')}}" class="btn btn-white paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#teacher-form").validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true
                        },
                        status: {
                            required: true
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter a name"
                        },
                        email: {
                            required: "Please enter an email address",
                            email: "Please enter a valid email address"
                        },
                        password: {
                            required: "Please enter a password"
                        },
                        status: {
                            required: "Please select a status"
                        }
                    },
                    errorPlacement: function(error,element){
                        error.insertAfter(element)
                    }
                });

                $('#email').blur(function () {
                    var email = $(this).val();

                    $.ajax({
                        url: "{{ route('check_email') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: email
                        },
                        success: function (response) {
                            if (!response.available) {
                                $('#email-error').text('This email has already been taken.').show();
                            } else {
                                $('#email-error').text('').hide();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('image-preview');
                    output.src = reader.result;
                    output.style.display = 'block';
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
@endpush
