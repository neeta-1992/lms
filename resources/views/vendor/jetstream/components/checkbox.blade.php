@props(['for','labelText','type','isBlock'])
<div class="checkbox_custom {{ !empty($isBlock) ? 'd-block' : '' }} ">
	<input  type="checkbox" {!! $attributes->merge(['class' => 'form-check-input styled-checkbox']) !!}>
	<label for="{{ $for ?? $attributes->get('id') }}">{{ $labelText ?? '' }}</label>
</div>




