
@props(['name','required'])
<div  {{ $attributes->merge(['class'=>'ui search selection dropdown notUi divUiDropdown']) }}>

    @if($slot?->isNotEmpty())
       {!!  $slot !!}
    @else
        <input type="hidden" name="{{ $name ?? '' }}"  {{ $required ?? '' }} >
    @endif
    <i class="dropdown icon"></i>
    <input type="text" class="search">
    <div class="default text">{{ $placeholder ?? 'Select one...' }}</div>
</div>

