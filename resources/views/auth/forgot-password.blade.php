<x-guest-layout>
    <section class="py-0 font-1">
        <div class="container-fluid">
            <div class="row align-items-center text-center justify-content-center h-full">
                <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <h3 class="mb-3 fw-300">Reset Password</h3>
                    <p class="text-left fs--1 pt-3 pb-3">Enter your Login ID/Username that was generated when you registered. We'll send you an email with a link to reset your password.</p>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ routeCheck('forget.password.post') }}">
                          @csrf
                        <div>
                            <input class="form-control" type="username" placeholder="Enter your Login ID" name="username"
                                value="{{ old('username') }}"  autocomplete="texte" maxlength="100"/>
							<x-jet-input-error for="username" class="d-block text-left" />
                        </div>
                        <div class="row align-items-center mt-2">
                            <div class="col text-left">
                                <div class="fs--1 d-inline-block">
                                    @if (Route::has('login'))
                                    <a class="color-black text-underline" href="{{ route('login') }}">
                                        Return to login page
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col text-right">
                                <x-jet-button class="ml-4">
                                    Submit
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
