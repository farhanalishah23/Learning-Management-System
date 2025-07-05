@extends('backend.layout.master')
@section('content')

    <div class="page-section">
        <h1 class="text-display-1 margin-none">Dashboard</h1>
    </div>
    <div class="item col-xs-12 col-lg-6">
    <div class="panel panel-default paper-shadow" data-z="0.5">
        <div class="panel-heading">
            <h4 class="text-headline margin-none">Courses</h4>
            <p class="text-subhead text-light">Recent courses</p>
        </div>
        <ul class="list-group">
        @if(auth()->user()->hasRole('teacher'))
             @foreach($teacherCourses as $course)
            <li class="list-group-item media v-middle">
                <div class="media-body">
                    <a href="#" class="text-subhead list-group-link">{{$course->course->shortTitle ?? ''}}</a>
                </div>
                <div class="media-right">
                    <div class="progress progress-mini width-100 margin-none">
                        <div class="progress-bar progress-bar-green-300" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:45%;">
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        @elseif(auth()->user()->hasRole('student'))
                @foreach($studentCourse as $course)
                    @if(isset($course->teacher) && $course->teacher != null)
                        @if(isset($course->course) && $course->course != null)
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <a href="#" class="text-subhead list-group-link">{{$course->course->shortTitle ?? ''}}</a>
                        </div>
                        <div class="media-right">
                            <div class="progress progress-mini width-100 margin-none">
                                <div class="progress-bar progress-bar-green-300" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:45%;">
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endif
                @endforeach
            @else
                @foreach($allCourse as $course)
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <a href="#" class="text-subhead list-group-link">{{$course->shortTitle ?? ''}}</a>
                        </div>
                        <div class="media-right">
                            <div class="progress progress-mini width-100 margin-none">
                                <div class="progress-bar progress-bar-green-300" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:45%;">
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
        @if(auth()->user()->hasRole('teacher'))
        <div class="panel-footer text-right">
            <a href="{{url('manage_courses')}}" class="btn btn-white paper-shadow relative" data-z="0" data-hover-z="1" data-animated>View Courses</a>
        </div>
        @elseif(auth()->user()->hasRole('student'))
        <div class="panel-footer text-right">
            <a href="{{url('my_courses')}}" class="btn btn-white paper-shadow relative" data-z="0" data-hover-z="1" data-animated> View Courses</a>
        </div>
        @else
        <div class="panel-footer text-right">
            <a href="{{url('courses')}}" class="btn btn-white paper-shadow relative" data-z="0" data-hover-z="1" data-animated> View Courses</a>
        </div>
        @endif
    </div>
    </div>

    <div class="item col-xs-12 col-lg-6">
        <div class="panel panel-default paper-shadow" data-z="0.5">
            @if(auth()->user()->hasRole('teacher'))
            <div class="panel-heading">
                <h4 class="text-headline margin-none">Top Students</h4>
                <p class="text-subhead text-light">Top 3 marks holder students</p>
            </div>
            <ul class="list-group">
                        @foreach($TopMarks as $TopMark)
                            <li class="list-group-item media v-middle">
                                <div class="media-body">
                                    {{$TopMark->student->name ?? ''}}
                                </div>
                                <div class="media-right">
                                 {{$TopMark->score ?? ''}}
                                </div>
                            </li>
                        @endforeach
            </ul>
                @elseif(auth()->user()->hasRole('student'))
                <div class="panel-heading">
                    <h4 class="text-headline margin-none">My Highest Marks</h4>
                </div>
                @foreach($myHighestMarks as $myHighestMark)
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            {{$myHighestMark->course->title ?? ''}}
                        </div>
                        <div class="media-right">
                            {{$myHighestMark->score ?? ''}}
                        </div>
                    </li>
                @endforeach
                @else
                <div class="panel-heading">
                    <h4 class="text-headline margin-none">All Top Students</h4>
                    <p class="text-subhead text-light">All top 3 marks holder students</p>
                </div>
                <ul class="list-group">
                    @foreach($AllTopMarks as $AllTopMark)
                        <li class="list-group-item media v-middle">
                            <div class="media-body">
                                {{$AllTopMark->student->name ?? ''}}
                            </div>
                            <div class="media-right">
                                {{$AllTopMark->score ?? ''}}
                            </div>
                        </li>
                    @endforeach
            </ul>
            @endif
        </div>
    </div>

    <div class="item col-xs-12 col-lg-6">
        <ul class="list-group relative paper-shadow" data-hover-z="0.5" data-animated>
            <li class="list-group-item paper-shadow">
                <div class="media v-middle">
                    <div class="media-left">
                        <a href="#">
                            <img id="image-preview" src="{{ asset('website') }}/{{ Auth::user()->image }}" alt="person" class="img-circle width-40">
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="#" class="text-subhead link-text-color">{{Auth::user()->email}}</a>
                        <div class="text-light">
                            Role: <a href="#">{{Auth::user()->role}}</a> &nbsp;
                        </div>
                    </div>
                    <div class="media-right">
                        <div class="width-60 text-right">
                            <span class="text-caption text-light">{{Auth::user()->shortCreatedAt}}</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    </div>
@endsection
