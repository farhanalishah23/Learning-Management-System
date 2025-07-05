@extends('backend.layout.master')
@section('content')
    <div class="page-section">
        <h1 class="text-display-1">Students</h1>
        <a href="{{url('add_student')}}" class="btn btn-sm btn-info" >Add Student</a>
    </div>

    <div class="panel panel-default">
        <!-- Data table -->
        <table data-toggle="data-table" class="table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $key=>$student)
            <tr>
                <td>{{++$key}}</td>
                <td>
                    @if($student->image)
                        <img  src="{{ asset('website') }}/{{$student->image}}" style="height: 50px"  alt="no image">
                    @else
                        <img style="height: 50px" id="image-preview" src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg" alt="Default Profile Image" >
                    @endif
                </td>
                <td>{{$student->name}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->created_at->format(env('DATE_FORMAT')) ?? ''}}</td>
                <td>
                    @if($student->status=='active')
                        <a href="{{url('update_teacher_status',[$student->id,'inactive'])}}" class="badge badge-primary ">Active</a>
                    @else
                        <a href="{{url('update_teacher_status',[$student->id,'active'])}}" class="badge badge-danger">Inactive</a>
                    @endif
                </td>
                <td>
                    <div  class="btn-group" role="group"  style="width: 100%">
                        <button href="{{url('show_student', $student->id)}}" style="margin-right: 5px"  type="button" class="btn btn-sm btn-info">
                            Edit Student
                        </button>
                        <form class="deleteForm" action="{{ url('destroy_student') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $student->id }}">
                            <button class="btn btn-sm btn-danger deleteButton"   type="button">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>

    </div>
@endsection
