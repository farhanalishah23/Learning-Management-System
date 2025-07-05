<!DOCTYPE html>
<html class="hide-sidebar ls-bottom-footer" lang="en">


<!-- Mirrored from learning.frontendmatter.com/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Nov 2022 00:02:28 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Learning</title>


    <link href="{{asset('backend')}}/css/vendor/all.css" rel="stylesheet">


    <link href="{{asset('backend')}}/css/app/app.css" rel="stylesheet">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js" ></script>


</head>

<body class="login">

<div id="content">
    <div class="container-fluid">

        <div class="lock-container">
            <div class="panel panel-default text-center paper-shadow" data-z="0.5">
                <h1 class="text-display-1 text-center margin-bottom-none">Sign In</h1>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <div class="form-control-material">
                                <input id="email" type="email" class="form-control" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label for="email">Email</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-material">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <label for="password">Password</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                               </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login <i class="fa fa-fw fa-unlock-alt"></i></button>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                        @endif
                        <a href="{{url('register')}}" class="link-text-color">Create account</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <strong>Learning</strong> v1.1.0 &copy; Copyright 2024
</footer>
<!-- // Footer -->

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



</body>


</html>
