<!DOCTYPE html>
<html class="hide-sidebar ls-bottom-footer" lang="en">


<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sign Up</title>


    <link href="{{asset('backend')}}/css/vendor/all.css" rel="stylesheet">


    <link href="{{asset('backend')}}/css/app/app.css" rel="stylesheet">


</head>

<body class="login">

<div id="content">
    <div class="container-fluid">

        <div class="lock-container">
            <div class="panel panel-default text-center paper-shadow" data-z="0.5">
                <h1 class="text-display-1">Create account</h1>
                <div class="panel-body">

                    <!-- Signup -->
                    <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <div class="form-control-material">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <label for="name">Name</label>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-material">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="email">Email address</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-material">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <label for="password">Password</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-material">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm">Re-type password</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Image</label>
                            <input class="form-control" type="file" name="image" id="image" >
                            @error('image')
                            <strong>{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <div class="checkbox">
                                <input type="checkbox" id="agree" />
                                <label for="agree">* I Agree with <a href="#">Terms &amp; Conditions!</a></label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button  type="submit" class="btn btn-primary">Create an Account</button>
                        </div>
                    </form>
                    <!-- //Signup -->

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <strong>Learning</strong> v1.1.0 &copy; Copyright 2015
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
