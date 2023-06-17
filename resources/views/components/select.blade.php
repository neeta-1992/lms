@props(['options','placeholder','selected','is_date_format'=>false])
@php
    $selectedVal = isset($selected) ? $selected : '' ;

@endphp
<div>

   <select {{ $attributes->merge(['class'=>'input-sm']) }}>
      @if(!empty($placeholder))
        <option value='{{ "" }}'>{{ $placeholder ?? '' }}</option>
      @endif


      @if(!empty($options))
         @foreach($options as $key => $option)
            @if (!empty($selectedVal) && is_array($selectedVal))
                @php
                   $selected = in_array($key,$selectedVal) ? 'selected' : '';
                @endphp
            @else
                @php
                   $selected =  $selectedVal == $key ? 'selected' : '';
                @endphp
            @endif
            @if(!empty($is_date_format))
            <option value="{{ changeDateFormat($key ?? '',true) }}" {{ $selected ?? '' }}>{{ changeDateFormat($option ?? '',true) }}</option>
            @else
            <option value="{{ $key ?? '' }}" {{ $selected ?? '' }}>{{ $option ?? '' }}</option>
            @endif
             
         @endforeach
      @endif
   </select>
</div>
