@props(['disabled' => false,'error'=>''])
@php
    $classError = "" ;
    $autocomplete = $attributes->get('type') ?? '';
    $id = !empty($attributes->get('id')) ? $attributes->get('id') : $attributes->get('name');
@endphp
@error($error)
 @php
     $classError = "is-invalid";
 @endphp
@enderror

<input {{ $disabled ? 'disabled' : '' }}   {!! $attributes->merge(['class' => "form-control input-sm {$classError}",'id'=>$id]) !!} autocomplete="new-{{ $autocomplete ?? '' }}" />
