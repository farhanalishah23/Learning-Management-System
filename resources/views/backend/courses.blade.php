@extends('backend.layout.master')
@section('content')
    <div class="page-section">
        <h1 class="text-display-1">My Courses</h1>
    </div>
    <div class="row" data-toggle="isotope">
        @foreach($courses as $course)
            <div class="item  col-sm-4 ">
                <div class="panel panel-default paper-shadow" data-z="0.5">
                    <div class="cover overlay cover-image-full hover" style="margin: 10px" >
                        @if($course->primaryAttachment && $course->primaryAttachment->file)
                            <img src="{{ asset('website') }}/{{$course->primaryAttachment->file}}" style="height: 200px" alt="Course Image">
                        @else
                            <img src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg" style="height: 200px">
                        @endif
                    </div>
                    <div class="panel-body">
                        <h4 class="text-headline margin-v-0-10"><a href="#">{{ $course->shortTitle }}</a></h4>
                    </div>
                    <hr class="margin-none" />
                    <div class="panel-body">
                        <a class="btn btn-white btn-flat paper-shadow relative" data-z="0" data-hover-z="1" data-animated href="{{url('show_course' , $course->id)}}"><i class="fa fa-fw fa-pencil"></i> Edit course</a>
                    </div>
                </div>
            </div>
        @endforeach


        <div class="item col-xs-12 col-sm-6 col-lg-4" >
            <div class="panel panel-default paper-shadow" data-z="0.5"  style="height: 366px">
                <div class="cover overlay cover-image-full hover"  >
                    <span class="img icon-block height-150 bg-grey-200"></span>
                    <a href="{{url('add_course')}}" class="padding-none overlay overlay-full icon-block bg-grey-200" >
                      <span class="v-center"><i class="fa fa-plus text-grey-600"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <ul class="pagination margin-top-none">
        {!! $courses->links() !!}
    </ul>
@endsection
