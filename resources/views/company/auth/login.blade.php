@extends('company.layouts.app')


@section('content')
<section class="py-0 font-1">
    <div class="container-fluid">
        <div class="row align-items-center text-center justify-content-center h-full">
            <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <h3 class="fw-300 mb-5">Log in</h3>
               
                <form method="post" action="">
                    @csrf
                    <div class="form-group mb-0">
                        <label for="username"></label>
                        <input class="form-control" type="text" id="username" name="username" placeholder="Username"
                            value="{{ old('username') }}">
                        @error('username')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password"></label>
                        <input class="form-control " type="password" name="password" placeholder="Password">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row align-items-center">
                        <div class="col text-left">
                            <div class="fs--1 d-inline-block">
                                <a href="#">Forgot your password?</a>
                            </div>
                        </div>
                        <div class="col text-right">
                            <button class="btn-block btn btn-primary" type="submit">Log in</button>
                        </div>
                    </div>
                </form>
                <hr class="color-9 mt-6">
                <div class="fs--1">Need an account?
                    <a href="#">Sign up.</a>
                </div>
                <hr class="color-9">
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
@endsection
