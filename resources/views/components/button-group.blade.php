@props(['isDelete', "class",'cancel','isClass','notlabel','xclick','btnText','hideCancel','deleteUrl','dataText','cancelClass'])
@php
    $class = !empty($class) ? $class : 'saveData';
    $class = $class.($isClass ?? '')
@endphp
<div class="form-group row ">
    @empty($notlabel)
        <label for="esignature" class="col-sm-3 col-form-label"></label>
    @endempty

    <div class="col-sm-9 {{ !empty($notlabel) ? 'pl-2'  : '' }}">
        <button type="submit" {!! $attributes->merge(['class' => 'button-loading btn btn-primary '.$class]) !!} >
            <span class="button--loading d-none"></span> <span class="button__text"> {{ $btnText ?? __("labels.save") }} </span>
        </button>

        @empty($hideCancel)
        @if(empty($cancel) && empty($xclick))
            <button type="button" class="btn btn-secondary" x-on:click="backUrl">
                @lang("labels.cancel")
            </button>
        @elseif(!empty($xclick))
         <button type="button" class="btn btn-secondary {{ $cancelClass ?? '' }}" x-on:click="{{ $xclick ?? 'backUrl' }}">
                @lang("labels.cancel")
            </button>
        @else
            <a href="{{ $cancel ?? '' }}" class="btn btn-secondary {{ $isClass ?? '' }}" data-turbolinks="false" >
                @lang("labels.cancel")
            </a>
        @endif
        @endempty

        @isset($isDelete)
            <button type="button" class="btn btn-danger deleteData" data-url="{{ $deleteUrl ?? '' }}" data-text="{{ $dataText ?? '' }}">
                @lang("labels.delete")
            </button>
        @endisset
    </div>
</div>
