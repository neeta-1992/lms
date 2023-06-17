<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'Action' }" x-effect="async () => {
                 $('.loadHtml').removeClass('loadHtml');
            }">
                <div class="col-lg-12 page_table_menu">
                    <h4>
                        <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                    </h4>
                    <div class="my-4"></div>
                    <div class="row mb-2 align-items-center ">
                        <div class="col-md-6">
                            <div class="ui selection dropdown table-head-dropdown disabled" >
                                <input type="hidden" /><i class="dropdown icon"></i>
                                <div class="text">{{ dynamicPageTitle('page') ?? '' }}</div>
                                <div class="menu">
                                    <div class="item" @click="open = 'InsuranceCompany'">Insurance Company</div>
                                    <div class="item" @click="open = 'GeneralAgent'">General Agent</div>
                                    <div class="item" @click="open = 'Agent'">Agent</div>
                                    <div class="item" @click="open = 'Insured'">Insured</div>
                                    <div class="item" @click="open = 'Lienholders'">Lienholders</div>
                                    <div class="item" @click="open = 'Brokers'">Brokers</div>
                                    <div class="item" @click="open = 'Vendors'">Vendors</div>
                                    <div class="item" @click="open = 'Salesorganization'">Sales Organization</div>
                                    <div class="item" @click="open = 'FinanceCompany'">Finance Company</div>
                                    <div class="item" @click="open = 'Quotes'">Quotes</div>
                                    <div class="item" @click="open = 'Payment'">Payment</div>
                                    <div class="item" @click="open = 'Account'">Account</div>
                                    <div class="item" @click="open = 'Notice'">Notice</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="row align-items-end" x-show="open != 'Action'">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end" >
                                        <button class="btn btn-default" type="button"  @click="open = 'Action'"> @lang('text.exit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive-sm" x-show="open == 'Action'">
                        <table id="mainName"   data-toggle="table" >
                            <thead>
                                <tr>
                                    <th  data-field="name" >@lang('labels.name')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td > <span @click="open = 'FinanceCompany'" class="cursor-pointer"> @lang('labels.finance_company')</span></td>
                                   
                                </tr>
                                <tr>
                                   <td > <span @click="open = 'InsuranceCompany'" class="cursor-pointer"> @lang('labels.insurance_company')</span></td>
                                </tr>
                                <tr>
                                 <td > <span @click="open = 'GeneralAgent'" class="cursor-pointer">   @lang('labels.general_agent')</span></td>
                                </tr>
                                <tr>
                                      <td > <span @click="open = 'Agent'" class="cursor-pointer">@lang('labels.agent')</span></td>
                                </tr>
                                <tr>
                                     <td > <span @click="open = 'Insured'" class="cursor-pointer">  @lang('labels.insured')</span></td>
                                </tr>
                                <tr>
                                     <td > <span @click="open = 'Salesorganization'" class="cursor-pointer">  @lang('labels.sales_organization')</span></td>
                                </tr>
                                <tr>
                                     <td > <span @click="open = 'Brokers'" class="cursor-pointer">  @lang('labels.broker')</span></td>
                                </tr>
                                <tr>
                                       <td > <span @click="open = 'Lienholders'" class="cursor-pointer"> @lang('labels.lienholder')</span></td>
                                </tr>
                               
                                <tr>
                                      <td > <span @click="open = 'Quotes'" class="cursor-pointer"> @lang('labels.quote')</span></td>
                                </tr>
                                <tr>
                                     <td > <span @click="open = 'Account'" class="cursor-pointer"> @lang('labels.account')</span></td>
                                </tr>
                                <tr>
                                     <td > <span @click="open = 'Payment'" class="cursor-pointer"> @lang('labels.payments')</span></td>
                                </tr>
                                <tr>
                                    <td > <span @click="open = 'Notice'" class="cursor-pointer"> @lang('labels.notices')</span></td>
                                </tr>
                                <tr>
                                    <td > <span @click="open = 'Vendors'" class="cursor-pointer">  @lang('labels.vendors')</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div x-show="open == 'InsuranceCompany'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Insurance_Companycode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Ic_Name}</span></td>
                                        <td>Insurance company name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_Agg_Limit}</span>
                                        </td>
                                        <td>Insurance company aggregate limit</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_FEIN}</span>
                                        </td>
                                        <td>Insurance company FEIN</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {IC_Agg_Limit_Outstandings}</span></td>
                                        <td>Insurance company limit of aggregate outstandings</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_M_Adress}</span>
                                        </td>
                                        <td>Insurance company address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_M_City}</span>
                                        </td>
                                        <td>Insurance company city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_M_State}</span>
                                        </td>
                                        <td>Insurance company state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_M_Zip}</span>
                                        </td>
                                        <td>Insurance company zip</td>
                                    </tr>
                                    {{-- <tr>
                                        <td><span
                                                class="badge  p-2 badge-shortcode fw-500">{Insurance_Company_Domiciliary_Address}</span>
                                        </td>
                                        <td>Insurance company domiciliary address</td>
                                    </tr>
                                    <tr>
                                        <td><span
                                                class="badge  p-2 badge-shortcode fw-500">{Insurance_Company_Domiciliary_City}</span>
                                        </td>
                                        <td>Insurance company domiciliary city</td>
                                    </tr>
                                    <tr>
                                        <td><span
                                                class="badge  p-2 badge-shortcode fw-500">{IC_Domiciliary_State}</span>
                                        </td>
                                        <td>Insurance company domiciliary state</td>
                                    </tr>
                                    <tr>
                                        <td><span
                                                class="badge  p-2 badge-shortcode fw-500">{Insurance_Company_Domiciliary_Zip}</span>
                                        </td>
                                        <td>Insurance company domiciliary zip</td>
                                    </tr> --}}
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_Telephone}</span>
                                        </td>
                                        <td>Insurance company telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_Fax}</span>
                                        </td>
                                        <td>Insurance company fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_Web}</span>
                                        </td>
                                        <td>Insurance company website</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IC_Notes}</span>
                                        </td>
                                        <td>Insurance company notes</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'GeneralAgent'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="General_Agentcode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name
                                        </th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Name}</span>
                                        </td>
                                        <td>General agent name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Aggregate_Limit}</span>
                                        </td>
                                        <td>General agent aggregate limit</td>
                                    </tr>
                                    {{-- <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{General_Agent_DBA}</span>
                                        </td>
                                        <td>General agent d/b/a</td>
                                    </tr> --}}
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Entity_Type}</span>
                                        </td>
                                        <td>General agent entity type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_TIN}</span>
                                        </td>
                                        <td>General agent TIN</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_State_Resident}</span>
                                        </td>
                                        <td>General agent state resident</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_License}</span>
                                        </td>
                                        <td>General agent state resident license</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_License_Epeiration_Date}</span>
                                        </td>
                                        <td>General agent license expiration date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Email}</span>
                                        </td>
                                        <td>General agent email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Fax}</span>
                                        </td>
                                        <td>General agent fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Telephone}</span>
                                        </td>
                                        <td>General agent telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_Web}</span>
                                        </td>
                                        <td>General agent website</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_P_Address}</span>
                                        </td>
                                        <td>General agent address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_P_City}</span>
                                        </td>
                                        <td>General agent city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_P_State}</span>
                                        </td>
                                        <td>General agent state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_P_Zip}</span>
                                        </td>
                                        <td>General agent zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_M_Aadress}</span>
                                        </td>
                                        <td>General agent mailing address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_M_City}</span>
                                        </td>
                                        <td>General agent mailing city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_M_State}</span>
                                        </td>
                                        <td>General agent mailing state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_M_Zip}</span>
                                        </td>
                                        <td>General agent mailing zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{General_Agent_Office_Name}</span>
                                        </td>
                                        <td>General agent office name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_O_Aadress}</span>
                                        </td>
                                        <td>General agent office address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_O_City}</span>
                                        </td>
                                        <td>General agent office city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_O_State}</span>
                                        </td>
                                        <td>General agent office state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{GA_O_Zip}</span>
                                        </td>
                                        <td>General agent office zip</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Agent'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Agentcode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Full_Name}</span>
                                        </td>
                                        <td>Agent full name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_First_Name}</span>
                                        </td>
                                        <td>Agent first name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Middle_Name}</span>
                                        </td>
                                        <td>Agent middle name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Last_Name}</span>
                                        </td>
                                        <td>Agent last name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Title}</span></td>
                                        <td>Agent title</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_DOB}</span></td>
                                        <td>Agent DOB</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Email}</span></td>
                                        <td>Agent email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {AG_Primary_Telephone}</span></td>
                                        <td>Agent primary telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {AG_Alternate_Telephone}</span></td>
                                        <td>Agent alternate telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Agency_Name}</span>
                                        </td>
                                        <td>Agent agency name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Aggregate_Limit}</span>
                                        </td>
                                        <td>Agent aggregate limit</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_DBA}</span></td>
                                        <td>Agent d/b/a</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Entity_Type}</span>
                                        </td>
                                        <td>Agent entity type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_TIN}</span></td>
                                        <td>Agent TIN #</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_State_Resident}</span>
                                        </td>
                                        <td>Agent state resident</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_State_Resident_License}</span>
                                        </td>
                                        <td>Agent state resident license</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_License_Expiration_Date}</span>
                                        </td>
                                        <td>Agent license expiration date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {AG_Non_Resident_Insurance_License}</span></td>
                                        <td>Agent non-resident insurance license</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Year_Established}</span>
                                        </td>
                                        <td>Agent year established</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Telephone}</span>
                                        </td>
                                        <td>Agent telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Fax}</span></td>
                                        <td>Agent fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Agency_Email}</span></td>
                                        <td>Agent agency email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Website}</span></td>
                                        <td>Agent website</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Address}</span></td>
                                        <td>Agent address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_City}</span></td>
                                        <td>Agent city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_State}</span></td>
                                        <td>Agent state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Zip}</span></td>
                                        <td>Agent zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Mailing_Address}</span>
                                        </td>
                                        <td>Agent mailing address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Mailing_City}</span>
                                        </td>
                                        <td>Agent mailing city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Mailing_State}</span>
                                        </td>
                                        <td>Agent mailing state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Mailing_Zip}</span>
                                        </td>
                                        <td>Agent mailing zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Comments}</span>
                                        </td>
                                        <td>Agent comments or questions</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Insured'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Insuredcode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Full_Name}</span>
                                        </td>
                                        <td>Insured full name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_First_Name}</span>
                                        </td>
                                        <td>Insured first name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_M_Name}</span>
                                        </td>
                                        <td>Insured middle name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Last_Name}</span>
                                        </td>
                                        <td>Insured last name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Title}</span></td>
                                        <td>Insured title</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_DOB}</span></td>
                                        <td>Insured DOB</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Email}</span></td>
                                        <td>Insured user email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {IN_P_Telephone}</span></td>
                                        <td>Insured primary telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {IN_A_Telephone}</span></td>
                                        <td>Insured alternate telephone</td>
                                    </tr>
                                    <!--tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">
                        {InsuredFax}</span></td>
                        <td>Insured user Fax</td>
                        </tr-->
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Name}</span></td>
                                        <td>Insured name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Telephone}</span>
                                        </td>
                                        <td>Insured telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Fax}</span></td>
                                        <td>Insured fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Email}</span></td>
                                        <td>Insured email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Entity_Type}</span>
                                        </td>
                                        <td>Insured Type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Entity_Name}</span>
                                        </td>
                                        <td>Entity Name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_DBA}</span></td>
                                        <td>Insured d/b/a</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_TIN}</span></td>
                                        <td>Insured TIN</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_P_Address}</span>
                                        </td>
                                        <td>Insured address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_P_City}</span></td>
                                        <td>Insured city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_P_State}</span></td>
                                        <td>Insured state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_P_Zip}</span></td>
                                        <td>Insured zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_M_Address}</span>
                                        </td>
                                        <td>Insured mailing address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_M_City}</span>
                                        </td>
                                        <td>Insured mailing city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_M_State}</span>
                                        </td>
                                        <td>Insured mailing state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_M_Zip}</span>
                                        </td>
                                        <td>Insured mailing zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Decline_Reinstatement_Payment_Cancellation}</span>
                                        </td>
                                        <td>Insured decline reinstatement if payment received after cancellation</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Years_Business}</span>
                                        </td>
                                        <td>Insured years in business</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_NAICS_Code}</span>
                                        </td>
                                        <td>Insured NAICS Code</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_DUNS}</span></td>
                                        <td>Insured DUNS</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_DB_Confidence_Code}</span>
                                        </td>
                                        <td>Insured D&B Confidence Code</td>
                                    </tr>

                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Notes}</span></td>
                                        <td>Insured notes</td>
                                    </tr>

                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Open_Balance}</span>
                                        </td>
                                        <td>Insured Open Balance</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Lienholders'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Lienholderscode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{LH_Name}</span>
                                        </td>
                                        <td>Lienholder name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Lienholder_Tax_ID}</span>
                                        </td>
                                        <td>Lienholder tax ID</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Lienholder_Address}</span>
                                        </td>
                                        <td>Lienholder address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Lienholder_City}</span>
                                        </td>
                                        <td>Lienholder city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Lienholder_State}</span>
                                        </td>
                                        <td>Lienholder state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Lienholder_Zip}</span>
                                        </td>
                                        <td>Lienholder zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{LH_M_Address}</span>
                                        </td>
                                        <td>Lienholder mailing address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{LH_M_City}</span>
                                        </td>
                                        <td>Lienholder mailing city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{LH_M_State}</span>
                                        </td>
                                        <td>Lienholder mailing state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{LH_M_Zip}</span>
                                        </td>
                                        <td>Lienholder mailing zip</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Brokers'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Brokerscode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{BR_Name}</span></td>
                                        <td>Broker name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{BR_DBA}</span></td>
                                        <td>Broker d/b/a</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Entity_Type}</span>
                                        </td>
                                        <td>Broker entity type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_TIN}</span></td>
                                        <td>Broker TIN #</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_State_Resident}</span>
                                        </td>
                                        <td>Broker state resident</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_State_Resident_License}</span>
                                        </td>
                                        <td>Broker state resident license</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_License_Expiration_Date}</span>
                                        </td>
                                        <td>Broker license expiration date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Telephone}</span>
                                        </td>
                                        <td>Broker telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Fax}</span></td>
                                        <td>Broker fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Website}</span>
                                        </td>
                                        <td>Broker website</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Address}</span>
                                        </td>
                                        <td>Broker address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_City}</span></td>
                                        <td>Broker city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_State}</span></td>
                                        <td>Broker state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Zip}</span></td>
                                        <td>Broker zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{BR_M_Address}</span>
                                        </td>
                                        <td>Broker mailing address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{BR_M_City}</span>
                                        </td>
                                        <td>Broker mailing city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{BR_M_State}</span>
                                        </td>
                                        <td>Broker mailing state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{BR_M_Zip}</span>
                                        </td>
                                        <td>Broker mailing zip</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Vendors'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Vendorscode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Name}</span></td>
                                        <td>Vendor name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_DBA}</span></td>
                                        <td>Vendor d/b/a</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Entity_Type}</span>
                                        </td>
                                        <td>Vendor entity type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_TIN}</span></td>
                                        <td>Vendor TIN #</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Telephone}</span>
                                        </td>
                                        <td>Vendor telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Fax}</span></td>
                                        <td>Vendor fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Email}</span></td>
                                        <td>Vendor email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Address}</span>
                                        </td>
                                        <td>Vendor address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_City}</span></td>
                                        <td>Vendor city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_State}</span></td>
                                        <td>Vendor state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Zip}</span></td>
                                        <td>Vendor zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Mailing_Address}</span>
                                        </td>
                                        <td>Vendor address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Mailing_City}</span>
                                        </td>
                                        <td>Vendor city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Mailing_State}</span>
                                        </td>
                                        <td>Vendor state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Vendor_Mailing_Zip}</span>
                                        </td>
                                        <td>Vendor zip</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Salesorganization'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Sales_organizationcode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_Organization_Full_Name}</span>
                                        </td>
                                        <td>Sales organization full name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_Organization_First_Name}</span>
                                        </td>
                                        <td>Sales organization first name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_Organization_Middle_Name}</span>
                                        </td>
                                        <td>Sales organization middle name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_Organization_Last_Name}</span>
                                        </td>
                                        <td>Sales organization last name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_Organization_Title}</span>
                                        </td>
                                        <td>Sales organization title</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_Organization_DOB}</span>
                                        </td>
                                        <td>Sales organization DOB</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Sales_OrganizationEmail}</span>
                                        </td>
                                        <td>Sales organization user email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Sales_Organization_Primary_Telephone}</span></td>
                                        <td>Sales organization primary telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Sales_Organization_Alternate_Telephone}</span></td>
                                        <td>Sales organization alternate telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_Name}</span>
                                        </td>
                                        <td>Sales organization name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_DBA}</span>
                                        </td>
                                        <td>Sales organization d/b/a</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SOE_Type}</span>
                                        </td>
                                        <td>Sales organization entity type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_TIN}</span>
                                        </td>
                                        <td>Sales organization TIN #</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_Telephone}</span>
                                        </td>
                                        <td>Sales organization telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_Fax}</span>
                                        </td>
                                        <td>Sales organization fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_Email}</span>
                                        </td>
                                        <td>Sales organization email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_P_Addrerss}</span>
                                        </td>
                                        <td>Sales organization address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_P_City}</span>
                                        </td>
                                        <td>Sales organization city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_P_State}</span>
                                        </td>
                                        <td>Sales organization state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_P_Zip}</span>
                                        </td>
                                        <td>Sales organization zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_M_Address}</span>
                                        </td>
                                        <td>Sales organization mailing address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_M_City}</span>
                                        </td>
                                        <td>Sales organization mailing city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_M_State}</span>
                                        </td>
                                        <td>Sales organization mailing state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SO_M_Zip}</span>
                                        </td>
                                        <td>Sales organization mailing zip</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'FinanceCompany'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Finance_Companycode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_Name}</span></td>
                                        <td>Company name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_P_Address}</span></td>
                                        <td>Company address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_P_City}</span></td>
                                        <td>Company city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_P_State}</span></td>
                                        <td>Company state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_P_Zip}</span></td>
                                        <td>Company zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_P_Telephone}</span>
                                        </td>
                                        <td>Company telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_A_Telephone}</span>
                                        </td>
                                        <td>Company alternate telephone</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_Fax_1}</span></td>
                                        <td>Company fax</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PF_Contact_Name}</span></td>
                                        <td>Company contact name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_P_Email}</span>
                                        </td>
                                        <td>Company email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PF_Office_Location}</span></td>
                                        <td>Company Office location</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PF_Licenses}</span></td>
                                        <td>Company licenses #</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PF_State_Licenses}</span></td>
                                        <td>Company state licensed</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_Web}</span>
                                        </td>
                                        <td>Company web address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_Logo_URl}</span>
                                        </td>
                                        <td>Company logo</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PF_Privacy_Page_URL}</span></td>
                                        <td>Company privacy page URL</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_PCIS_Address}</span>
                                        </td>
                                        <td>Company telephonePayment coupons/invoices/statement address</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_PCIS_City}</span>
                                        </td>
                                        <td>Payment coupons/invoices/statement city</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_PCIS_State}</span>
                                        </td>
                                        <td>Payment coupons/invoices/statement state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PF_PCIS_Zip}</span>
                                        </td>
                                        <td>Payment coupons/invoices/statement zip</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PFCF_P_Email}</span></td>
                                        <td>Company from fax email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PFCSE_P_Domain}</span></td>
                                        <td>Company server email address domain</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {PFCFS_P_Name}</span></td>
                                        <td>Company fax server domain name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_Signed_agreement_Fax_1}</span></td>
                                        <td>Company Signed agreement fax 1 </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_Signed_agreement_Fax_2}</span></td>
                                        <td>Company Signed agreement fax 2 </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_Entity_Fax_Numbers_1}</span></td>
                                        <td>Company Entity fax numbers 1</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_Entity_Fax_Numbers_2}</span></td>
                                        <td>Company Entity fax numbers 2</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_Forward_Incoming_Faxes}</span></td>
                                        <td>Company forward incoming faxes</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_CAN_SPAM_Notice}</span></td>
                                        <td>Company CAN-SPAM notice</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Premium_Finance_Company_Copyright_Notice}</span></td>
                                        <td>Company copy right notice</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Finance_Company_Fullname}</span></td>
                                        <td>Finance Company user full name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Finance_Company_Firstname}</span></td>
                                        <td>Finance Company user first name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Finance_Company_Middlename}</span></td>
                                        <td>Finance Company user middle name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Finance_Company_Lastname}</span></td>
                                        <td>Finance Company user last name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Finance_Company_Email}</span></td>
                                        <td>Finance Company user email</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Finance_Company_Primary_Telephone}</span></td>
                                        <td>Finance Company user primary telephone</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Quotes'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Quotescode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2"><b>Quotes</b></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Number}</span></td>
                                        <td>Quote number</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{IN_Name}</span></td>
                                        <td>Insured name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{AG_Name}</span></td>
                                        <td>Agent name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Org_Stae}</span>
                                        </td>
                                        <td>Origination state</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Insured_Existing_Balance}</span>
                                        </td>
                                        <td>Insured existing balance</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Type}</span></td>
                                        <td>Quote type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Payment_Method}</span>
                                        </td>
                                        <td>Payment method</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_LOB}</span>
                                        </td>
                                        <td>Line of business</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Email_Notification}</span>
                                        </td>
                                        <td>Email notification</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Term</b></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Ver_Num}</span>
                                        </td>
                                        <td>Version quote number</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Late_Charge}</span></td>
                                        <td>Late charge</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Payment_Late_Charge}</span></td>
                                        <td>Payment with late charge</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Installment_Number}</span>
                                        </td>
                                        <td>Payment installment number</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Installment_Due_Date}</span>
                                        </td>
                                        <td>Payment Installment due date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Late_Charge_Installment_Due_Date}</span>
                                        </td>
                                        <td>Payment Installment late charge due date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Billing_Schedule}</span>
                                        </td>
                                        <td>Billing schedule</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_No_Of_Payments}</span>
                                        </td>
                                        <td>Number of paymants</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Down_Payment}</span>
                                        </td>
                                        <td>Total down payment </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Setup_Fee_Down_Payment}</span>
                                        </td>
                                        <td>Setup fee in down payment</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Q_Inception_Date}</span>
                                        </td>
                                        <td>Inception date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{First_Payment_Due_Date}</span>
                                        </td>
                                        <td>First payment due date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Interest_Rate}</span></td>
                                        <td>Interest rate</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Total_Setup_Fee}</span>
                                        </td>
                                        <td>Total setup fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Monthly_Due_Date}</span>
                                        </td>
                                        <td>Monthly due date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Amount}</span>
                                        </td>
                                        <td>Payment amount</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Effective_APR}</span></td>
                                        <td>Effective APR</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Amount_Financed}</span>
                                        </td>
                                        <td>Amount financed</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Premium_Financed}</span>
                                        </td>
                                        <td>Premium financed</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Doc_Stamp_Fees}</span>
                                        </td>
                                        <td>Doc. stamp fees</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Finance_Charge}</span>
                                        </td>
                                        <td>Financed charge</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Interest}</span></td>
                                        <td>Interest</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Setup_Fee_Unpaid}</span>
                                        </td>
                                        <td>Setup fee(unpaid)</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Total_Payments}</span>
                                        </td>
                                        <td>Total of payments</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Agent_Compensation}</span>
                                        </td>
                                        <td>Agent compensation</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Total_Pure_Premium}</span>
                                        </td>
                                        <td>Total pure premium</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Total_Premium}</span></td>
                                        <td>Total premium</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Policy</b></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Insurance_Company}</span>
                                        </td>
                                        <td>Insurance company</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{General_Agent}</span></td>
                                        <td>General agent</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker}</span></td>
                                        <td>Broker</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Policy_Number}</span></td>
                                        <td>Policy number</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Coverage_Type}</span></td>
                                        <td>Coverage type</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Pure_Premium}</span></td>
                                        <td>Pure premium</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Minimum_Earned_Premium}</span>
                                        </td>
                                        <td>Minimum earned premium %</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancel_Term}</span></td>
                                        <td>Cancel term in days</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Short_Rate}</span></td>
                                        <td>Short rate</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Auditable}</span></td>
                                        <td>Auditable</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Notes}</span></td>
                                        <td>Notes</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Inception_Date}</span>
                                        </td>
                                        <td>Inception date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Policy_Term}</span></td>
                                        <td>Policy term</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Expiration_Date}</span>
                                        </td>
                                        <td>Expiration date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{First_Installment_Date}</span>
                                        </td>
                                        <td>First installment date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Policy_Fee}</span></td>
                                        <td>Policy fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Taxes_Stamp_Fees}</span>
                                        </td>
                                        <td>Taxes & Stamp fees</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Broker_Fee}</span></td>
                                        <td>Broker fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Inspection_Fee}</span>
                                        </td>
                                        <td>Inspection fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PUC_Filings}</span></td>
                                        <td>PUC/Filings</td>
                                    </tr>
                                    <!--tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Monthly_Installment_Amount}</span></td>
                        <td>Monthly installment amount</td>
                        </tr>

                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancellation_Terms_Days}</span></td>
                        <td>Cancel term in days in first policy</td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Policy_Auditable}</span></td>
                        <td>Auditable in first policy</td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Policy_Subject_Short_Rate}</span></td>
                        <td>Short rate in first policy</td>
                        </tr>

                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Policy_Effective_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Due_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Installment_Amount}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Installment_Due}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Installment_Number}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Installments_Paid}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Processing_Fee}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Late_Fee}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Late_Charge}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancellation_Fee}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{NSF_Fee}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Late_Charges_Fees}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancel_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Due_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Effective_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Office_Date}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Premium_Fully_Earned}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Annual_Percentage_Rate}</span></td>
                        <td></td>
                        </tr>
                        <tr>
                        <td><span class="badge  p-2 badge-shortcode fw-500">{Gross_Premium}</span></td>
                        <td></td>
                        </tr-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Payment'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Paymentcode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{PayTo_Name}</span></td>
                                        <td>Vendor, Insurance company, General agent, Agent, Insured, Broker,
                                            Lienholder, sales organization name
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{CheckAmount}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{ToName}</span></td>
                                        <td>Vendor, Insurance company, General agent, Agent, Insured, Broker,
                                            Lienholder, sales organization name
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{To_Address}</span></td>
                                        <td>Vendor, Insurance company, General agent, Agent, Insured, Broker,
                                            Lienholder, sales organization address
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{To_City}</span></td>
                                        <td>Vendor, Insurance company, General agent, Agent, Insured, Broker,
                                            Lienholder, sales organization city
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{To_State}</span></td>
                                        <td>Vendor, Insurance company, General agent, Agent, Insured, Broker,
                                            Lienholder, sales organization state
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{To_Zip}</span></td>
                                        <td>Vendor, Insurance company, General agent, Agent, Insured, Broker,
                                            Lienholder, sales organization zip
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Fees}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payoff_Amount}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Pay_Phone}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Pay_Online}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Address}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Due_Date}</span>
                                        </td>
                                        <td>Payment Due Date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Total_Amount_Due}</span>
                                        </td>
                                        <td>Total Amount Due</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Amount_Made}</span>
                                        </td>
                                        <td>Payment Amount Made</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Date}</span></td>
                                        <td>Payment Date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Payment_Date_Time}</span>
                                        </td>
                                        <td>Payment Date Time</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Installment_Amount}</span>
                                        </td>
                                        <td>Installment Amount</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Installment_Number}</span>
                                        </td>
                                        <td>Installment Number</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Processing_Fee}</span>
                                        </td>
                                        <td>Processing Fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Late_Fee}</span></td>
                                        <td>Late Fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancellation_Fee}</span>
                                        </td>
                                        <td>Cancellation Fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{NSF_Fee}</span></td>
                                        <td>NSF Fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Convenience_Fee}</span>
                                        </td>
                                        <td>Convenience Fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Stop_Payment_Fee}</span>
                                        </td>
                                        <td>Stop Payment Fee</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancel_Days}</span></td>
                                        <td>Cancel Days</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancel_Date}</span></td>
                                        <td>Cancel Date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{All_Fees}</span></td>
                                        <td>All Fees</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Cancellation_Reason}</span>
                                        </td>
                                        <td>Cancellation Reason</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Account_Balance_Cancellation}</span>
                                        </td>
                                        <td>Account Balance Cancellation</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Next_Installment_Including_Shortage}</span>
                                        </td>
                                        <td>Next Installment Including Shortage</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Shortage_Amount}</span>
                                        </td>
                                        <td>Shortage Amount</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Next_Installment_excluding_Shortage}</span>
                                        </td>
                                        <td>Next Installment Excluding Shortage</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Less_Return_Premium_Received}</span></td>
                                        <td>Less Return Premium Received</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Agent_Return_Commission_Due}</span></td>
                                        <td>Agent Return Commission Due</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">
                                                {Insured_Return_Premium_Amount}</span></td>
                                        <td>Insured Return Premium Amount</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Account'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Accountcode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{A_Number}</span>
                                        </td>
                                        <td>Account number</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{A_Intent_To_Cancel_Date}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{A_Cancel_Date}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{A_Current_Balance}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div x-show="open == 'Notice'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="Noticecode" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{NO_Created_Date}</span>
                                        </td>
                                        <td>Today's Date</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{NO_Created_Date_Time}</span>
                                        </td>
                                        <td>Today's Date and Time</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Reason_Text}</span></td>
                                        <td>Description in notice</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{Send_bymmddyyyyHHMM}</span>
                                        </td>
                                        <td>The send by method date and time</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{NO_Last_Updated_Date_Time}</span>
                                        </td>
                                        <td>Notice last updated date and time</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{NO_ID}</span></td>
                                        <td>Notice Id</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div x-show="open == 'SalesExcutive'" class="loadHtml">
                        <div class="table-responsive-sm">
                            <table id="sales_excutive" data-loading-template="loadingTemplate" data-show-header="true" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th class="" data-field="Name" data-width="300">Name</th>
                                        <th class="" data-field="Description" data-width="700">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_Full_Name}</span>
                                        </td>
                                        <td>Sales Organization Full Name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_First_Name}</span>
                                        </td>
                                        <td>Sales Organization First Name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_Middle_Name}</span>
                                        </td>
                                        <td>Sales Organization Middle Name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_Last_Name}</span>
                                        </td>
                                        <td> Sales Organization Last Name</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_Title}</span>
                                        </td>
                                        <td>Sales Organization Title</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_DOB}</span></td>
                                        <td>Sales Organization DOB</td>
                                    </tr>

                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_Email}</span></td>
                                        <td>Sales OrganizationEmail</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_P_Telephone}</span>
                                        </td>
                                        <td>Sales Organization Primary Telephone</td>
                                    </tr>

                                    <tr>
                                        <td><span class="badge  p-2 badge-shortcode fw-500">{SE_A_Telephone}</span>
                                        </td>
                                        <td>Sales Organization Alternate Telephone</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
