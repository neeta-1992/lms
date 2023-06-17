@php
    $menuArr = MenuHelper::companyMenu();
@endphp
@if (!empty($menuArr))
    @foreach($menuArr as $key => $menu)
        @if(isset($menu['submenu']))
            @php
                $arrowIcon  = isset($menu['arrowIcon']) ? ($menu['arrowIcon'] == false ? 'dropdown_no_arrow' : '') : '';
            @endphp
                <li class="has-dropdown">
                    <a href="JavaScript:void(0)" class="{{ $arrowIcon ?? '' }}">{{ $menu['title'] ?? '' }}</a>

                    @includeIf("company.parts.nav.sub-menu",['submenu'=>$menu['submenu']])
                </li>
            @else
            <li>
                <a href="{{ !empty($menu['url']) ? $menu['url'] : 'javasctipt:void(0)'  }}">{{ $menu['title'] ?? '' }}</a>
            </li>
        @endif
    @endforeach
@endif
