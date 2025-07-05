@extends('backend.layout.master')
@section('content')
    <div class="page-section">
        <h1 class="text-display-1">Categories</h1>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" >
            Add New
        </button>
    </div>
    <div class="panel panel-default">
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $key=>$category)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->created_at->format(env('DATE_FORMAT')) ?? ''}}</td>
                    <td>
                        @if($category->status=='active')
                            <a href="{{url('update_category_status',[$category->id,'inactive'])}}" class="badge badge-primary ">Active</a>
                        @else
                            <a href="{{url('update_category_status',[$category->id,'active'])}}" class="badge badge-danger">Inactive</a>
                        @endif
                    </td>
                    <td>
                        <div  class="btn-group" role="group"  style="width: 100%">
                                <button style="margin-right: 5px"  type="button" class="btn btn-sm btn-info edit_category_button" category_id="{{ $category->id }}" category_name="{{ $category->name }}">
                                    Edit
                                </button>
                                <form class="deleteForm" action="{{ url('destroy_category') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $category->id }}">
                                    <button class="btn btn-sm btn-danger deleteButton"   type="button">Delete</button>
                                </form>
                            </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group"  method="post" action="{{ url('add_category') }}">
                    @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name *</label>
                        <input class="form-control"  name="name" id="name" type="text" required placeholder="Enter full name" required>
                        @if($errors->has('name'))
                            <span class="text-danger" >{{$errors->first('name')}}</span>
                        @endif
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
                    <button type="submit" class="btn btn-primary">Add category</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update_category',0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_category_id" id="edit_category_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="edit_category_name" name="name" required >
                        </div>
                        @if($errors->has('name'))
                            <span class="text-danger" >{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(document).on('click','.edit_category_button',function(e){
            e.preventDefault();
            var category_id     = $(this).attr('category_id');
            var category_name   = $(this).attr('category_name');
            $('#edit_category_id').val(category_id);
            $('#edit_category_name').val(category_name);
            $('.editModal').show();
        });
        $(document).on('click','.close',function(e){
            e.preventDefault();
            $('.editModal').hide();
        });
    </script>
@endpush

