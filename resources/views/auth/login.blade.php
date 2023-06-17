<x-guest-layout>
    <section class="py-0 font-1">
        <div class="container-fluid">
            <div class="row align-items-center text-center justify-content-center h-full">
                <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <h3 class="fw-300 mb-5">Log in</h3>

                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <input class="form-control" id="username" type="text" value="{{ old('username') }}" name="username" autofocus="autofocus" placeholder="Enter your Login ID">

                            <x-jet-input-error for="username" class="d-block text-left" />
                        </div>

                        <div class="mt-4">
                             <input class="form-control" id="password" type="password" value="{{ old('password') }}" name="password"  autocomplete="current-password" placeholder="Enter your password">


                            <x-jet-input-error for="password" class="d-block text-left" />
                        </div>


                        <div class="row align-items-center mt-2">
                            <div class="col text-left">
                                <div class="fs--1 d-inline-block">
                                    @if (Route::has('forget.password.get'))
                                    <a class="color-black text-underline" href="{{ route('forget.password.get') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col text-right">
                                <x-jet-button class="ml-4">
                                    {{ __('Log in') }}
                                </x-jet-button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
</x-guest-layout>
