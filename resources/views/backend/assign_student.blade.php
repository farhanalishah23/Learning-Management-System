@extends('backend.layout.master')
@section('content')
    <div class="page-section">
        <h1 class="text-display-1">Assign Student To Course</h1>
    </div>
    <div class="panel panel-default">
        <div class="row">
            <div class="col-sm-11"></div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" >
                    Add New
                </button>
            </div>
        </div>
        <!-- Data table -->
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Student</th>
                <th>Course</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($studentCourses as $key=>$studentCourse)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{ optional($studentCourse->student)->name}}</td>
                    <td>{{$studentCourse->course->title?? ''}}</td>
                    <td>{{$studentCourse->created_at->format(env('DATE_FORMAT')) ?? ''}}</td>
                    <td>
                        @if($studentCourse->status=='active')
                            <a href="{{url('update_student_course',[$studentCourse->id,'inactive'])}}" class="badge badge-primary ">Active</a>
                        @else
                            <a href="{{url('update_student_course',[$studentCourse->id,'active'])}}" class="badge badge-danger">Inactive</a>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-danger" type="button">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Assign Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group"  method="post" action="{{ url('assign_student_course') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="student">Select Student *</label>
                            <select class="form-control" name="student_id" id="student_id">
                                @if($students->isEmpty())
                                    <option value="" selected disabled>No teachers available</option>
                                @else
                                    <option value="" selected disabled>Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Select Course *</label>
                            <select class="form-control" name="course_id" id="course_id">
                                @if($courses->isEmpty())
                                    <option value="" selected disabled>No courses available</option>
                                @else
                                    <option value="" selected disabled>Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Status *</label>
                            <select class="form-control " name="status" id="status">
                                <option  value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click','.edit_assign_teacher_button',function(e){
            e.preventDefault();
            var course_id     = $(this).attr('course_id');
            var course_name   = $(this).attr('course_name');
            var teacher_id     = $(this).attr('teacher_id');
            var teacher_name   = $(this).attr('teacher_name');
            $('#edit_course_id').val(course_id);
            $('#edit_course_name').val(course_name);
            $('#edit_teacher_id').val(teacher_id);
            $('#edit_teacher_name').val(teacher_name);
            $('.editModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.editModal').hide();
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#exampleModal form").validate({
                rules: {
                    course_id: {
                        required: true
                    },
                    student_id: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    course_id: {
                        required: "Please select a course"
                    },
                    student_id: {
                        required: "Please select a student"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element); // Display error message below the input field
                }
            });
        });
    </script>
@endpush


