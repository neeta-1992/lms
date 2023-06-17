@php
    $submenu = isset($submenu) ? $submenu : [] ;
@endphp

@if(!empty($submenu))
   <ul class="dropdown dropdown-push-left">
           {{--  @if(count($menu['submenu']) > 13)
                <div class="row justify-content-center my-5 pl-5 no-gutters">
            @endif --}}
            @foreach($submenu as $key => $sub)
                @if(isset($sub['submenu']))
                    <li class="has-dropdown">
                        <a href="{{ !empty($sub['url']) ? $sub['url'] : 'javasctipt:void(0)'  }}">{{ $sub['title'] ?? '' }}</a>
                        @includeIf("company.parts.nav.sub-menu",['submenu'=>$sub['submenu']])
                    </li>
                @else
                <li>
                    <a href="{{ !empty($sub['url']) ? $sub['url'] : 'javasctipt:void(0)'  }}">{{ $sub['title'] ?? '' }}</a>
                </li>
                @endif
            @endforeach
        {{-- @if(count($menu['submenu']) > 13)
            </div>
        @endif --}}


    </ul>
@endif

