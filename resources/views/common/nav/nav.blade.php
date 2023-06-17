
<div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
        @include('common.nav.menu')
		@cannot('isAdmin')
			<li>
              <a class="nav-link color-1 fw-300" style="opacity:0.5;" href="javascript:void(0);">
                |
              </a>
            </li>
			<li>
              <a href="{{ routeCheck('company.task.index') }}" class="pl-2 pr-0 color-1" data-turbolinks="false">
                <i class="fa-thin fa-calendar-clock" style="font-size: 14px;"></i>
				  <div class="badge badge-primary navbadgeicon maintaskcount" style="font-size: 9px;"></div>
             </a>
            </li>
			<li>
              <a class="pl-2 pr-0 color-1" href="{{ routeCheck('company.in-mail.index') }}"  data-turbolinks="false">
				  <i class="fa-thin fa-envelope" style="font-size: 14px;"></i>
				  <div class="badge badge-primary navbadgeicon inboxcount" style="font-size: 9px;"></div>
              </a>
            </li>
		<li>
              <a class="nav-link color-1 fw-300" style="opacity:0.5;" href="javascript:void(0);">
                |
              </a>
            </li>
		 @endcannot
        <li class="has-dropdown">
            <a href="javascript:void(0)" data-turbolinks='false'>{{ Auth::user()->name }}<i
                    class="fa-regular fa-user-large"></i></a>
            <ul class="dropdown dropdown-push-left">
                <li>
                    <a href="javascript:void(0)"
                        onclick="return windowpop('{{ routeCheck('user-guide-docs') }}',1000, 1000)">User Guide</a>
                </li>
                <li>
                    {{-- -- Authentication --> --}}
                    <a href="{{ routeCheck('profile.show') }}" data-turbolinks='false'>
                        {{ __('My Profile') }}
                    </a>
                </li>


                @if(Auth::user()?->user_type == 1)
                    <li>
                        {{-- -- Authentication --> --}}
                        <form method="POST" action="{{ url('enetworks/logout') }}" x-data>
                            @csrf

                            <a href="{{ url('enetworks/logout') }}" @click.prevent="$root.submit();" data-turbolinks='false'>
                                {{ __('Log Out') }}
                            </a>
                        </form>


                    </li>
                @else
                <li>
                    {{-- -- Authentication --> --}}
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <a href="{{ route('logout') }}" @click.prevent="$root.submit();" data-turbolinks='false'>
                            {{ __('Log Out') }}
                        </a>
                    </form>


                </li>
                @endif

            </ul>
        </li>
    </ul>
</div>
