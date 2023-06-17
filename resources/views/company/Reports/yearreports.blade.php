<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'Action' }">
                <div class="col-lg-12">
                    <h4>
                        <h4>{{ $pageTitle ?? dynamicPageTitle('page') ?? '' }}</h4>
                    </h4>
                </div>
            </div>
        </div>
    </section>
    </x-app-layout>
    
    
    