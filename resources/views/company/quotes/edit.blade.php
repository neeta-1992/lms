<x-app-layout :class="['dateDropdown', 'datepicker', 'inMail', 'quill', 'emoji']">
    @php
        $disabled = '';
        $model = App\Models\Quote::class;
        $userModel = App\Models\User::class;
        $quoteStatus = !empty($data->status) ? $data->status : '';
        $deleted = $quoteStatus == $model::DELETE ? true : false;
        if ($quoteStatus >= 2) {
            $disabled = 'disabled';
        }
        $quoteInformationEditTable = true;
        if ($quoteStatus >= 2) {
            $quoteInformationEditTable = false;
        }
        $approveQuoteEdit = false;
        if ($quoteStatus >= $model::APPROVE) {
            $approveQuoteEdit = true;
        }

    @endphp
    <section class="font-1 pt-5 hq-full" x-data="quotesEdit" x-effect="quotesEditEffect"
        data-ajax-url="{{ routeCheck($route . 'index') }}">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                            Quotes {{ '#' }} <span class="quoteId">{{ $data?->qid ?? '' }}</span>.<span
                                class="quoteVersion" x-text="version"></span>
                        </x-slot>
                        <x-slot name="badge">
                            @switch($quoteStatus)
                                @case($model::NEW)
                                    @lang('labels.new')
                                @break

                                @case($model::ACTIVEREQUEST)
                                    @lang('Activation requested')
                                @break

                                @case($model::PROCESS)
                                    @lang('Process')
                                @break

                                @case($model::APPROVE)
                                    @lang('labels.approved')
                                @break

                                @case($model::DECLINE)
                                    @lang('labels.decline')
                                @break

                                @case($model::DELETE)
                                    @lang('labels.delete')
                                @break

                                @case($model::FINALAPPROVAL)
                                    @lang('labels.final_approval')
                                @break

                                @default
                            @endswitch
                        </x-slot>
                    </x-jet-section-title>
                </div>

                {{--   quotes alert --}}
                @includeIf('company.quotes.alert', ['data' => $data, 'userModel' => $userModel])
                {{--  end quotes alert --}}
                <div class="col-md-12 page_table_menu">
                    @includeIf('company.quotes.menu', [
                        'isRequestActive' => $isRequestActive,
                        'pageType' => $pageType,
                        'deleted' => $deleted,
                        'model' => $model,
                    ])
                </div>



                <div class="quote_information_box_section w-100"
                    x-show="(open == 'quote_information' || open == 'policies' ||  open == 'terms' ||  open == 'addPolicy'||  open == 'newVersion')">
                    <div class="col-md-12">
                        <x-form spoofMethod="put"
                            class="validationForm  editForm mainForm {{ $quoteInformationEditTable != true ? 'disabled' : '' }}"
                            action="{{ routeCheck($route . 'update', $id) }}">
                            <input type="hidden" name="logsArr">
                            @method('put')
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.insured')
                                    @lang('labels.name')</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="insuredhidden" value="{{ $data->insured ?? '' }}">
                                    <div class="div-input fw-600"><a
                                            href="{{ routeCheck('company.insureds.edit', ['insured' => encryptUrl($data->insur_data->id)]) }}"
                                            class="linkButton">{{ $data->insur_data->name ?? '' }}</a></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.agent')
                                    @lang('labels.name')</label>
                                <div class="col-sm-9">
                                    <div class="div-input fw-600"><a
                                            href="{{ routeCheck('company.agents.edit', ['agent' => encryptUrl($data->agency_data->id)]) }}"
                                            class="linkButton">{{ $data->agency_data->name ?? '' }}</a></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email_notification')</label>
                                <div class="col-sm-9">
                                    <x-select :options="emailNotificationDropDown()" name="email_notification"
                                        class="ui dropdown {{ $disabled ?? '' }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.rate_table')</label>
                                <div class="col-sm-9">
                                    <x-select :options="$ratetables ?? []" name="rate_table"
                                        class="ui dropdown {{ $disabled ?? '' }}" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="origination_state"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.origination_state')</label>
                                <div class="col-sm-9">
                                    <x-input-radio inline label="{{ __('labels.physical_risk_address_insured') }}"
                                        id="origination_state_insured_physical" name="origination_state"
                                        value="insured_physical" :disabled="!empty($disabled) ? true : false" />
                                    <x-input-radio inline label="{{ __('labels.mailing_address_insured') }}"
                                        id="origination_state_insured_mailing" name="origination_state"
                                        value="insured_mailing" :disabled="!empty($disabled) ? true : false" />
                                    <x-input-radio inline label="{{ __('labels.agent') }}" id="origination_state_agent"
                                        name="origination_state" value="agent" :disabled="!empty($disabled) ? true : false" />


                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="email"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.line_of_business')</label>
                                <div class="col-sm-9 account_type">
                                    <x-input-radio inline label="{{ __('labels.commercial') }}"
                                        id="line_of_business_commercial" name="account_type" value="commercial"
                                        :disabled="!empty($disabled) ? true : false" />
                                    <x-input-radio inline label="{{ __('labels.personal') }}"
                                        id="line_of_business_personal" name="account_type" value="personal"
                                        :disabled="!empty($disabled) ? true : false" />
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="quote_type"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.quote_type')</label>
                                <div class="col-sm-9">
                                    <x-input-radio inline label="{{ __('labels.new') }}" id="quote_type_new"
                                        name="quote_type" value="new" :disabled="!empty($disabled) ? true : false" />
                                    <x-input-radio inline label="{{ __('labels.renewal') }}" id="quote_type_renewal"
                                        name="quote_type" value="renewal" :disabled="!empty($disabled) ? true : false" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="payment_method"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.payment_method')</label>
                                <div class="col-sm-9">
                                    <x-input-radio inline label="{{ __('labels.coupons') }}"
                                        id="payment_method_coupons" name="payment_method" value="coupons"
                                        :disabled="!empty($disabled) ? true : false" />
                                    <x-input-radio inline label="{{ __('labels.ach') }}" id="payment_method_ach"
                                        name="payment_method" value="ach" :disabled="!empty($disabled) ? true : false" />
                                    <x-input-radio inline label="{{ __('labels.credit_card') }}"
                                        id="payment_method_credit_card" name="payment_method" value="credit_card"
                                        :disabled="!empty($disabled) ? true : false" />
                                </div>
                            </div>
                            <div class="model_details_fied">
                                <x-jet-input type="hidden" name="active_payment_methode"
                                    value="{{ $data->payment_method ?? '' }}" />
                            </div>
                            <div class="mt-5 mb-5">
                                @if ($quoteInformationEditTable)
                                    <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
                                @elseif($deleted == true)
                                    <div class="alert alert-danger" role="alert"> <b>This Quote has been
                                            deleted.</b> </div>
                                @elseif($data->status == $model::APPROVE)
                                    <div class="alert alert-white" role="alert"> <b>This quote can not be edited.
                                            This quote has been activated.</b> </div>
                                @else
                                    <div class="alert alert-white" role="alert"> <b>This quote can not be edited.
                                            This quote is under review for activation.</b> </div>
                                @endif
                            </div>

                        </x-form>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <hr />
                    </div>
                    @if ($pageType == 'edit')
                        <div class="col-md-12 page_table_menu">
                            <div class="columns" x-show="(open != 'tasks' && open != 'addtasks' )">
                                <div class="ui selection dropdown versiondropdown table-head-dropdown {{ count($versionList?->toArray()) == 1 ? 'disabled' : '' }}"
                                    :class="((open == 'addPolicy' || open == 'newVersion' || open == 'uploadAttachment') ?
                                        'disabled' : '')">
                                    <input type="hidden" name="version" /><i class="dropdown icon"></i>
                                    <div class="text">@lang('labels.version') <span x-text="versionText"></span></div>
                                    <div class="menu">
                                        @if (!empty($versionList))
                                            @foreach ($versionList as $ver)
                                                <div class="item" data-value="{{ $ver->id }}"
                                                    x-show="version != '{{ $ver->version_id }}'"
                                                    x-on:click="changeVersion('{{ $ver->id }}','{{ $ver->version_id }}')">
                                                    @lang('labels.version') {{ $ver->version_id }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($pageType !== 'edit')
                        <div class="col-md-12 ">
                            <x-form action="{{ routecheck($route . 'underwriting-information-save', $id) }}"
                                method="post"
                                class="validation tableForm underwriting_information_form {{ $deleted ? 'disabled' : '' }}">
                                <x-quoteunderwriting-question :qData="$data ?? ''" />
                            </x-form>
                        </div>
                    @endif



                    <div class="col-md-12 lodeHtmlData policies ajaxhtmlData" x-show="tab == 'policies'"></div>
                    <div class="col-md-12 lodeHtmlData" x-show="open == 'e_signature'">
                        @includeIf('company.quotes.e_signature.index')
                    </div>

                    @include('company.quotes.quote-models', ['data' => $data])
                </div>

                <div class="w-100 lodeHtmlData" x-show="open == 'inmail'">

                    <x-in-mail cancel="terms" type="quote" :quoteDeleted="$deleted ?? false" />
                </div>
                <div class="col-md-12 lodeHtmlData quotesTask" x-show="open == 'tasks'">
                    @includeIf($route . 'tasks.index', [
                        'qId' => $data->id,
                        'vId' => $data->vid,
                        'deleted' => $deleted,
                    ])
                </div>
                <div class="col-md-12 lodeHtmlData addQuotesTask" x-show="open == 'addTasks'">
                </div>
                <div class="col-md-12 lodeHtmlData editQuotesTask" x-show="open == 'editTask'">
                </div>
                <div class="col-md-12 lodeHtmlData attachments ajaxhtmlData" x-show="tab == 'attachments'"></div>
                <div class="col-md-12 lodeHtmlData notes ajaxhtmlData" x-show="tab == 'notes'"></div>

                <div class="col-md-12" x-show="open == 'logs'">
                    <x-table id="{{ $activePage }}-logs"
                        ajaxUrl="{{ routeCheck('company.logs', ['type' => activePageName(), 'id' => $id]) }}">
                        <thead>
                            <tr>
                                <th class="" data-sortable="true" data-field="created_at" data-width="170">
                                  @lang('labels.created_date')</th>
                                <th class="" data-sortable="true" data-field="username" data-width="200">
                                    @lang('labels.user_name')</th>
                                <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                            </tr>
                        </thead>
                    </x-table>
                </div>
                <div class="col-md-12" x-show="open == 'e_signature'">
                    @include('company.quotes.e_signature.index', ['data' => $data])
                </div>
                @if ($data?->status >= $model::APPROVE)
                    <div class="col-md-12" x-show="open == 'underwriting_questions'">
                        <x-form action="{{ routecheck($route . 'underwriting-information-save', $id) }}" method="post"
                            class="validation tableForm underwriting_information_form {{ $approveQuoteEdit ? 'disabled' : '' }}">
                            <x-quoteunderwriting-question :qData="$data ?? ''" />
                        </x-form>
                    </div>
                    <div class="col-md-12" x-show="open == 'underwriting_logs'">
                        <x-table id="{{ $activePage }}-underwriting">
                            <thead>
                                <tr>
                                    <th class="" data-sortable="true" data-field="created_at"
                                        data-width="170">
                                       @lang('labels.created_date')</th>
                                    <th class="" data-sortable="true" data-field="username" data-width="200">
                                        @lang('labels.user_name')</th>
                                    <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                                </tr>
                            </thead>
                        </x-table>
                    </div>
                @endif
            </div>
        </div>
        <div class="remodal" data-remodal-id="twoStepVerification">
            <button class="remodal-close" data-remodal-action="close"></button>
            <h4>@lang('labels.two_step_verification')</h4>
            <p>A Two-Step Verification code has been sent to your email!
                If the email message does not arrive within 5 minutes, check your spam folder. If you still haven't
                received it, press the Resend button below.</p><br>
            <div class="form-group row">
                <div class="col-sm-12 p-0">
                    <x-jet-input type="text" name="opt" class="digitLimit" data-limit="6" maxlength="6"
                        x-model="otp" />
                </div>
                <label for="opt" class="">@lang('labels.as_a_security_measure_the_code_will_expire_in') <span
                        class="countdown"></span> </label>
            </div>

            <div class="buttons">
                <button class="btn btn-sm btn-primary submit"
                    x-on:click="twoStepVerification()">@lang('Submit')</button>
                <button class="btn btn-sm btn-secondary resendBtn" disabled
                    x-on:click="eSignatureQuote(type='resend')">@lang('Resend')</button>
                <button class="btn btn-default btn-sm" data-remodal-action="cancel">@lang('Cancel')</button>
            </div>
        </div>

        <div class="remodal" data-remodal-id="viewModalfiles">
            <button class="remodal-close" data-remodal-action="close"></button>
            <h4>@lang('labels.view_file')</h4>
            <br>

            <p>You have already signed the Finance Agreement, should we send an invitation to your Insured? You may also
                sign on behalf of your Insured by <a href="javascript:void(0)" class="linkButton"
                    x-on:click="eSignatureQuote('insuredSignature')">Clicking Here</a> </p>

            <div class="buttons">

                <button class="btn btn-default btn-sm" data-remodal-action="cancel">@lang('Cancel')</button>
                <button class="btn  btn-sm  btn-primary "
                    data-remodal-target="insuredmailmodal">@lang('Send')</button>
            </div>
        </div>

        <div class="remodal" data-remodal-id="insuredmailmodal"
            data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
            <x-form class="validation"
                action="{{ routeCheck($route . 'insured-signature-send', ['qId' => $data->id, 'vId' => $data->vid]) }}">
                <div class="form-group row text-left">
                    <div class="col-sm-12 ">
                        <x-select required :options="$insuredUsers ?? []" name="insured" class="ui dropdown w-100" />

                    </div>
                </div>
                <div class="buttons">
                    <button class="btn btn-sm btn-primary saveData">@lang('Submit')</button>
                </div>
            </x-form>
        </div>

        <div class="remodal" data-remodal-id="releasemodal"
            data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
            <button class="remodal-close" data-remodal-action="close"></button>
            <h4>@lang('labels.quote_release')</h4>
            <br>

            <x-form class="validation text-left"
                action="{{ routeCheck($route . 'finance-unlock-quote', ['qId' => $data?->id]) }}" method="post">
                <div class="row">
                    <input type="hidden" name="type" value="unlock">
                    <input type="hidden" name="current_date" x-bind:value="getCurrentTimeZone()">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">Reason</label>
                            <x-select :options="[
                                'Agent request' => 'Agent request',
                                'Correction due to underwriting' => 'Correction due to underwriting',
                                'Missing information' => 'Missing information',
                            ]" name="reason" class="ui dropdown w-100" reque />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.note') </label>
                            <textarea class="form-control " required rows="3" name="note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="buttons text-center">
                    <button class="btn btn-primary btn-sm saveData">@lang('Release')</button>
                    <button data-remodal-action="confirm" class="btn btn-sm btn-secondary">Cancel</button>
                </div>
            </x-form>

        </div>


        <div class="remodal" data-remodal-id="quoteDeline"
            data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
            <button class="remodal-close" data-remodal-action="close"></button>
            <h4 class="modelTitle">@lang('labels.quote_decline_notes')</h4>
            <br>

            <x-form class="validation text-left"
                action="{{ routeCheck($route . 'quote-decline', ['qId' => $data?->id]) }}" method="post">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.note')</label>
                            <textarea class="form-control" required rows="3" name="note"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12  d-none dropdwon_box">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.send_inmail_to_general_agent_for_pending_down_payment')</label>

                            <x-select :options="['yes' => 'Yes', 'no' => 'No']" class="ui dropdown" name="send_inmail" />
                        </div>
                    </div>
                </div>
                <div class="buttons text-center">
                    <button class="btn btn-primary btn-sm saveData">@lang('Save & Continue')</button>
                    <button data-remodal-action="confirm" class="btn btn-sm btn-secondary">@lang('Cancel Decline')</button>
                </div>
            </x-form>
        </div>


    </section>
    @push('page_script')
        <script>
            var editArr = @json($data ?? []);
            // console.log
            var versionCount = "{{ $versionCount ?? '' }}";
            var pageType = "{{ $pageType ?? 'edit' }}";
        </script>
    @endpush
</x-app-layout>
