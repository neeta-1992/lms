<x-guest-layout>
    <section class="py-0 font-1">
        <div class="container-fluid">
            <div class="row align-items-center  justify-content-center h-full">
                <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                    <h3 class="fw-300 mb-5">Reset Password</h3>

                    <x-jet-validation-errors class="mb-4" />
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
                    <form method="POST" action="{{ routeCheck('reset.password.post') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token ?? '' }}">



                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            <x-jet-input id="password" class="block mt-1 w-full " type="password" name="password"
                                required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button>
                                {{ __('Reset Password') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
</x-guest-layout>
