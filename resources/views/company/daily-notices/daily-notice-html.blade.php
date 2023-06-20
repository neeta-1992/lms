@php
    $menuHtml = $sectionHtml = $activeClass = '';
@endphp
@if (!empty($data))
    @foreach ($data as $key => $value)
        @php

            $activeClass = $loop->iteration == 1 ? 'active' : '';
            $Id = "Notice{$loop->iteration}";
            $accountId = $value?->account_data?->account_number;
            $menuHtml .=
                ' <li class="nav-item">
                            <a class="nav-link ' .
                $activeClass .
                '" href="#' .
                $Id .
                '" onClick="return false">' .
                $accountId .
                '</a>
                        </li>';

            $sectionHtml .=
                '<div id="' .
                $Id .
                '" class="scrollingsection">
                            <h4 class="my-4">Account Number : ' .
                $accountId .
                '</h4>
                            <p>' .
                $value->template .
                '</p>
                        </div>';
        @endphp
    @endforeach
@endif
<div class="row">
    <div class="col-md-3">
        <nav class="inner-link sticky-top background-white">
            <ul class="nav nav-pills py-3 flex-column">
                {!! $menuHtml ?? '' !!}
            </ul>
        </nav>
    </div>
    <div class="col-md-9">
        {!! $sectionHtml ?? '' !!}
    </div>
</div>
