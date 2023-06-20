@extends("layouts.blank",['class'=>['jSignature','pdf','datepicker']])

@push('common_style')
<style>
    {
         ! ! DBHelper: :metaValue('finance-agreement') ?? '' ! !
    }

</style>
@endpush
@section("content")
@isset($quoteId)
<div class=" d-flex justify-content-end pr-2">

    <a class="mx-1" href="{{  routeCheck('quotes.download-quote',['q'=>$qId,'v'=>$vId]) }}"><i class="fal fa-download"></i></a>
    <div class="createdPrint mx-1" id="disclosureprint" data-content=".template_section" title=""><i class="fal fa-print"></i></div>

    {{-- <div class="windowpop_close mx-1"><i class="fa-regular fa-circle-xmark"></i></div>  --}}
</div>
<hr>
@endisset
<div class="w-100 template_section">
    {!! $template !!}
</div>
<section>

    <div class="remodal AddSignatureModel" data-remodal-id="AddSignatureModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <button class="remodal-close" data-remodal-action="close"></button>
        <h4 class="mt-0">@lang('labels.e_signature_')</h4>

        <div class="modal-body text-left">
            <x-form class="validationForm" action="{{  routeCheck('quotes.signatures-save',['qId'=>$qId,'vId'=>$vId]) }}" method="post">
                <x-jet-input type="hidden" name="type" value="" />
                <x-jet-input type="hidden" name="index" value="" />
                @if(!empty($insured_signature_id))
                <x-jet-input type="hidden" name="insured_id" value="{{ $insured_signature_id ?? '' }}" />
                @endif
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.full_name')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="name" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                    <div class="col-sm-9 ">
                        <x-jet-input type="email" name="email" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.title')</label>
                    <div class="col-sm-9 ">
                        <x-jet-input type="text" name="title" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.type_signature')</label>
                    <div class="col-sm-9 ">
                        <canvas id="textCanvas" height="30" width="300" style="display:none;"></canvas>
                        <input type="hidden" name="signature" class="agenttexturl" value="">
                        <input type="hidden" name="signature_font" class="font" value="Allura">
                        <x-jet-input required style="padding: 3.375rem .75rem;font-family: 'Allura';font-size:30px;" type="text" name="signature_text" data-font="'Allura'" />
                        <div class="d-flex mt-1  justify-content-end">

                            <a href="javascript:void(0)" class=" change_font linkButton">Change Fonts</a>
                            <a href="javascript:void(0)" class="clear_btn linkButton ml-1">Clear</a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 ">
                        <x-input-radio name="title" id="agree_terms" name="agree" value="terms" label="Agree with the terms described in the Premium Finance Agreement" checked />
                        <x-input-radio name="title" id="agree_electronic" name="agree" value="electronic" label="Agree to use Electronic Records and Signature. <span data-remodal-target='SignaturedisclosureModal' class='linkButton'>Electronic Records and Signature Disclosure.</span>" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 ">
                        <p>By selecting Adopt Signature and Sign, | agree that the esignature and initials will be the
                            electronic representation of my signature and initials for all purpose when | (or my agent) use
                            them on documents, including legally binding contracts — just the same as a pen-and-paper
                            signature or initial.</p>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-sm btn-primary saveData" type="button">Adopt signature & Sign</button>
                        <button class="btn btn-sm btn-secondary" type="button" data-remodal-action="cancel">Cancel</button>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
    <div class="remodal" data-remodal-id="SignaturedisclosureModal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <button class="remodal-close" data-remodal-action="close"></button>
        <div class="modal-header d-flex">
            <h6 class="modal-title">Agreement to do business with {{ !empty($agencyData?->name) ? $agencyData?->name : '' }}</h6>
            <div class="createdPdf" id="createpdfs" data-content=".downloadcontentModel" data-name="Disclosure" title=""><i class="fal fa-download"></i></div>
            <div class="createdPrint" id="disclosureprint" data-content=".downloadcontentModel" title=""><i class="fal fa-print"></i></div>

        </div>
        <h4></h4>
        <p class="downloadcontentModel">{{ $textSignature ?? '' }}</p><br>
        <div class="buttons">
            <button class="btn btn-default btn-sm" data-remodal-action="cancel">@lang('labels.cancel')</button>
        </div>
    </div>

    <div class="remodal" data-remodal-id="successModal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <h4 class="d-none">Signature completed successfully</h4>
        <h4>Document signed and submitted successfully</h4>
        <span class="text-muted">A follow up email will be sent to all parties</span>

        <x-form class="validation success_modal">
            <div class="form-group row text-left">
                <div class="col-sm-12 ">
                    <x-input-radio required id="insuredmailmodal" name="modaltext" value="insuredmailmodal" label="Send e-signature finance agreement to insured" />
                    <x-input-radio required id="behalfinsuredsignature" name="modaltext" value="behalfinsuredsignature" label="Save and e-sign on behalf of the insured" />
                    <x-input-radio required id="completesig" name="modaltext" value="completesig" label="Save & exit" />
                </div>
            </div>
            <div class="buttons">
                <button class="btn btn-sm btn-primary saveData">@lang('Submit')</button>
            </div>
        </x-form>

        {{-- <div class="buttons">
            <button class="btn btn-sm btn-primary">@lang('Submit')</button>
        </div> --}}

    </div>


    <div class="remodal" data-remodal-id="insuredmailmodal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <x-form class="validation" action="{{ routeCheck($route.'insured-signature-send',['qId'=>$qId,'vId'=>$vId]) }}">
            <div class="form-group row text-left">
                <div class="col-sm-12 ">
                    <x-select required :options="($insuredUsers ?? [])" name="insured" class="ui dropdown w-100" />

                </div>
            </div>
            <div class="buttons">
                <button class="btn btn-sm btn-primary saveData">@lang('Submit')</button>
            </div>
        </x-form>
    </div>




