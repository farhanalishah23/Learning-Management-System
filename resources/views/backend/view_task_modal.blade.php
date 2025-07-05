<div class="modal-dialog dialog-model" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">My Task</h5>
        </div>
        <form method="post" action="{{url('store_score')}}">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="course_id" value="{{$studentCourses->course_id??''}}" id="course_id">
                <input type="hidden" name="student_id" value="{{$studentCourses->student_id??''}}" id="student_id">
                <div class="form-group mb-3">
                    <label class="form-label" for="task">Task</label>
                    <input class="form-control" name="task" value="{!! $studentTasks ->task !!}" id="task" readonly>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="task">Task Answer</label>
                    <input class="form-control" name="task" value="{{ $studentCourses->answer??''}}" id="task" readonly>
                </div>
                @if(!empty($studentScore->remarks))
                    <div class="form-group mb-3">
                        <label class="form-label" for="task">Give Score Out Of 100 *</label>
                        <input class="form-control" name="score" min="0" max="100" value="{{$studentScore->score}}" type="number" readonly >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="remarks">Give Remarks Pass Or Fail *</label>
                        <input class="form-control" name="remarks" value="{{$studentScore->remarks}}" readonly>
                    </div>
                @else
                    <div class="form-group mb-3">
                        <label class="form-label" for="task">Give Score Out Of 100 *</label>
                        <input class="form-control" name="score" min="0" max="100" value="" type="number" >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="remarks">Give Remarks Pass Or Fail *</label>
                        <input class="form-control" name="remarks" value="">
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if(!empty($studentScore->remarks))
                <input type="button" class="btn btn-secondary" value="Close" data-dismiss="modal">
                @else
                    <input type="button" class="btn btn-secondary" value="Close" data-dismiss="modal">
                <button type="submit" class="btn btn-primary">Give Score</button>
                @endif
            </div>
        </form>
    </div>
</div>


