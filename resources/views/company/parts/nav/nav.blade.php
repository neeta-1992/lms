<div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
        @include("company.parts.nav.menu")
        <li class="has-dropdown">
            <a href="<?= url('/'); ?>">Erez Golomb <i class="fa-regular fa-user-large"></i></a>
            <ul class="dropdown dropdown-push-left">
                <li>
                    <a href="javascript:void(0);" onClick="javascript:window.open('https://enetworks.com/docs/index.html','','min-width=800,height=700');">User Guide</a>
                </li>
                <li>
                    @if(Route::has('company.logout'))
                         <a href="{{ route('company.logout') }}">Sign out</a>
                    @endif

                </li>
            </ul>
        </li>
    </ul>
</div>
