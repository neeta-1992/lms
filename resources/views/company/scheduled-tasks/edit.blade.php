<x-app-layout>
<section class="font-1 pt-5 hq-full">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                <div class="my-4"></div>
                <form class="validationForm editForm" novalidate method="POST"
                    action="{{ Route::has($route.'update') ? route($route.'update',$id) : '' }}">
                    @csrf
                    @method("put")
                    <input type="hidden" name="logsArr">
                  <div class="tab-one">
                        <div class="form-group row">
                            <label for="task_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.task_name')  </label>
                            <div class="col-sm-9">
                                {!! form_dropdown('task_name', taskName(), '',
                                ["class"=>"w-100","required"=>true,'id'=>'primary_address_state']); !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_time" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.start_time')  </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm timepicker w-25" name="start_time" id="start_time"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="us_time_zone" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.us_time_zone')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('us_time_zone', timeZoneDropDown(), '', ["class"=>"ui dropdown input-sm
                                w-100","required"=>null]) !!}

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="how_often" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.how_often')  </label>
                            <div class="col-sm-9">
                                {!! form_dropdown('how_often', howOften(), '', ["class"=>"ui dropdown input-sm w-100","required"=>null]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-sm-3 col-form-label requiredAsterisk">
                             @lang('labels.start_date')    </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm datepicker w-25" name="start_date" id="primary_telephone"
                                    placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-sm-3 col-form-label ">
                             @lang('labels.end_date')   </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm datepicker w-25" name="end_date" id="primary_telephone"
                                    placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-sm-3 col-form-label requiredAsterisk">
                                @lang('labels.status')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('status',[1=>'Enable',0=>'Disable'], '', ["class"=>"ui dropdown input-sm
                                w-25","required"=>true,'id'=>'status']); !!}
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">@lang('labels.description')</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" cols="30" class="form-control" rows="4"></textarea>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="esignature" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="button" class=" button-loading btn btn-primary nextTab">
                                    <span class="button--loading d-none"></span> <span class="button__text">Submit</span>
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

@push('page_admin_script')
  <script>
    let  editArr = @json($data ?? []);
</script>
@endpush