</section>


@endsection

@push("page_script_code")
<script>
    let signatureArr = @json($quoteSignature ? ? []);
    var clicksignature = 0;
    var lastsignArr = [];
    const fontarry = ["Great Vibes", "Marck Script", "Niconne", "Dancing Script", "cursive", "Allura"];
    const isAgent = "{{ $isAgent ?? 'no'  }}";
    const isIsnured = "{{ $isIsnured ?? 'no'  }}";
    let isnuredAllow = false;
    $(function() {
        // changehtmlsig();
        const agentCount = $('.drawignature.agent').length;
        const isnuredCount = $('.drawignature.isnured').length;
        if (!isEmptyChack('{{ $agentCount ?? 0 }}') && agentCount == '{{ $agentCount ?? 0 }}') {

        } else if ('{{ $agentCount ?? 0 }}' == 1) {
            isnuredAllow = true;
        }

        if (isAgent !== 'yes' && isIsnured !== 'yes') {
            $(".drawignature").removeAttr('data-type data-id');
        } else if (isAgent == 'yes' && isnuredAllow == false) {
            if ('{{ $agentCount ?? 0 }}' != 1) {
                $(".drawignature.isnured").removeAttr('data-type data-id');
            }

        }

        $(".agent_title").html('<div class="usertitle" data-type="agent"></div>');
        $(".isnured_title").html('<div class="usertitle" data-type="isnured"></div>');
    })


    let isClickCount = 1;
    $(document.body).on("click", ".drawignature", function() {
        const type = $(this).attr('data-type');
        const id = $(this).attr('data-id');
        const pageIndex = $(this).closest("td").attr('data-pageid');
        if (!isEmptyChack(type) && !isEmptyChack(id) && !isEmptyChack(pageIndex) && $(this).hasClass('addsignature')) {
            var options = {
                closeOnOutsideClick: false
            };
            const modelElement = $('[data-remodal-id="AddSignatureModel"]');
            var inst = modelElement.remodal(options);
            inst.open();
            modelElement.find('form input[name="type"]').val(type);
            modelElement.find('form input[name="index"]').val(pageIndex);
        }
    });


    $(document).on('click', '.clear_btn', function() {
        $('#signature_text').val('');
        $('.agenttexturl').val('');
    });

    $(document).on('input', '#signature_text', function() {
        let tCtx = document.getElementById('textCanvas').getContext('2d');
        tCtx.clearRect(0, 0, document.getElementById('textCanvas').width, document.getElementById('textCanvas').height);
        let tCtxs = document.getElementById('textCanvas').getContext('2d');
        tCtx.font = "25px " + $(".font").val(); + "";
        tCtx.fillText($("#signature_text").val(), 10, 30);
        $('.agenttexturl').val(tCtx.canvas.toDataURL());
    });


    let i = 0;
    $(document.body).on("click", ".change_font", function() {
        const lengthArr = fontarry.length;
        $("#signature_text").css('font-family', fontarry[i]);
        $("#signature_text").attr('data-font', fontarry[i]);
        if (!isEmptyChack($("#signature_text").val())) {
            $("#signature_text").trigger('input');
            $(".font").val(fontarry[i]);
        }
        if (i > lengthArr) {
            i = 0;
        } else {
            i++;
        }
    })

    $(document.body).on("change", "#signatures_agree_checkbox", function() {
        if (!$(this).is(':checked')) {
            $('.AddSignatureModel').find('.modal-body').addClass('isBodyDisabled');
            $('.AddSignatureModel').find('.submitBtn').addClass('isBodyDisabled');
        } else {
            $('.AddSignatureModel').find('.modal-body').removeClass('isBodyDisabled');
            $('.AddSignatureModel').find('.submitBtn').removeClass('isBodyDisabled');
        }
    })







    $(document).on("click", ".saveData", async function(e) {
        let forM = $(this).parents('form');
        let isValid = isValidation(forM, notClass = true);
        e.preventDefault();
        e.stopPropagation();
        $(this).attr("disabled", true);
        $(this).find(".button--loading").removeClass("d-none");
        if (isValid) {
            let formClass = forM;
            let args = await serializeFilter(forM);
            const agentCount = $('.drawignature.agent').length;
            const isnuredCount = $('.drawignature.isnured').length;
            if (forM.hasClass('success_modal')) {
                var inst = $('[data-remodal-id="successModal"]').remodal();
                const modaltext = forM.find('input[name="modaltext"]:checked').val();

                if (modaltext == 'insuredmailmodal') {
                    $('[data-remodal-id="insuredmailmodal"]').remodal().open();
                } else if (modaltext == 'behalfinsuredsignature') {
                    $(".drawignature.isnured").attr({
                        'data-type': 'isnured'
                        , 'data-id': 'AddSignatureModel'
                    });
                    inst.close();
                } else {
                    inst.close();
                }
                return true;
            }


            args.push({
                'name': 'current_datetime'
                , 'value': getCurrentTimeZone()
            });
            args.push({
                'name': 'signature_agent'
                , 'value': agentCount
            });
            args.push({
                'name': 'signature_isnured'
                , 'value': isnuredCount
            });
            let url = await forM.attr("action");
            let _method = forM.find(" input[name='_method']").val();
            _method = _method ? ? "post";
            let data = await doAjax(url, _method, args, {
                dataType: "json"
            , }, formClass);
            $(this).find(".button--loading").addClass("d-none");
            $(this).removeAttr("disabled", true);

            if (data.status == true) {
                if (data.type == "signature_save" && !isEmptyChack(data.data)) {
                    let elemtHtml = null;
                    if (data.data.type == "agent") {
                        elemtHtml = $('.agent_signature[data-pageid="' + data.data.index + '"]').find('.drawignature')
                    } else {
                        elemtHtml = $('.isnured_signature[data-pageid="' + data.data.index + '"]').find('.drawignature')
                    }
                    elemtHtml.attr('style', 'border-bottom:1px solid black');
                    elemtHtml.closest('td').find('.signatureboxcss').addClass('signaturecss');
                    elemtHtml.html(`<a style="color: #000;font-size: 12px;margin-top: 63px;" href="javascript:void(0);" class="remove_signature"></a><img src="${data.data.signature}">`)
                    elemtHtml.closest("td").find(".usertitle-signon").html('<h6 style="font-size: 14px;margin: 0 0px 5px;margin-top:10px;">' + data.data.name + ',&nbsp; ' + data.data.title + '&nbsp;&nbsp;&nbsp;' + data.data.current_datetime + '</h6>');
                    elemtHtml.closest("td").find('.drawignature').removeClass('addsignature')
                    const modelElement = $('[data-remodal-id="AddSignatureModel"]');
                    //modelElement.find('form').trigger('reset');
                    var inst = modelElement.remodal();
                    inst.close();
                    if (data.data.count == agentCount && data.data.type == "agent") {
                        var inst = $('[data-remodal-id="successModal"]').remodal();
                        inst.open();
                    }
                } else if (data.type == 'insuredSignatureSend') {
                    successAlertModel(data.msg, "", "url", "single");
                }
            }
        }

    });

</script>
@endpush
