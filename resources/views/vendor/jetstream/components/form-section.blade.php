@props(['submit', 'action', 'buttonGroup', 'title', 'activePageName'])
@php
    $activePageName = !empty($activePageName) ? $activePageName : activePageName();
@endphp
<section class="font-1 pt-5 hq-full mainContent" x-data='{ open : "isForm" , title : "",backPage:"" }'
    x-effect="async () => {
            switch (open) {
                case 'logs':
                    title = 'logs';
                    let logsId = '{{ $activePageName . '-logs' ?? '' }}';
                    $('#'+logsId).bootstrapTable('refresh')
                    break;
                default:
                    break;
            }
        }">
    <div class="container tableButtonInlineShow">
        <div class="row">
            <div class="col-md-12 page_table_heading">
                <x-jet-section-title>
                    @if (!empty($title) && is_array($title))
                         <x-slot name="title">
                            {{ $title['title'] ?? '' }}
                        </x-slot>
                        @if (!empty($title['badge']))
                            <x-slot name="badge">
                                {{ $title['badge'] ?? '' }}
                            </x-slot>
                        @endif
                    @else
                        <x-slot name="title">
                            {{ $title ?? (dynamicPageTitle('page') ?? '') }}
                        </x-slot>
                    @endif

                    @isset($description)
                        <x-slot name="description">
                            <span class="small">
                                {{ $description ?? '' }}
                            </span>
                        </x-slot>
                    @endisset

                </x-jet-section-title>
            </div>
            <div class="col-md-12 page_table_menu">
                <div class="row align-items-end">

                    @isset($menu_drop_dwon)
                        <div class="col-md-4">
                           {!! $menu_drop_dwon ?? '' !!}
                        </div>
                    @endisset
                    <div class="{{ !empty($menu_drop_dwon) ? 'col-md-8' : 'col-md-12'  }}" x-show="open == 'isForm'">
                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <div class="columns d-flex justify-content-end ">
                                    @isset($buttonGroup)
                                        @isset($letMenu)
                                            {{ $letMenu }}
                                        @endisset


                                        @if (in_array('logs', $buttonGroup))
                                            <button class="btn btn-default" type="button" name="Add"
                                                x-on:click="open = 'logs'">@lang('text.logs')</button>
                                        @endif
                                        @if (in_array('exit', $buttonGroup) || !empty($buttonGroup['exit']))
                                            @php
                                                $exitUrl = isset($buttonGroup['exit']['url']) ? $buttonGroup['exit']['url'] : '';
                                            @endphp
                                            @if (!empty($exitUrl))
                                                <button class="btn btn-default"> <a href="{{ $exitUrl ?? '' }} "
                                                        data-turbolinks="false"
                                                        name="Exit">@lang('text.model.exit')</a></button>
                                            @else
                                                <button class="btn btn-default backUrl" type="button"
                                                    name="Exit">@lang('text.model.exit')</button>
                                            @endif
                                        @endif
                                        @if (!empty($buttonGroup['other']))
                                            @foreach ($buttonGroup['other'] as $key => $otherButton)
                                                @if (!empty($otherButton['url']))
                                                    <button class="btn btn-default" type="button"
                                                        name="{{ $otherButton['text'] ?? '' }}"> <a
                                                            href="{{ $otherButton['url'] ?? '' }}"
                                                            data-turbolinks="false">{{ $otherButton['text'] ?? '' }}</a>
                                                    </button>
                                                @else
                                                    <button class="btn btn-default {{ $otherButton['class'] ?? '' }}"
                                                        type="button" data-id="{{ $otherButton['dataId'] ?? '' }}">{{ $otherButton['text'] ?? '' }}</button>
                                                @endif
                                            @endforeach
                                        @endif

                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @isset($form)
                <div class="col-lg-12" x-show="open == 'isForm'">
                    @if (isset($action))
                        <form action="{{ $action }}" {{ $attributes->merge([]) }}>
                            @csrf
                        @elseif (isset($submit))
                            <form wire:submit.prevent="{{ $submit }}" {{ $attributes->merge([]) }}>
                            @else
                                <form {{ $attributes->merge([]) }}>
                    @endif
                    <div class="">
                        {{ $form }}
                    </div>

                    @if (isset($actions))
                        <div class="mt-2 d-flex justify-content-end">
                            {{ $actions }}
                        </div>
                    @endif


                    @if (isset($saveOrCancel))
                        <div class="form-group row">
                            <label for="esignature" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="button" class="button-loading btn btn-primary saveData">
                                    <span class="button--loading d-none"></span> <span class="button__text">Save</span>
                                </button>
                                <button type="button" class="btn btn-secondary backUrl">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    @endif
                    @if (isset($saveOrCancelDelete))
                        <div class="form-group row">
                            <label for="esignature" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="button" class="button-loading btn btn-primary saveData">
                                    <span class="button--loading d-none"></span> <span class="button__text">Save</span>
                                </button>
                                <button type="button" class="btn btn-secondary backUrl">
                                    Cancel
                                </button>
                                <button type="button" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endif
                    </form>
                </div>
            @endisset
            @isset($logContent)
                <div class="col-md-12" x-show="open == 'logs'">
                    {!! $logContent ?? '' !!}
                </div>
            @endisset
            @isset($otherTab)
                <div class="col-md-12">
                    {!! $otherTab ?? '' !!}
                </div>
            @endisset
        </div>
    </div>
</section>
