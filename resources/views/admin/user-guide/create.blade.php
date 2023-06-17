<x-app-layout>
<section class="font-1 pt-5 hq-full">
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-lg-12">
                <h4 >{{ dynamicPageTitle('page') ?? '' }}</h4>
                <div class="my-4"></div>
                <form class="validationForm" novalidate method="POST" action="{{ Route::has($route.'store') ? route($route.'store') : '' }}">
                    @csrf
                   
                       <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Guide</label>
                            <div class="col-sm-9">
                                <?=  form_dropdown('account_type', [
                                    1=>'Administrator to Premium Finance Company',
                                    2=>'Premium Finance Company',
                                    3=>'Agents/Brokers',
                                    4=>'General Agents',
                                    5=>'Insureds',
                                    6=>'Video Tutorials',
                                    ], '', ["class"=>"w-100","required"=>true]); ?>
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label ">Heading</label>
                            <div class="col-sm-9">
                                <?=  form_dropdown('account_type', [
                                    199=>'About',
                                    2=>'Login',
                                    3=>'Dashboard and Navigation',
                               
                                    ], '', ["class"=>"w-100"]); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label requiredAsterisk"> Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm" name="title" id="title" required placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label requiredAsterisk"> Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" class="form-control" required cols="30" rows="3"></textarea>
                        
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="row form-group">
                                 
                                    <div class="col-sm-12">
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                            <input id="yes" class="form-check-input"
                                                name="status" checked type="radio"  value="true">
                                            <label for="yes" class="form-check-label">Save defaults only: EXISTING FINANCE COMPANIES ARE NOT AFFECTED</label>
                                        </div>
                                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                            <input id="no" class="form-check-input"
                                                name="status" type="radio"  value="false">
                                            <label for="no" class="form-check-label">Save and Reset existing FINANCE COMPANIES: Save the default coverage types values and apply the default coverage types
                                            values to all existing FINANCE COMPANIES for the coverage types. ALL EXISTING COVERAGE TYPES AND SPECIFIED VALUES FOR
                                            FINANCE COMPANIES WILL BE REPLACED.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                 <button type="button" class=" button-loading btn btn-primary saveCaoverageType">
                                    <span class="button--loading d-none"></span> <span
                                        class="button__text">Submit</span>
                                </button>
                            </div>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>
 </section>

</x-app-layout>

