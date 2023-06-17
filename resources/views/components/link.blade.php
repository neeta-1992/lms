@props(['href'])
@php
    $href = !empty($href) ? $href : 'javascript:void(0)' ;
@endphp

<a href="{{ $href ?? '' }}" {!! $attributes->merge(['class' => 'linkButton']) !!}  rel="noopener noreferrer">  {{ $slot ?? '' }}</a>


