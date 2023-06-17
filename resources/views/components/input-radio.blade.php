@props(['checked','name','value','label'])
@php
  $name = !empty($name) ? $name : '' ;
  $value = !empty($value) ? $value : $attributes->get('value') ;
  
  $id    = $attributes->get('id') ? $attributes->get('id') : $name."_".$value;
@endphp
<div class="zinput zradio zradio-sm  p-0 @if(null !== $attributes->get('inline')) zinput-inline @endif">
    <input
      name="{{ $name ?? '' }}" type="radio"
      value="{{ $value ?? '' }}"
      {!! $attributes->merge(['class' => 'form-check-input']) !!}
      @if(!empty($label) && !$attributes->get('id'))
            id="{{ $id ?? '' }}"
      @endif
      {{ !empty($checked) && $checked == $value ? 'checked' : ''  }}>
    <label for="{{ $attributes->get('id') ? $attributes->get('id') : $id }}" class="form-check-label">{!! $label ?? '' !!}</label>
</div>


