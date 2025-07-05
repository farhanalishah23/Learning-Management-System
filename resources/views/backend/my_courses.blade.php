@extends('backend.layout.master')
@section('content')

    <div class="page-section">
        <h1 class="text-display-1 margin-none">My Courses</h1>
    </div>
    <div class="panel panel-default">
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Teacher Name</th>
                <th>Course</th>
                <th>Assigned At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($studentCourses as $studentCourse)
                @if(isset($studentCourse->teacher) && $studentCourse->teacher != null)
                @if(isset($studentCourse->course) && $studentCourse->course != null)
                    <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>
                            {{ $studentCourse->teacher->teacher->name ?? ''}}
                        </td>
                        <td>{{ $studentCourse->course->title ?? ''}}</td>
                        <td>{{ $studentCourse->student->email ?? ''}}</td>
                        <td>
                            @php $taskCreated = false; @endphp
                            @foreach($studentScores as $studentScore)
                                @if($studentScore->course_id == $studentCourse->course_id && $studentScore->student_id == $studentCourse->student_id )
                                    @php $taskCreated = true; @endphp
                                    <a type="button" class="btn btn-sm btn-success view_score_button" course_id="{{ $studentCourse->course_id }}" student_id="{{ $studentCourse->student_id }}">View Score</a>
                                    @break
                                @endif
                            @endforeach
                            @unless($taskCreated)
                                <button class="view_task_button btn btn-sm btn-primary" course_id="{{ $studentCourse->course_id }}" student_id="{{ $studentCourse->student_id }}">View Task</button>
                            @endunless
                        </td>
                    </tr>
                @endif
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal" id="view_score_modal" data-backdrop="static" tabindex="-1" aria-labelledby="view_score_modal" role="dialog" aria-hidden="true">
    </div>
    <div class="modal" id="view_course_modal" data-backdrop="static" tabindex="-1" aria-labelledby="view_course_modal" role="dialog" aria-hidden="true">
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.view_task_button', function (e) {
            var course_id = $(this).attr('course_id');
            var student_id = $(this).attr('student_id');
            $.ajax({
                url: "{{url('view_course_modal')}}",
                type: 'get',
                data: {
                    course_id: course_id,
                    student_id: student_id,
                },
                success: function (result) {
                    $('#view_course_modal').html(result);
                    $('#view_course_modal').show();
                },
                error: function (e) {
                    console.log(e.status);
                }
            });
        });
        $(document).on('click', '.view_score_button', function (e) {
            var course_id = $(this).attr('course_id');
            var student_id = $(this).attr('student_id');
            $.ajax({
                url: "{{url('view_score_modal')}}",
                type: 'get',
                data: {
                    course_id: course_id,
                    student_id: student_id,
                },
                success: function (result) {
                    $('#view_score_modal').html(result);
                    $('#view_score_modal').show();
                },
                error: function (e) {
                    console.log(e.status);
                }
            });
        });
    </script>
@endpush
