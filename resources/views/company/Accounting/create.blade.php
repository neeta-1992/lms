 <x-app-layout>
     <section class="font-1 pt-5 hq-full">
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-lg-12">
                     <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                     <div class="my-4"></div>
                     <form class="validationForm" novalidate method="POST" action="{{ Route::has($route.'store') ? route($route.'store') : '' }}">
                         @csrf
                         <div class="tab-one" x-show="open == 'one'">
                             <div class="row">
                                 <label for="tin_select" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                                 <div class="col-sm-9">
                                     <div class="form-group row">
                                         <div class="col-sm-6">
                                             <select class="ui dropdown input-sm w-100" name='tin_select'>
                                                 <option value=""></option>
                                                 <option value="Enable">Enable </option>
                                                 <option value="Disable">Disable</option>
                                             </select>
                                         </div>
                                     </div>

                                 </div>
                             </div>

                             <div class="row">
                                 <label for="tin_select" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.bank_name')</label>
                                 <div class="col-sm-9">
                                     <div class="form-group row">
                                         <div class="col-sm-6">
                                             <input type="text" class="form-control input-sm  " name="alternate_telephone" id="alternate_telephone" placeholder="">
                                         </div>
                                     </div>

                                 </div>
                             </div>

                             <div class="row">
                                 <label for="tin_select" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.account_number')</label>
                                 <div class="col-sm-9">
                                     <div class="form-group row">
                                         <div class="col-sm-6">
                                             <input type="text" class="form-control input-sm  " name="alternate_telephone" id="alternate_telephone" placeholder="">
                                         </div>
                                     </div>

                                 </div>
                             </div>
                             <div class="row">
                                 <label for="tin_select" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.gl_account')</label>
                                 <div class="col-sm-9">
                                     <div class="form-group row">
                                         <div class="col-sm-6">
                                             <select class="ui dropdown input-sm w-100" name='tin_select'>
                                                 <option value=""></option>
                                                 <option value="Enable">Enable </option>
                                                 <option value="Disable">Disable</option>
                                             </select>
                                         </div>
                                     </div>

                                 </div>
                             </div>

                             <div class="form-group row">
                                 <div class="col-sm-3"></div>
                                 <div class="col-sm-9">
                                     <button type="button" class=" button-loading btn btn-primary saveCaoverageType">
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
