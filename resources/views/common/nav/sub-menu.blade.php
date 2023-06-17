@php
$submenu = isset($submenu) ? $submenu : [] ;
@endphp

@if(!empty($submenu))
<ul class="dropdown dropdown-push-left">
    {{-- @if(count($menu['submenu']) > 13)
                <div class="row justify-content-center my-5 pl-5 no-gutters">
            @endif --}}
    @foreach($submenu as $key => $sub)
    @php
    $dropdownmenu = !empty($sub['dropdown']) ? $sub['dropdown'] : 'yes';
    $dropdownclass = !empty($sub['class']) ? $sub['class'] : '';
    @endphp
    @if(isset($sub['submenu']))
    <li class="{{ $dropdownmenu == 'no' ? 'custome-has-dropdown' : 'has-dropdown ' }} {{ $dropdownclass ?? '' }}">
        <a href="{{ !empty($sub['url']) ? $sub['url'] : 'javasctipt:void(0)'  }}" data-turbolinks='false'>{{ $sub['title'] ?? '' }}</a>
        @includeIf("common.nav.sub-menu",['submenu'=>$sub['submenu']])
    </li>
    @else
    @if(!empty($sub['url']) && Route::has($sub['url']))
    <li>
        <a href="{{ Route::has($sub['url']) ? route($sub['url']) : 'javasctipt:void(0)'  }}" data-turbolinks='false'>{{ $sub['title'] ?? '' }}</a>
    </li>
    @elseif(empty($sub['url']))
    <li>
        <a href="javasctipt:void(0)">{{ $sub['title'] ?? '' }}</a>
    </li>
    @endif

    @endif
    @endforeach
    {{-- @if(count($menu['submenu']) > 13)
            </div>
        @endif --}}


</ul>
@endif
