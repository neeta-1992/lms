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
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.compensation_table_name')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm" name="name" id="name" required
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status') </label>
                            <div class="col-sm-9">
                                {!! form_dropdown('status', ['1'=>'Enable','0'=>'Disable'], '', ["class"=>"w-100","required"=>true]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.compensation') </label>
                            <div class="col-sm-9">
                               {!!  form_dropdown('compensation',['Agent compensation'=>'Agent compensation','Sales executive compensation'=>'Sales executive compensation','General agent compensation'=>'General agent compensation'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">@lang('labels.description') </label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" cols="30" class="form-control"
                                    rows="3"></textarea>
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

