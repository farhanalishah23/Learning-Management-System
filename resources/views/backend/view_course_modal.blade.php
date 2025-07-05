<div class="modal-dialog dialog-model" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">My Task</h5>
        </div>
        <form class="form-group" method="post" action="{{ url('store_answer') }}">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="course_id" value="{{ $studentTasks->course_id ?? '' }}" id="course_id">
                <input type="hidden" name="student_id" value="{{ $studentCourses->first()->student_id ?? '' }}" id="student_id">
                <div class="form-group mb-3">
                    <label class="form-label" for="task">Task</label>
                    <input class="form-control" name="task" value="{{ $studentTasks->task ?? '' }}" id="task" readonly>
                </div>
                @if(isset($courseTasks) && $courseTasks!=null)
                    <fieldset class="mb-3">
                        <legend class="form-label">Answer *</legend>
                        <textarea class="form-control" name="answer" id="answer" readonly>{{ $courseTasks->answer }}</textarea>
                    </fieldset>
                @elseif(isset($studentTasks) && $studentTasks !=null)
                    <div class="form-group mb-3">
                        <label class="form-label" for="task">Answer *</label>
                        <textarea class="form-control" name="answer" id="answer"></textarea>
                    </div>
                @else
                    <div class="form-group mb-3">
                        <label class="form-label" for="task">Answer *</label>
                        <textarea class="form-control" name="answer" id="answer" readonly></textarea>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if(isset($courseTasks) && $courseTasks!=null)
                @elseif(isset($studentTasks) && $studentTasks !=null)
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Give Answer</button>
                @else
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                @endif
            </div>
        </form>
    </div>
</div>
