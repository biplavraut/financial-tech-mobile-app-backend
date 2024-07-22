<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }} | Admin Login </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    {{--
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}"> --}}

    <!-- plugin css -->
    <link rel="stylesheet" href="{{ adminAssetsUrl('plugins/@mdi/font/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ adminAssetsUrl('plugins/perfect-scrollbar/perfect-scrollbar.css')}}">
    <!-- end plugin css -->

    <!-- plugin css -->
    @stack('plugin-styles')
    <!-- end plugin css -->

    <!-- common css -->
    <link rel="stylesheet" href="{{ adminAssetsUrl('css/app.css')}}">
    <!-- end common css -->
    @stack('style')
</head>

<body data-base-url="{{url('/')}}">

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">

            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{ asset('logo/logo.png') }}">
                            </div>



                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" required class="form-control form-control-lg text-black"
                                        id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password" name="password" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                        IN</a>
                                </div>

                                @if (count($errors) > 0)
                                <div class="form-group align-items-center">
                                    <label class="error mt-2 text-danger">{{ trans('auth.failed') }}</label>
                                </div>
                                @endif

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"><i class="input-helper"></i>
                                            Keep me signed in </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</body>

</html>


{{-- https://unsplash.it/600/600?image=777 --}}