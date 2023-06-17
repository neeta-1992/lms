@props(['name','id','label','accept'])
@php
    $id = !empty($id) ? $id : $name;
@endphp
{{--data-multiple-caption="{count} files selected" --}}
<div class="custom_file">
    <input id="{{ $id ?? '' }}" type="file" name="{{ $name ?? '' }}"
        accept="{{ $accept ?? '' }}"   {!! $attributes->merge(['class' => 'inputfile fileUpload']) !!}>
    <label class="btn btn-outline-primary btn-sm" data-label="{!!  $label ?? ''  !!}" for="{{ $id ?? '' }}">
        <span>{!!  $label ?? ''  !!}</span>
    </label>
</div>
