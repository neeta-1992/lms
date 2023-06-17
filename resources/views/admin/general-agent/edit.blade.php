<x-app-layout>
<section class="font-1 pt-5 hq-full">
    <div class="container">
        <div class="row justify-content-center" x-data="{ open: 'one' }">
            <div class="col-lg-12">
                <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                <div class="my-4"></div>

                <form class="validationForm editForm" novalidate method="POST" action="{{ routeCheck($route.'update',($id ?? '')) }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="logsArr">
                   <div class="mb-3">
                        <p class="fw-600">General Agent Information</p>
                    </div>
                    
                    <div class="tab-one">
                        <div class="form-group row">
                            <label for="agency_name" class="col-sm-3 col-form-label requiredAsterisk">General Agency Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="agency_name" class="form-control input-sm" id="agency_name" placeholder=""
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="legal_name" class="col-sm-3 col-form-label ">d/b/a (Legal Name if Different Than General Agency
                                Name)</label>
                            <div class="col-sm-9">
                                <input type="text" name='legal_name' class="form-control input-sm username" id="legal_name" placeholder=""
                                    required>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="comp_contact_name" class="col-sm-3 col-form-label ">Entity Type</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('agent_entity_type',['Corporation','Limited Liability Company','Partnership','Sole
                                Proprietor','Other'], [], ["class"=>"ui fluid normal dropdown input-sm"]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fein_ssn" class="col-sm-3 col-form-label ">TIN #</label>
                            <div class="col-sm-9">
                    
                                <input type="text" class="form-control input-sm tin w-25" name="fein_ssn" id="fein_ssn" placeholder="">
                    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_state" class="col-sm-3 col-form-label ">General Agency State Resident</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('license_state', stateDropDown(), [], ["class"=>"ui fluid normal dropdown input-sm"]) !!}
                    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_no" class="col-sm-3 col-form-label ">General Agency State Resident License
                                #</label>
                            <div class="col-sm-9">
                                <input type="text" name="license_no" class="form-control input-sm" id="license_no" placeholder="">
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="licence_expiration_date" class="col-sm-3 col-form-label ">General Agency License Expiration
                                Date</label>
                            <div class="col-sm-9">
                                <input type="text" name="licence_expiration_date" class="form-control input-sm" id="licence_expiration_date"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="agency_email" class="col-sm-3 col-form-label ">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="agency_email" class="form-control input-sm" id="agency_email" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="agencyy_telephone" class="col-sm-3 col-form-label requiredAsterisk">
                                Telephone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm telephone " name="agencyy_telephone" id="primary_telephone"
                                    placeholder="(000) 000-000" required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="physical_address" class="col-sm-3 col-form-label requiredAsterisk">Physical Address</label>
                            <div class="col-sm-9">
                                <div class="form-group row">
                                    <div class="col-md-12 mb-1">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" id="physical_address" placeholder=""
                                                name="physical_address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control input-sm" id="physical_address_city" placeholder=""
                                            name="physical_address_city" required>
                                    </div>
                                    <div class="col-md-4">
                                        <?=  form_dropdown('physical_address_state', stateDropDown(), '', ["class"=>"ui dropdown input-sm w-100","required"=>true,'id'=>'primary_address_state']); ?>
                    
                    
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control input-sm zip_mask" id="physical_address_zip"
                                            name="physical_address_zip" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="mailing_address_yes" class="col-sm-3 col-form-label requiredAsterisk">Dose Mailing Address The Same
                                as Physical Address?</label>
                            <div class="col-sm-9">
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="mailing_address_yes" name="mailing_address_yes" type="radio" required
                                        class="form-check-input" value="true">
                                    <label for="mailing_address_yes" class="form-check-label">Yes</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="mailing_address_no" name="mailing_address_yes" type="radio" required class="form-check-input"
                                        value="false">
                                    <label for="mailing_address_no" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="row form-group">
                    
                                    <div class="col-sm-12">
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                            <input id="yes" class="form-check-input" name="status" checked type="radio" value="yes">
                                            <label for="yes" class="form-check-label">Save defaults only: EXISTING FINANCE COMPANIES ARE NOT
                                                AFFECTED</label>
                                        </div>
                                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                            <input id="no" class="form-check-input" name="status" type="radio" value="no">
                                            <label for="no" class="form-check-label">Save and Reset existing FINANCE COMPANIES: Save the
                                                default coverage types values and apply the default coverage types 
                                                values to all existing FINANCE COMPANIES for the coverage types. ALL EXISTING COVERAGE TYPES
                                                AND PECIFIED VALUES FOR FINANCE COMPANIES WILL BE REPLACED.</label>
                                        </div>
                                    </div>
                                </div>
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



            </div><!-- /.col-*-->
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/.section-->
<!--/.section-->
@push('page_script')
<script>
    let  editArr = @json($data ?? []);
</script>
@endpush
</x-app-layout>

