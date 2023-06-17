<x-app-layout>
<section class="font-1 pt-5 hq-full">
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-lg-12">
                <h4 >{{ dynamicPageTitle('page') ?? '' }}</h4>
                <div class="my-4"></div>
                <form class="validationForm" novalidate method="POST" action="{{ Route::has($route.'store') ? route($route.'store') : '' }}">
                    @csrf
                    <div class="tab-one"  x-show="open == 'one'">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Coverage name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm" name="name" id="name" required
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Account type</label>
                            <div class="col-sm-9">
                                <?=  form_dropdown('account_type', ['all'=>'All','commercial'=>'Commercial','personal'=>'Personal'], '', ["class"=>"w-100","required"=>true]); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Active</label>
                            <div class="col-sm-9">
                                <?=  form_dropdown('account_active',['yes'=>'Yes','no'=>'No'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Cancel terms</label>
                            <div class="col-sm-9">
                                <?=  form_dropdown('cancel_terms',['0'=>'No Value Selected','10'=>'10 Days','20'=>'20 Days','30'=>'30 Days','45'=>'45 Days'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]); ?>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
 </section>

</x-app-layout>

