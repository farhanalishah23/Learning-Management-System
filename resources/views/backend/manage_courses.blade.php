@extends('backend.layout.master')
@section('content')

    <div class="page-section">
        <h1 class="text-display-1 margin-none">Manage Courses</h1>
    </div>
    <div class="panel panel-default">
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Course</th>
                <th>Assigned At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($manageCourses as $key => $manageCourse)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $manageCourse->course->title }}</td>
                    <td>{{ $manageCourse->course->created_at->format(env('DATE_FORMAT')) ?? '' }}</td>
                    <td>
                        @if(isset($manageCourse->task) && $manageCourse->task != null)
                            <a type="button" class="btn btn-sm btn-success view_created_task_button" course_id="{{$manageCourse->course_id}}">View Created Task</a>
                        @else
                            <a type="button" class="btn btn-sm btn-primary task_button create_task_button" course_id="{{ $manageCourse->course_id }}">Create Task</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal" id="create_task_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                </div>
                <form class="form-group"  method="post" action="{{url('create_task')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="course_id" id="course_id">
                        <input type="hidden" name="student_id" id="student_id">
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Task *</label>
                            <textarea class="form-control"  name="task" id="task"   placeholder="Enter Here" required rows="5"></textarea>
                            @if($errors->has('task'))
                                <span class="text-danger" >{{$errors->first('task')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="view_created_task_modal" data-backdrop="static" tabindex="-1" aria-labelledby="view_created_task_modal" role="dialog" aria-hidden="true">
    </div>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click','.create_task_button',function(e){
            var course_id = $(this).attr('course_id');
            $('#course_id').val(course_id);
            $('#create_task_modal').show();
        });
        $(document).on('click', '.view_created_task_button', function (e) {
            var course_id = $(this).attr('course_id');
            $.ajax({
                url: "{{url('view_created_task_modal')}}",
                type: 'get',
                data: {
                    course_id: course_id,
                },
                success: function (result) {
                    $('#view_created_task_modal').html(result);
                    $('#view_created_task_modal').show();
                },
                error: function (e) {
                    console.log(e.status);
                }
            });
        });
    </script>

    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('task');
    </script>

@endpush
