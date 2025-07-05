@extends('backend.layout.master')
@push('css')
    <style>
        .email-error {
            padding: 3px 6px;
            font-size: 12px;
            margin-top: 3px;
        }
    </style>
@endpush
@section('content')
    <div class="page-section third">
        <div class="tabbable paper-shadow relative" data-z="0.5">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#"><i class="fa fa-fw fa-lock"></i> <span class="hidden-sm hidden-xs">Manage Account</span></a></li>
            </ul>
            <div class="tab-content">
                <div id="account" class="tab-pane active">
                    <form id="teacher-form" class="form-horizontal form-group teacher-form" enctype="multipart/form-data" method="post" action="{{ url('update_teacher', $teachers->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Image</label>
                            <div class="col-md-6">
                                <div class="media v-middle">
                                    <div class="media-left">
                                        <div class="icon-block width-100 bg-grey-100">
                                            @if($teachers->image)
                                                <img id="image-preview" src="{{ asset('website') }}/{{$teachers->image}}"  alt="no image" class="img-circle width-80" >
                                            @else
                                                <img id="image-preview" src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg" alt="Default Profile Image" class="img-circle width-80">
                                            @endif
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
                                        <input class="form-control" name="name" type="text" placeholder="Enter Title" value="{{ $teachers->name ,old('name') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-2 control-label">Email <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="form-control-material">
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $teachers->email,old('email') }}" placeholder="Enter Your Email" required>
                                    </div>
                                    @error('email')
                                    <div class="alert alert-warning email-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-2 control-label">Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="form-control-material">
                                    <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="col-md-2 control-label">Status<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="form-control-material">
                                    <select class="form-control " name="status" id="status">
                                        <option  value="active" @if(isset($teachers) && $teachers->status == 'active') selected @endif>Active</option>
                                        <option value="inactive" @if(isset($teachers) && $teachers->status == 'inactive') selected @endif>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="email-error" class="col-md-offset-2 col-md-6 alert alert-danger" style="display: none;"></div>
                        <div class="form-group margin-none">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>Update Teacher</button>
                                <button  href="{{url('teachers')}}" class="btn btn-white paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>Cancel</button>
                            </div>
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
                    $("#teacher-form").validate({
                        rules: {
                            name: {
                                required: true
                            },
                            email: {
                                required: true,
                                email: true
                            },
                        },
                        messages: {
                            name: {
                                required: "Please enter a name"
                            },
                            email: {
                                required: "Please enter an email address",
                                email: "Please enter a valid email address"
                            },
                        },
                        errorPlacement: function (error, element) {
                            error.insertAfter(element.parent('.form-group'));
                            error.addClass('.error');
                        }
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
