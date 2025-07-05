<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Task</h5>
        </div>
        <form class="form-group">
            <div class="modal-body">
            <input type="hidden" name="course_id" value="{{ $studentTasks->course_id??'' }}" id="course_id">
            <div class="form-group mb-3">
                <label class="form-label" for="task">Task</label>
                <input class="form-control" name="task" value="{!! $studentTasks->task??'' !!}" id="task" readonly>
            </div>
                <div class="modal-footer">
                    <button  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
