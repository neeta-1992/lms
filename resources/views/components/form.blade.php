@props(['spoofMethod','method'])
@php
    $spoofMethod = !empty($spoofMethod) ? $spoofMethod : '' ;
    $method = !empty($method) ? $method : 'post' ;
@endphp
<form method="{{ $spoofMethod ? 'POST' : $method }}" {!! $attributes->merge(['class' => '' ]) !!} novalidate>
    @unless(in_array($method, ['HEAD', 'GET', 'OPTIONS']))
        @csrf
    @endunless

    @if($spoofMethod)
        @method($method)
    @endif

    {!! $slot !!}
</form>
