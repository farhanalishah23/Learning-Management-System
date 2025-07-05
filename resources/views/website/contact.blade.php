@extends('website.layouts.master')
@section('content')
    <div class="parallax page-section bg-blue-300">
        <div class="container parallax-layer" data-opacity="true">
            <div class="media media-grid v-middle">
                <div class="media-left">
                    <span class="icon-block half bg-blue-500 text-white"><i class="fa fa-envelope"></i></span>
                </div>
                <div class="media-body">
                    <h3 class="text-display-2 text-white margin-none">Contact us</h3>
                    <p class="text-white text-subhead">Feel free to visit or send us a message anytime.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="relative height-500 height-400-xs">
        <div class="maps-google-fs" data-toggle="google-maps" data-draggable="false" data-file="js/data/google_maps/markers.json" data-zoom-position="LEFT_BOTTOM" data-center="57.6990668845024,11.98333499336286" data-style="paper" data-zoom="18"></div>
        <script id="map-infobox-simple" type="text/x-handlebars-template">

            <div>
                <div class="text-center">
                    <h1 class="text-headline"></h1>
                </div>
            </div>

        </script>
    </div>

    <div class="page-section parallax relative overflow-hidden">
        <img class="parallax-layer absolute top left" data-translate-when="inViewport" src="{{asset('backend')}}/images/photodune-6745579-modern-creative-man-relaxing-on-workspace-m.jpg" alt="parallax image" />
        <div class="container">
            <div class="panel margin-none panel-default paper-shadow max-width-400 h-center" data-z="0.5">
                <div class="panel-heading">
                    <h4 class="text-headline">Send a message</h4>
                </div>
                <div class="panel-body">
                    <form id="contact-form" method="post" action="{{ url('contact_store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Name"/>
                        </div>
                        <div class="form-group ">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" name="email" id="email" placeholder="Email"/>
                        </div>
                        <div class="form-group ">
                            <label for="subject">Subject:</label>
                            <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject"/>
                        </div>
                        <div class="form-group  ">
                            <label for="phone">Phone:</label>
                            <input class="form-control" name="phone" type="number" id="phone" placeholder="Phone"/>
                        </div>
                        <div class="form-group">
                            <label for="message">Your message:</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Your message"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary relative paper-shadow">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
            <br/>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#contact-form").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    subject: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    message: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    subject: {
                        required: "Please enter the subject"
                    },
                    phone: {
                        required: "Please enter your phone number"
                    },
                    message: {
                        required: "Please enter your message"
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endpush
