<section class="font-1 pt-5 hq-full" {{ $attributes->merge(['class' => '']) }}>
    <div class="container tableButtonInlineShow">
        <div class="row">
            <div class="col-md-12 page_table_heading">
                <x-jet-section-title>
                    <x-slot name="title">
                        {{ $title ?? (dynamicPageTitle('page') ?? '') }}
                    </x-slot>
                    @isset($description)
                        <x-slot name="description">
                            <span class="small">
                                {{ $description ?? '' }}
                            </span>
                        </x-slot>
                    @endisset

                </x-jet-section-title>
            </div>
            <div class="col-md-12 page_table_menu" x-show="open == 'isForm'">
                <div class="row align-items-end">
                    <div class="col-md-12">
                        <div class="columns d-flex">
                           {{ $uiDropDwon ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-12">
                    {{ $content }}
            </div>
        </div>
    </div>
</section>
