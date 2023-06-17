<x-app-layout :class="['inMail', 'quill', 'emoji']">
    @can('isAdminCompany')
    @php
    $type = "financeCompanieAdmin"
    @endphp
    @elsecan('companyUser')
    @php
    $type = "financeCompanieAdmin"
    @endphp
    @endcan
    <section class="font-1 pt-5 hq-full">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                            {{ $pageTitle ?? '' }}
                        </x-slot>
                    </x-jet-section-title>
                </div>
                <x-in-mail />
            </div>

        </div>
    </section>
</x-app-layout>
