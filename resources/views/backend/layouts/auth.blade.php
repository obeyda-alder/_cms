<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" direction="{{ $lang_direction }}" style="direction: {{ $lang_direction }};">
	<head>
        @include('backend.includes.styles')
        <style>
            .bg-img{
                background-image: url("{{ asset('images/auth/login_4.jpg') }}");
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- alpha/css/bootstrap.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	</head>

	<body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                @include('backend.includes.toaster.toaster')
                <div class="content-wrapper d-flex align-items-center auth bg-img">
                    <div class="row flex-grow">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backend.includes.scripts')
        @stack('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
	</body>
</html>
