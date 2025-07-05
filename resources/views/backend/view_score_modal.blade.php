<div class="modal-dialog dialog-model" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">My Score</h5>
        </div>
        <form>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="form-label" for="task">Your Score Out of 100</label>
                    <input class="form-control" value="{{$studentScore->score}}" name="score" min="0" max="100" type="number" readonly>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="remarks">Remarks Given By Teacher </label>
                    <input class="form-control" name="remarks" value="{{$studentScore->remarks}}" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
