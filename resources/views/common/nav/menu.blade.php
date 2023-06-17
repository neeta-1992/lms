@php
    $menuArr = MenuHelper::menu();
@endphp
@if (!empty($menuArr))
    @foreach($menuArr as $key => $menu)
        @if(isset($menu['submenu']))
            @php
                $arrowIcon  = isset($menu['arrowIcon']) ? ($menu['arrowIcon'] == false ? 'dropdown_no_arrow' : '') : '';
                $class  = !empty($menu['class']) ?  $menu['class']  : '';
                $dropdown  = !empty($menu['dropdown']) ?  $menu['dropdown']  : 'yes';
            @endphp
              @if($dropdown  == 'yes')
                <li class="has-dropdown {{ $class ?? '' }} ">
                    <a href="JavaScript:void(0)" class="{{ $arrowIcon ?? '' }}">{{ $menu['title'] ?? '' }}</a>
                    @includeIf("common.nav.sub-menu",['submenu'=>$menu['submenu']])
                </li>
               @else
                <li class="{{ $class ?? '' }} ">
                    <a href="JavaScript:void(0)" class="{{ $arrowIcon ?? '' }}">{{ $menu['title'] ?? '' }}</a>
                    @includeIf("common.nav.sub-menu",['submenu'=>$menu['submenu']])
                </li>
              @endif
                
            @else
            @if(!empty($menu['url']) && Route::has($menu['url']))
                <li>
                    <a href="{{ Route::has($menu['url']) ? route($menu['url']) : 'javasctipt:void(0)'  }}" data-turbolinks='false'>{{ $menu['title'] ?? '' }}</a>
                </li>
            @elseif(empty($menu['url']))
                <li>
                    <a href="javasctipt:void(0)" >{{ $menu['title'] ?? '' }}</a>
                </li>
            @endif

        @endif
    @endforeach
@endif
