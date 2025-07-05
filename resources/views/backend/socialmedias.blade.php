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
        <h1 class="text-display-1">Social Media</h1>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" >
            Add Social Media
        </button>
    </div>
    <div class="panel panel-default">
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Color</th>
                <th>Icon</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($socialMedias as $key=>$socialMedia)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$socialMedia->color}}</td>
                    <td>{{$socialMedia->icon}}</td>
                    <td>{{$socialMedia->created_at->format(env('DATE_FORMAT')) ?? ''}}</td>
                    <td>{{$socialMedia->status}}</td>
                    <td>
                        <div  class="btn-group" role="group"  style="width: 100%">
                            <button  style="margin-right: 5px"  type="button" class="btn btn-sm btn-success edit_social_media_button" social_media_id="{{$socialMedia->id}}" social_media_icon="{{$socialMedia->icon}}" social_media_color="{{$socialMedia->color}}" social_media_url = "{{ $socialMedia->url }}" >
                                Edit
                            </button>
                            <form class="deleteForm" action="{{ url('') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $socialMedia->id }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Social Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" id="addSocialMediaForm" method="post" action="{{ url('add_social_media') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="icon">Select Button Color *</label>
                            <select class="form-control" name="color" id="color">
                                <option  selected disabled> Select any social media icon *</option>
                                <option value='btn btn-indigo-500 btn-circle'>Indigo</option>
                                <option value='btn btn-pink-500 btn-circle'>Pink</option>
                                <option value='btn btn-blue-500 btn-circle'>blue</option>
                                <option value='btn btn-danger btn-circle'> Danger</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="icon">Select Social Media Icon *</label>
                            <select class="form-control" name="class_name" id="class_name">
                                <option  selected disabled> Select any social media icon *</option>
                                <option value='fa fa-facebook'>&#xf09a; Facebook</option>
                                <option value='fa fa-twitter'>&#xf099; Twitter</option>
                                <option value='fa fa-youtube'>&#xf167; YouTube</option>
                                <option value='fa fa-twitch'>&#xf1e8; Twitch</option>
                                <option value='fa fa-linkedin'>&#xf08c; LinkedIn</option>
                                <option value='fa fa-quora'>&#xf2c4; Quora</option>
                                <option value='fa fa-medium'>&#xf23a; Medium</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="url">Url *</label>
                            <input type="text" name="url" id="url" class="form-control" placeholder="url">
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
                        <button type="submit" class="btn btn-primary">Add Social Media</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Social Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" id="editSocialMedia" method="post"  action="{{ url('')}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="icon">Select Button Color *</label>
                            <select class="form-control" name="edit_social_media_color" id="edit_social_media_color">
                                <option  selected disabled> Select any social media icon *</option>
                                <option value='btn btn-indigo-500 btn-circle'>Indigo</option>
                                <option value='btn btn-pink-500 btn-circle'>Pink</option>
                                <option value='btn btn-blue-500 btn-circle'>blue</option>
                                <option value='btn btn-danger btn-circle'> Danger</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="icon">Select Social Media Icon *</label>
                            <select class="form-control" name="edit_social_media_icon" id="edit_social_media_icon">
                                <option  selected disabled> Select any social media icon *</option>
                                <option value='fa fa-facebook'>&#xf09a; Facebook</option>
                                <option value='fa fa-twitter'>&#xf099; Twitter</option>
                                <option value='fa fa-youtube'>&#xf167; YouTube</option>
                                <option value='fa fa-twitch'>&#xf1e8; Twitch</option>
                                <option value='fa fa-linkedin'>&#xf08c; LinkedIn</option>
                                <option value='fa fa-quora'>&#xf2c4; Quora</option>
                                <option value='fa fa-medium'>&#xf23a; Medium</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="url">Url *</label>
                            <input type="text" name="edit_social_media_url" id="edit_social_media_url" class="form-control" placeholder="url">
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
                        <button type="submit" class="btn btn-primary">Add Social Media</button>
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
            $('#addSocialMediaForm').validate({
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
        $(document).on('click','.edit_social_media_button',function(e){
            e.preventDefault();
            var social_media_id     = $(this).attr('social_media_id');
            var social_media_icon   = $(this).attr('social_media_icon');
            var social_media_color   = $(this).attr('social_media_color');
            var social_media_url   = $(this).attr('social_media_url');
            var social_media_status  = $(this).attr('social_media_status');
            $('#edit_social_media_id').val(social_media_id);
            $('#edit_social_media_icon').val(social_media_icon);
            $('#edit_social_media_color').val(social_media_color);
            $('#edit_social_media_url').val(social_media_url);
            $('#edit_social_media_status').val(social_media_status);
            $('.editModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.editModal').hide();
        });
    </script>
@endpush
