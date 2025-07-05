<div class="modal-dialog dialog-model" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">My Created Task</h5>
        </div>
        <form class="form-group">
            <div class="modal-body">
                <input type="hidden" name="course_id" value="{{ $studentTasks->course_id??'' }}" id="course_id">
                <div class="form-group mb-3">
                    <label class="form-label" for="task">Task</label>
                    <textarea class="form-control" name="task"  id="task" >{!! $studentTasks->task !!}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('task');
</script>
