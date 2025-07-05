@extends('backend.layout.master')
@push('css')
    <style>
        .error-bold {
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <div class="page-section">
        <h1 class="text-display-1">Features</h1>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" >
            Add Feature
        </button>
    </div>
    <div class="panel panel-default">
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Color</th>
                <th>Icon</th>
                <th>Title</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($features as $key=>$feature)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$feature->color}}</td>
                    <td>{{$feature->icon}}</td>
                    <td>{{$feature->title}}</td>
                    <td>{{$feature->created_at->format(env('DATE_FORMAT')) ?? ''}}</td>
                    <td>{{$feature->status}}</td>
                    <td>
                        <div  class="btn-group" role="group"  style="width: 100%">
                            <button style="margin-right: 5px"  class="btn btn-sm btn-info view_feature_button" feature_id="{{$feature->id}}" feature_description = "{{ $feature->description }}" >View</button>
                            <button  style="margin-right: 5px"  type="button" class="btn btn-sm btn-success edit_feature_button" feature_id="{{$feature->id}}" feature_icon="{{$feature->icon}}" feature_color="{{$feature->color}}" feature_title = "{{ $feature->title }}" feature_description = "{{ $feature->description }}" feature_image="{{$feature->image}}" feature_status = "{{ $feature->status }}" >
                                Edit
                            </button>
                            <form class="deleteForm" action="{{ url('') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $feature->id }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" id="addFeatureForm" method="post"  action="{{ url('add_feature') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="title">Title *</label>
                            <input class="form-control" name="title" id="title" type="text"  placeholder="Enter Title">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description *</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter description" ></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="color">Select Color *</label>
                            <select class="form-control" name="color" id="color">
                                <option  selected disabled> Select any color *</option>
                                <option value='bg-purple-300'>bg-purple</option>
                                <option value='bg-orange-400'>bg-orange</option>
                                <option value='bg-cyan-400'>bg-cyan</option>
                                <option value='bg-green-400'>bg-green</option>
                                <option value='bg-pink-400'>bg-pink</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                                <label class="form-label" for="icon">Select Icon *</label>
                                <select class="form-control" name="icon" id="icon">
                                    <option  selected disabled> Select any icon *</option>
                                    <option value='fa fa-facebook'>&#xf09a; Facebook</option>
                                    <option value='fa fa-film'>&#xf16d; Film</option>
                                    <option value='fa fa-twitter'>&#xf099; Twitter</option>
                                    <option value='fa fa-youtube'>&#xf167; YouTube</option>
                                    <option value='fa fa-twitch'>&#xf1e8; Twitch</option>
                                    <option value='fa fa-linkedin'>&#xf08c; LinkedIn</option>
                                    <option value='fa fa-quora'>&#xf2c4; Quora</option>
                                    <option value='fa fa-medium'>&#xf23a; Medium</option>
                                </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Status *</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add feature</button>
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
                    <h5 class="modal-title" id="viewModalLabel">View Feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="get">
                    <input type="hidden" name="view_feature_id" id="view_feature_id">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description *</label>
                            <textarea class="form-control" name="view_feature_description" id="view_feature_description" placeholder="Enter description" readonly></textarea>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" id="editFeatureForm" method="post"  action="{{ url('update_feature'), 0 }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="edit_feature_id" id="edit_feature_id">
                        <div class="form-group mb-3">
                            <label class="form-label" for="title">Title *</label>
                            <input class="form-control" name="title" id="edit_feature_title" type="text"  placeholder="Enter Title">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description *</label>
                            <textarea class="form-control" name="description" id="edit_feature_description" placeholder="Enter description" ></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="icon">Select Color *</label>
                            <select class="form-control" name="edit_feature_color" id="edit_feature_color">
                                <option  selected disabled> Select any color *</option>
                                <option value='bg-purple-300'>bg-purple</option>
                                <option value='bg-orange-400'>bg-orange</option>
                                <option value='bg-cyan-400'>bg-cyan</option>
                                <option value='bg-green-400'>bg-green</option>
                                <option value='bg-pink-400'>bg-pink</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="edit_feature_icon">Select Icon *</label>
                            <select class="form-control" name="edit_feature_icon" id="edit_feature_icon">
                                <option value='fa fa-facebook'>&#xf09a; Facebook</option>
                                <option value='fa fa-film'>&#xf16d; Film</option>
                                <option value='fa fa-twitter'>&#xf099; Twitter</option>
                                <option value='fa fa-youtube'>&#xf167; YouTube</option>
                                <option value='fa fa-twitch'>&#xf1e8; Twitch</option>
                                <option value='fa fa-linkedin'>&#xf08c; LinkedIn</option>
                                <option value='fa fa-quora'>&#xf2c4; Quora</option>
                                <option value='fa fa-medium'>&#xf23a; Medium</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Status *</label>
                            <select class="form-control" name="status" id="edit_feature_status" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update feature</button>
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
            $('#addFeatureForm').validate({
                rules: {
                    title: {
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
                    title: {
                        required: "<span class='error-bold'>Please enter a title</span>"
                    },
                    description: {
                        required: "<span class='error-bold'>Please enter a description</span>"
                    },
                    image: {
                        required: "<span class='error-bold'>Please select an image</span>"
                    },
                    status: {
                        required: "<span class='error-bold'>Please select a status</span>"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
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
        $(document).on('click','.view_feature_button',function(e){
            e.preventDefault();
            var feature_id     = $(this).attr('feature_id');
            var feature_description   = $(this).attr('feature_description');
            $('#view_feature_id').val(feature_id);
            $('#view_feature_description').text(feature_description);
            $('.viewModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.viewModal').hide();
        });
        $(document).on('click','.edit_feature_button',function(e){
            e.preventDefault();
            var feature_id     = $(this).attr('feature_id');
            var feature_title   = $(this).attr('feature_title');
            var feature_description   = $(this).attr('feature_description');
            var feature_icon   = $(this).attr('feature_icon');
            var feature_color   = $(this).attr('feature_color');
            var feature_status  = $(this).attr('feature_status');
            var feature_image   = $(this).attr('feature_image');
            $('#edit_feature_id').val(feature_id);
            $('#edit_feature_title').val(feature_title);
            $('#edit_feature_description').text(feature_description);
            $('#edit_feature_icon').val(feature_icon);
            $('#edit_feature_color').val(feature_color);
            $('#edit_feature_status').val(feature_status);
            $('#edit_feature_image').val(feature_image);
            $('.editModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.editModal').hide();
        });
    </script>
@endpush
