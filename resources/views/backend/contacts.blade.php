@extends('backend.layout.master')
@section('content')
    <h4 class="page-section-heading">Data Table</h4>
    <div class="panel panel-default">
        <!-- Data table -->
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($contacts as $key=>$contact)
                <tr>
                    <td>{{++$key ?? ''}}</td>
                    <td>{{$contact->name ?? ''}}</td>
                    <td>{{$contact->email ??''}}</td>
                    <td>{{$contact->subject ?? ''}}</td>
                    <td>
                        <div class="btn-group ">
                            <button type="button" class="btn btn-sm btn-info view_contact_button"  data-bs-toggle="modal" data-bs-target=".viewModal"  style="margin-right: 10px"  contact_id="{{ $contact->id }}" contact_name="{{ $contact->name }}" contact_email="{{ $contact->email }}" contact_subject="{{ $contact->subject }}" contact_phone="{{ $contact->phone }}" contact_message="{{ $contact->message }}" >View Contact</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal viewModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Contact</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form href="#" method="get">
                    @csrf
                    <input type="hidden" name="edit_contact_id" id="edit_contact_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="edit_contact_name" name="name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="text" class="form-control" id="edit_contact_email" name="email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <input type="text" class="form-control" id="edit_contact_subject" name="subject" readonly>
                        </div>
                        <div class="form-group">
                            <label for="subject">Phone *</label>
                            <input type="text" class="form-control" id="edit_contact_phone" name="phone" readonly>
                        </div>
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea class="form-control" id="edit_contact_message" name="message" rows="4" readonly></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click','.view_contact_button',function(e){
            e.preventDefault();
            var contact_id     = $(this).attr('contact_id ');
            var contact_name   = $(this).attr('contact_name');
            var contact_email = $(this).attr('contact_email');
            var contact_subject = $(this).attr('contact_subject');
            var contact_phone = $(this).attr('contact_phone');
            var contact_message = $(this).attr('contact_message');
            $('#edit_contact_id').val(contact_id);
            $('#edit_contact_name').val(contact_name);
            $('#edit_contact_email').val(contact_email);
            $('#edit_contact_subject').val(contact_subject);
            $('#edit_contact_phone').val(contact_phone);
            $('#edit_contact_message').val(contact_message);
            $('.viewModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.viewModal').hide();
        });
    </script>

@endpush
