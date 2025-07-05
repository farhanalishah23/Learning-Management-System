<!DOCTYPE html>
<html class="st-layout ls-top-navbar-large ls-bottom-footer show-sidebar sidebar-l3" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Learning</title>

    <link href="{{asset('backend')}}/css/vendor/all.css" rel="stylesheet">
    <link href="{{asset('backend')}}/css/app/app.css" rel="stylesheet">
    @stack('css')
</head>

<body>

<div class="st-container">
    <div class="navbar navbar-size-large navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#sidebar-menu" data-toggle="sidebar-menu" class="toggle pull-left visible-xs"><i class="fa fa-ellipsis-v"></i></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand navbar-brand-primary navbar-brand-logo navbar-nav-padding-left">
                    <a href="{{url('/')}}">
                        LMS
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="nav navbar-nav navbar-nav-bordered navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle user" data-toggle="dropdown">
                            @if(Auth::user()->image)
                            <img src="{{asset('website')}}/{{Auth::user()->image}}"  class="img-circle" width="40" />{{ Auth::user()->shortName ?? ''}}<span class="caret"></span>
                            @else
                                <img src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"  class="img-circle" width="40">{{Auth::user()->name ?? ''}}<span class="caret"></span>
                            @endif
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{url('manage_profile')}}">Manage Profile</a></li>
                            <li><a href="{{url('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @if(Auth::user()->role == 'admin')
        <div class="sidebar left sidebar-size-3 sidebar-offset-0 sidebar-visible-desktop sidebar-visible-mobile sidebar-skin-dark" id="sidebar-menu" data-type="collapse">
            <div data-scrollable>
                <div class="sidebar-block">
                    <div class="profile">
                        <a href="#">
                            @if(Auth::user()->image)
                                <img src="{{asset('website')}}/{{Auth::user()->image}}"  alt="people" class="img-circle width-80" />
                            @else
                                <img src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"  alt="people" class="img-circle width-80">
                            @endif
                        </a>
                        <h4 class="text-display-1 margin-none">{{ ucfirst(Auth::user()->name ?? '')}}</h4>
                        <p>{{ ucfirst(Auth::user()->role ?? '') }}</p>
                    </div>
                </div>

                <ul class="sidebar-menu">
                    <li class="{{request()->is('dashboard')=='true'?'active':''}}"><a href="{{url('dashboard')}}"><i class="fa fa-bar-chart-o"></i><span>Dashboard</span></a></li>
                    <li class="hasSubmenu {{ (request()->is('categories') || request()->is('*course*')) ? 'active' : '' }}">
                        <a href="#course-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-mortar-board"></i><span>Courses</span>
                        </a>
                        <ul id="course-menu" class="collapse list-unstyled">
                            <li class="{{ request()->is('categories') ? 'active' : '' }}">
                                <a href="{{ url('categories') }}"><span>Categories</span></a>
                            </li>
                            <li class="{{ request()->is('*course*') ? 'active' : '' }}">
                                <a href="{{ url('courses') }}"><span>Courses</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('teacher*') || request()->is('*add_teacher*') ? 'active' : '' }}"><a href="{{url('teachers')}}"><i class="fa fa-comments"></i><span>Teachers</span></a></li>
                    <li class="{{ request()->is('student*') || request()->is('*add_student*') ? 'active' : '' }}"><a href="{{url('students')}}"><i class="fa fa-comments"></i><span>Students</span></a></li>
                    <li class="{{ request()->is('feature*') || request()->is('*add_feature*') || request()->is('*edit_feature*') ? 'active' : '' }}"><a href="{{url('features')}}"><i class="fa fa-comments"></i><span>Features</span></a></li>
                    <li class="{{ request()->is('testimonials*') || request()->is('*add_testimonial*') || request()->is('*edit_testimonials*') ? 'active' : '' }}"><a href="{{url('testimonials')}}"><i class="fa fa-comments"></i><span>Testimonials</span></a></li>
                    <li class="{{ request()->is('socialmedia*') || request()->is('*add_socialmedia*') || request()->is('*edit_socialmedia*') ? 'active' : '' }}"><a href="{{url('socialmedias')}}"><i class="fa fa-comments"></i><span>Social Icons</span></a></li>
                    <li class="{{ request()->is('slider*') || request()->is('*add_slider*') || request()->is('*edit_slider*') ? 'active' : '' }}"><a href="{{url('sliders')}}"><i class="fa fa-comments"></i><span>Sliders</span></a></li>
                    <li class="{{ request()->is('contacts') ? 'active' : '' }}"><a href="{{url('contacts')}}"><i class="fa fa-comments"></i><span>Contacts</span></a></li>
                    <li class="{{ request()->is('assign_teacher') ? 'active' : '' }}"><a href="{{url('assign_teacher')}}"><i class="fa fa-comments"></i><span>Assign Teacher</span></a></li>
                    <li class="{{ request()->is('assign_student') ? 'active' : '' }}"><a href="{{url('assign_student')}}"><i class="fa fa-comments"></i><span>Assign Student</span></a></li>
                    <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    @elseif(Auth::user()->role == 'teacher')
        <div class="sidebar left sidebar-size-3 sidebar-offset-0 sidebar-visible-desktop sidebar-visible-mobile sidebar-skin-dark" id="sidebar-menu" data-type="collapse">
            <div data-scrollable>
                <div class="sidebar-block">
                    <div class="profile">
                        <a href="#">
                            <img src="{{asset('website')}}/{{Auth::user()->image}}" alt="people" class="img-circle width-80" />
                        </a>
                        <h4 class="text-display-1 margin-none">{{ ucfirst(Auth::user()->name ?? '')}}</h4>
                        <p>{{ ucfirst(Auth::user()->role ?? '') }}</p>
                    </div>
                </div>
                <ul class="sidebar-menu">
                    <li class="{{request()->is('dashboard')=='true'?'active':''}}"><a href="{{url('dashboard')}}"><i class="fa fa-bar-chart-o"></i><span>Dashboard</span></a></li>
                    <li class="{{ request()->is('*course*') ? 'active' : '' }}"><a href="{{url('manage_courses')}}"><i class="fa fa-comments"></i><span>Manage Courses</span></a></li>
                    <li class="{{ request()->is('*student*') ? 'active' : '' }}"><a href="{{url('view_students')}}"><i class="fa fa-comments"></i><span>Students</span></a></li>
                    <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    @elseif(Auth::user()->role == 'student')
        <div class="sidebar left sidebar-size-3 sidebar-offset-0 sidebar-visible-desktop sidebar-visible-mobile sidebar-skin-dark" id="sidebar-menu" data-type="collapse">
            <div data-scrollable>
                <div class="sidebar-block">
                    <div class="profile">
                        <a href="#">
                            <img src="{{asset('website')}}/{{Auth::user()->image}}" alt="people" class="img-circle width-80" />
                        </a>
                        <h4 class="text-display-1 margin-none">{{ ucfirst(Auth::user()->name ?? '')}}</h4>
                        <p>{{ ucfirst(Auth::user()->role ?? '') }}</p>
                    </div>
                </div>
                <ul class="sidebar-menu">
                    <li class="{{request()->is('dashboard')=='true'?'active':''}}"><a href="{{url('dashboard')}}"><i class="fa fa-bar-chart-o"></i><span>Dashboard</span></a></li>
                    <li class="{{ request()->is('*course*') ? 'active' : '' }}"><a href="{{url('my_courses')}}"><i class="fa fa-comments"></i><span>My Courses</span></a></li>
                    <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    @endif
    <div class="st-pusher" id="content">
        <div class="st-content">
            <div class="st-content-inner padding-none">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <strong>Learning</strong> v1.1.0 &copy; Copyright 2015
        </footer>
        <!-- // Footer -->

    </div>
    <script>
        var colors = {
            "danger-color": "#e74c3c",
            "success-color": "#81b53e",
            "warning-color": "#f0ad4e",
            "inverse-color": "#2c3e50",
            "info-color": "#2d7cb5",
            "default-color": "#6e7882",
            "default-light-color": "#cfd9db",
            "purple-color": "#9D8AC7",
            "mustard-color": "#d4d171",
            "lightred-color": "#e15258",
            "body-bg": "#f6f6f6"
        };
        var config = {
            theme: "html",
            skins: {
                "default": {
                    "primary-color": "#42a5f5"
                }
            }
        };
    </script>

    <script src="{{asset('backend')}}/js/vendor/all.js"></script>

    <script src="{{asset('backend')}}/js/app/app.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        @if(Session::has('message'))
        Swal.fire({
            title: "{{Session::get('title')}}",
            text: "{{Session::get('message')}}",
            icon: "{{Session::get('type')}}",
            showConfirmButton: false,
            timer: 4000
        });
        @endif

    </script>
    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this category!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@stack('js')

</body>

</html>
