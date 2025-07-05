@extends('backend.layout.master')
@section('content')

    <div class="page-section">
        <h1 class="text-display-1 margin-none">Assigned Students</h1>
    </div>
    <div class="panel panel-default">
        <!-- Data table -->
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Course</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teacherCourses as $teacherCourse)
                @foreach($teacherCourse->teacherStudents as $key => $studentCourse)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $studentCourse->student->name }}</td>
                        <td>{{ $studentCourse->course->title }}</td>
                        <td>{{ $studentCourse->student->email }}</td>
                        <td>
                            @php $taskAnswerFound = false; @endphp
                                @foreach($taskAnswers as $taskAnswer)
                                    @if(isset($teacherCourse->task) && $teacherCourse->task != null && $studentCourse->student->id == $taskAnswer->student_id && isset($teacherCourse->taskAnswer) && $teacherCourse->taskAnswer != null && $teacherCourse->taskAnswer->course_id == $teacherCourse->task->course_id )
                                        @php $taskAnswerFound = true; @endphp
                                        <button type="button" class="btn btn-sm btn-success btn-primary view_task_button" course_id="{{ $studentCourse->course_id }}" student_id="{{ $taskAnswer->student_id }}">View Answer</button>
                                        @break
                                    @endif
                                @endforeach
                            @unless($taskAnswerFound)
                                <button style="margin-right: 5px" type="button" class="btn btn-sm btn-info view_teacher_task_modal_button" course_id="{{ $studentCourse->course_id }}" >
                                    View Task
                                </button>
                            @endunless
                        </td>
                    </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Teacher Task Modal -->
    <div class="modal" id="view_teacher_task_modal" data-backdrop="static" tabindex="-1" aria-labelledby="view_teacher_task_modal" role="dialog" aria-hidden="true">
    </div>

    <!-- View  Task Modal -->
    <div class="modal" id="view_task_modal" data-backdrop="static" tabindex="-1" aria-labelledby="view_task_modal" role="dialog" aria-hidden="true">
    </div>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.view_task_button', function (e) {
            var student_id = $(this).attr('student_id');
            var course_id = $(this).attr('course_id');
            $.ajax({
                url: "{{url('view_task_modal')}}",
                type: 'get',
                data: {
                    student_id : student_id,
                    course_id: course_id,
                },
                success: function (result) {
                    $('#view_task_modal').html(result);
                    $('#view_task_modal').show();
                },
                error: function (e) {
                    console.log(e.status);
                }
            });
        });
        $(document).on('click', '.view_teacher_task_modal_button', function (e) {
            var course_id = $(this).attr('course_id');
            $.ajax({
                url: "{{url('view_teacher_task_modal')}}",
                type: 'get',
                data: {
                    course_id: course_id,
                },
                success: function (result) {
                    $('#view_teacher_task_modal').html(result);
                    $('#view_teacher_task_modal').show();
                },
                error: function (e) {
                    console.log(e.status);
                }
            });
        });
    </script>
@endpush
