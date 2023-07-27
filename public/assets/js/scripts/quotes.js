let fff = $('#quotes-esignature');
const termsData = async (qId,version) =>{
    if(isEmptyChack(qId)) return false;
    const responseTerms = await doAjax(
        `${BASE_URL}quotes/terms/${qId}/${version}`,
        "get"
    );
    if (!isEmptyChack(responseTerms)) {
        $(".policies").html(responseTerms);
        $(".policies").find('.ui.dropdown').dropdown();
        amount();percentageInput('.percentage_input');digitLimit();singleDatePicker();
    }
}
let dataParams = {};
function esignatureaLogs (params){
    const quoteId = dataParams?.quoteId;
    const versionId = dataParams?.versionId;
    var url =  `${BASE_URL}quotes/esignature-logs/${quoteId}/${versionId}`;
    $.get(url + '?' + $.param(params.data)).then(function (res) {
      /*   console.log(res) */
        params.success(res);
       /*  console.log(params); */
    });
}

document.addEventListener("alpine:init", () => {
    Alpine.data("quotesEdit", () => ({
        open: pageType == "edit" ?  "quote_information" : 'policies',
       // open: pageType == "edit" ?  "policies" : 'policies',
        title: "Quote Information",
        quoteId: editArr.id,
        versionId: editArr.vid,
        version : editArr.version,
        versiontab: editArr.version,
        versionMax: versionCount,
        versionText: editArr.version,
        policyId: null,
        back: null,
        tab: null,
        otp: null,
        AJAXBASEURL: null,
        init() {
            $('.lodeHtmlData').removeClass('lodeHtmlData');
            const Urltype = new URLSearchParams(window.location.search).get('type');
            if(!isEmptyChack(Urltype) && Urltype == 'policy'){
                 this.open = 'addPolicy';
            }
            this.AJAXBASEURL = $(this.$el).attr("data-ajax-url");
            this.quotesMails();
        },
        trigger(tab) {
            this.open = tab;
        },

        quotesMails(){
              $('.mailForm').find('.qId').val(editArr.id);
              $('.mailForm').find('.vId').val(this.versionId);
              $('.mailForm').find('.version').val(this.version);
              let subInputGropu = `Quotes # ${editArr.qid}.${this.version}`
              $('.quoteIdSubject').removeClass('d-none').find('span').text(subInputGropu);
               $('.mailForm').find('.quote_subject').val(subInputGropu);

        },
        changeVersion(id =this.versionId,currentversion=this.version) {
           this.version = currentversion;
           this.versionId = id;
           this.quotesMails();
        },

        async favorite(id =this.versionId,$el) {
            if(isEmptyChack(id)) return false;
          /*   console.log(this.version,id); */
            const response = await doAjax(`${this.AJAXBASEURL}/favorite-version/${id}`,"post");
            if(response.status){
                $($el).removeAttr('x-on:click').find('i').attr('class','fa-solid fa-star text-warning');
                this.open = "terms";
            }
        },
        async termsUpdate($el) {
            /* const version = this.versionId;
            const quote = this.quoteId;
            const name = $($el).attr('name');
            const val = $($el).val();

            const response = await doAjax(`${BASE_URL}quotes/task-update/${quote}/${version}`,'post',{name:name,value:val});
            this.terms(quote,version); */
         },
        async terms(qId= editArr.id,version = this.versionId) {
            termsData(qId,version)

        },
        async cloneVersion(version = this.versionId) {
            if(isEmptyChack(version)) return false;
            const response = await doAjax(
                `${this.AJAXBASEURL}/clone-version/${this.versionId}`,"post");
            if (!isEmptyChack(response)) {

              /*   $(".versiondropdown .menu").append(optionsHtml); */
                $(".versiondropdown").removeClass('disabled').dropdown();
                successAlertModel(response.msg, `changeVersion('${response.versionId}','${response.version}')`, "attr",'cancel',{
                    'text' : 'Continue to Version '+response.version,
                    'class' : 'btn btn-info actionButton',
                });
            }
        },

        async cloneQuote() {
            if(isEmptyChack(this.quoteId)) return false;
            const response = await doAjax(
                `${this.AJAXBASEURL}/clone-quote/${this.quoteId}`,"post");
            if (!isEmptyChack(response) && response.status == true) {
                successAlertModel(response.msg,response.url, "url",'cancel',{
                    'text' : 'Continue to new  Quote' + response.q_number,
                    'class' : 'btn btn-info actionButton',
                });
            }
        },

        async deleteVersion(id) {
            if(isEmptyChack(id)) return false;
           
            const response = await doAjax(
                `${this.AJAXBASEURL}/delete-version/${id}`,"delete");
            if (!isEmptyChack(response) && response.status == true) {
                this.versionText = response.version;
                this.changeVersion(response.versionId,response.version);
                $('.versiondropdown').find('.item[data-value="'+ id +'"]').remove();
                $("[data-remodal-id='deleteModel']").remodal()?.close();
            }else{
                textAlertModel(true, response.msg);
            }
        },

        async notesFn(url,type=null) {
            if(isEmptyChack(url)) return false;
            this.tab = 'notes';
            switch (type) {
                case "list":
                    _method = 'get';
                    break;

                default:
                    break;
            }
            const response = await doAjax(`${this.AJAXBASEURL}/${url}/${ this.quoteId}/${ this.versionId}`,_method,{
                qId : this.quoteId,
                vId: this.versionId,
            });

            if (response) {
                $('.notes').html(response);
                $(".ui.dropdown").dropdown();
                $("#quotes-notes").bootstrapTable();
                if($('#quotes-notes-delete').length > 0){
                    $("#quotes-notes-delete").bootstrapTable();
                }
                $("#quotes-notes-append-list").bootstrapTable();
                dateDropdowns();
            }
        },
        async detailsNotes(id) {
            if(isEmptyChack(id)) return false;
            this.notesFn(`quote-notes/${id}`,'details');
        },
        async detailsTask(id) {
            if(isEmptyChack(id)) return false;
                this.open = "editTask";
                const response = await doAjax(`${this.AJAXBASEURL}/task-details/${id}/${editArr.id}/${this.versionId}`,"post");
                if (response.status) {
                    $('.editQuotesTask').html(response.view);
                    $(".ui.dropdown").dropdown();
                    $("#quotes-tasks-append-list").bootstrapTable();
                    dateDropdowns();
                }

        },
        async editTask(id) {
          /*   this.back = 'tasks'; */
            if(isEmptyChack(id)) return false;
                this.open = "editTask";

                const response = await doAjax(`${this.AJAXBASEURL}/task-edit/${id}/${editArr.id}/${this.versionId}`,"get");
                if (response.status) {
                    $('.editQuotesTask').html(response.view);
                    $(".ui.dropdown").dropdown();
                    $("#quotes-tasks-append-list").bootstrapTable();
                    dateDropdowns();
                }
        },

        async policyDetails(id) {},
        async viewFa() {
            return windowpop(`${this.AJAXBASEURL}/view-fa/${this.quoteId}/${this.versionId}`,1000, 1000)
        },
        async eSignatureQuote(type=null) {
            this.otp =null;
            $('.errorOtp').remove();
            let arg = {};
            if(type == 'insuredSignature'){
                arg = {insuredSignature : true}
            }
            const res = await doAjax(`${this.AJAXBASEURL}/send-otp/${this.quoteId}/${this.versionId}`,'post',arg);
           /*  console.log(res); */
            if(res.status == true && res.type == 'isnuredOpenModel'){
                    var inst = $('[data-remodal-id="viewModalfiles"]').remodal();
                    inst.open();

            }else if(res.status == true && res.type == 'openModel'){
                if(!$('[data-remodal-id="twoStepVerification"]').hasClass('remodal-is-opened')){
                    var inst = $('[data-remodal-id="twoStepVerification"]').remodal();
                    inst.open();
                }
                countdown(res.time);
            }

        },
        async twoStepVerification() {
            $('.errorOtp').remove();
            const res = await doAjax(`${this.AJAXBASEURL}/varify-otp/${this.quoteId}/${this.versionId}`,'post',{otp:this.otp});
            if(!isEmptyChack(res) &&  res?.status == false){
                $('[data-remodal-id="twoStepVerification"]').find('input').after('<div class="text-danger text-left errorOtp"><small>'+res?.msg+'</small></div>');
            }else{
                var inst = $('[data-remodal-id="twoStepVerification"]').remodal();
                inst.close();
                return windowpop(`${this.AJAXBASEURL}/signature?q=${this.quoteId}&v=${this.versionId}`,1000, 1000)
            }
        },
        async lienholders(id) {
            this.tab = "lienholders";
            this.policyId = id;
             $(`#quotes-lienholder`)
                .bootstrapTable("destroy")
                .bootstrapTable({
                    url: `${this.AJAXBASEURL}/lienholder-list/${id}`,
                });
        },
        async addLienholder(id=null) {
            if(this.policyId){
                let url = `${this.AJAXBASEURL}/lienholder/${this.policyId}`;
                if(!isEmptyChack(id)){
                    url = `${url}/${id}`
                }
                const res = await doAjax(url, "get");
                if(res.status == true){
                     $('.notes').html(res.view);
                     uiDropdown();
                     zipMask();
                     telephoneMaskInput();
                     faxMaskInput();
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                }
                this.tab = "notes";
            }
        },
        async additionalInsureds(id) {
            this.tab = "additionalInsureds";
            this.policyId = id;
             $(`#quotes-additional-insureds`)
                .bootstrapTable("destroy")
                .bootstrapTable({
                    url: `${this.AJAXBASEURL}/additional-insureds-list/${id}`,
                });
        },
        async addAdditionalInsureds(id=null) {
      
            if(this.policyId){
                let url = `${this.AJAXBASEURL}/additional-insureds/${this.policyId}`;
                if(!isEmptyChack(id)){
                    url = `${url}/${id}`
                }
                const res = await doAjax(url, "get");
                if(res.status == true){
                     $('.notes').html(res.view);
                     uiDropdown();
                     zipMask();
                     telephoneMaskInput();
                     faxMaskInput();
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                }
                this.tab = "notes";
            }
            
        },
        async quoteRequestActivation(type=null) {
            /* if(type == 'continue'){ */
                const res = await doAjax(`${this.AJAXBASEURL}/request-activation/${editArr.id}/${this.versionId}`, "post",{current_date:getCurrentTimeZone()});
                if(res.status == true){
                    window.location.href = res.url;
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                }
           /*  }else{

            } */
        },
        async quoteDelete(type=null) {
            
            if(type == 'continue'){
                const res = await doAjax(`${this.AJAXBASEURL}/${editArr.id}`, "delete",{current_date:getCurrentTimeZone()});
                if(res.status == true){
                    window.location.href = res.url;
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                }
            }else{
                deleteModel('Are you sure you want to delete?','attr',`quoteDelete('continue')`);
            }
        },
        async quoteRequestToUnlock() {
            const res = await doAjax(`${this.AJAXBASEURL}/request-activation-unlock/${editArr.id}/${this.versionId}`, "post",{current_date:getCurrentTimeZone()});
            if(res.status == true){
                textAlertModel(true,res.msg)
            }else if(res.status == false){
                textAlertModel(true,res.msg)
            }
        },

        async financeUnlockquote(type=null) {
            if(type == 'unlock'){
                $('[data-remodal-id="releasemodal"]').remodal().open();
            }else{
                const res = await doAjax(`${this.AJAXBASEURL}/finance-unlock-quote/${editArr.id}`, "post",{current_date:getCurrentTimeZone()});
                if(res.status == true){
                    textAlertModel(true,res.msg)
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                }
            }
        },
        async aggregateLimitStatus(type=null) {

            const res = await doAjax(`${this.AJAXBASEURL}/aggregate-limit-status/${editArr.id}`, "post",{current_date:getCurrentTimeZone(),type:type});
            if(res.status == true){
                successAlertModel(res.msg, res.url, "url","single");
            }else if(res.status == false){
                textAlertModel(true,res.msg)
            }

        },
        async statusUpdate(type=null) {

            const res = await doAjax(`${this.AJAXBASEURL}/quote-update-data/${editArr.id}`, "post",{type:type});
            if(res.status == true){
             //   successAlertModel(res.msg, res.url, "url","single");
            }else if(res.status == false){
                textAlertModel(true,res.msg)
            }

        },
        async quoteApprove(type=null) {

            const FormUwF = $('.underwriting_information_form');
            FormUwF.find('input[type="radio"]').attr('required','required') ;
            let isValid = isValidation(FormUwF, (notClass = true));
             /* console.log(isValid); */
            if(isValid){
                $('[data-remodal-id="quoteDeline"]').find('.modelTitle').html('Quote Activation Notes');
                $('[data-remodal-id="quoteDeline"]').find('.dropdwon_box').removeClass('d-none');
                $('[data-remodal-id="quoteDeline"]').find('.dropdwon_box select').attr('required','required');
                $('[data-remodal-id="quoteDeline"]').find('form').attr('action',`${this.AJAXBASEURL}/quote-approve/${editArr.id}`);
                $('[data-remodal-id="quoteDeline"]').remodal().open();
              /*   const res = await doAjax(`${this.AJAXBASEURL}/quote-approve/${editArr.id}`, "post",{current_date:getCurrentTimeZone()});
                if(res.status == true){
                    successAlertModel(res.msg, res.url, "url","single");
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                } */
            }

        },
        async finalApproved(type=null) {
            const res = await doAjax(`${this.AJAXBASEURL}/final-approve/${editArr.id}`, "post",{current_date:getCurrentTimeZone()});
            if(res.status == true){
                successAlertModel(res.msg, res.url, "url","single");
            }else if(res.status == false){
                textAlertModel(true,res.msg)
            }

        },
        async quoteDecline() {
            $('[data-remodal-id="quoteDeline"]').find('.modelTitle').html('Quote Decline Notes');
            $('[data-remodal-id="quoteDeline"]').find('.dropdwon_box').addClass('d-none');
            $('[data-remodal-id="quoteDeline"]').find('.dropdwon_box select').removeAttr('required');
            $('[data-remodal-id="quoteDeline"]').find('form').attr('action',`${this.AJAXBASEURL}/quote-decline/${editArr.id}`);
            $('[data-remodal-id="quoteDeline"]').remodal().open();
        },

        async underwritingVerification(type=null) {

            if(type == 'continue'){
                const res = await doAjax(`${this.AJAXBASEURL}/underwriting-verification/${editArr.id}`, "post",{current_date:getCurrentTimeZone()});
                if(res.status == true){
                    showLoader();
                     $('[data-remodal-id="successAlertModel"]').remodal()?.close();
                     window.location.href = res.url;
                     
                }else if(res.status == false){
                    textAlertModel(true,res.msg)
                }
            }else{
                successAlertModel('By clicking Continue Quote Activation will be assigned to you and will be removed from Request for Activation Queue.', `underwritingVerification('continue')`, "attr",'modelCancel');
            }
        },
        async uploadAttachment(isPfa=false) {
            this.title = "Attachment";
            const responseAddAttachments = await doAjax(
                `${BASE_URL}attachments/add?quotesId=${editArr.id}&versionId=${this.versionId}&type=quotes&pfa=${isPfa}`,
                "get"
            );
            if (!isEmptyChack(responseAddAttachments)) {
                $(".attachments").html(responseAddAttachments);
                $(".ui.dropdown").dropdown();
            }
            this.tab = "attachments";
            this.back = 'attachments';
        },

        async quotesEditEffect() {
            $(".ajaxhtmlData").html(null);
            this.versionText = this.version;
            this.back = null;

            switch (this.open) {
                case "quote_information":
                        this.title = 'Quote Information';
                        $('.maindropdown').dropdown('set text', this.title);
                        $('.maindropdown').dropdown('set value','quote_information');
                        this.terms();
                        this.tab = "policies";
                    break;
                case 'e_signature':
                    let $table = $('#quotes-esignature').bootstrapTable('refresh',{
                        url : `${this.AJAXBASEURL}/esignature/logs`,
                        query: { quoteId: this.quoteId,versionId :this.versionId}
                    });
                case 'underwriting_logs':
                   
                     $('#quotes-underwriting').bootstrapTable('refresh',{
                        url : `${BASE_URL}logs/quotes-underwriting/${this.versionId}`,
                    });
                    break;
                case 'logs':
                    $('#quotes-logs').bootstrapTable('refresh')
                    break;
                case "inmail":
                    $('.in_mail_box_section').find('.page_table_menu').addClass('quotes_in_mail_box_');
                    break;

                case "terms":
                    this.title = "Policies";
                    this.terms();
                    this.tab = "policies";
                    break;
                case "attachments":
                    this.title = "Attachment";
                    const responseAttachments = await doAjax(
                        `${BASE_URL}attachments?quotesId=${editArr.id}&type=quotes`,
                        "get"
                    );
                    if (!isEmptyChack(responseAttachments)) {
                        $(".attachments").html(responseAttachments);
                    }
                    this.tab = "attachments";
                    break;
                case "uploadAttachment":
                    this.uploadAttachment();
                    break;
                case "uploadSignedPFA":
                    this.uploadAttachment(true);
                    break;
                case "policies":
                    this.title = "Policies";
                    const responsePolicies = await doAjax(
                        `${this.AJAXBASEURL}/policy-list/${editArr.id}/${this.versionId}`,
                        "get"
                    );
                    if (!isEmptyChack(responsePolicies)) {
                        $(".policies").html(responsePolicies);
                    }
                    this.tab = "policies";
                    break;
                case "addPolicy":
                    this.title = "Policies";
                    const responseaddPolicy = await doAjax(
                        `${this.AJAXBASEURL}/policy-create/${editArr.id}/${this.versionId}`,
                        "get"
                    );
                    if (
                        !isEmptyChack(responseaddPolicy) &&
                        responseaddPolicy.status == true
                    ) {
                        $(".policies").html(responseaddPolicy.view);
                        $(".ui.dropdown").dropdown();
                        amount();
                        percentageInput();
                        singleDatePicker($("#inception_date"));
                        remotelyDropDown(
                            ".insurance_companyDropdown",
                            "common/entity/insurance_company",{istype:'quote'}
                        );
                        remotelyDropDown(
                            ".general_agentDropdown",
                            "common/entity/general_agent",{istype:'quote'}
                        );
                        remotelyDropDown('.broker_dropdown',
                        'common/entity/broker',{istype:'quote'});
                        $(".account_type input").change();
                    }
                    this.tab = "policies";
                    break;
                case "newVersion":
                    this.versionText = parseInt(this.versionMax) + 1;
                    this.title = "Policies";

                    const responseaddnewVersion= await doAjax(
                        `${this.AJAXBASEURL}/new-version/${editArr.id}`,
                        "get"
                    );
                    if (
                        !isEmptyChack(responseaddnewVersion) &&
                        responseaddnewVersion.status == true
                    ) {
                        $(".policies").html(responseaddnewVersion.view);
                        $(".ui.dropdown").dropdown();
                        amount();
                        percentageInput();
                        singleDatePicker($("#inception_date"));
                        remotelyDropDown(
                            ".insurance_companyDropdown",
                            "common/entity/insurance_company",{istype:'quote'}
                        );
                        remotelyDropDown(
                            ".general_agentDropdown",
                            "common/entity/general_agent",{istype:'quote'}
                        );
                        
                        remotelyDropDown('.broker_dropdown',
                        'common/entity/broker',{istype:'quote'});


                        $(".account_type input").change();
                    }
                    this.tab = "policies";
                case "tasks":
                    this.title = "Tasks";
                    $("#quotes-tasks").bootstrapTable('refresh');
                    break;
                case "addTasks":
                    this.title = "Tasks";
                    const addTask= await doAjax(`${BASE_URL}task/add?qId=${editArr.id}?vId=${this.versionId}`, "get");
                    if (!isEmptyChack(addTask)) {
                        $(".addQuotesTask").html(addTask);
                        $(".ui.dropdown").dropdown();
                        dateDropdowns();
                    }
                    this.back = 'tasks';
                    break;
                case "notes":
                        this.title = "Notes";
                      /*   this.back = "quote_information"; */
                        this.notesFn('quote-notes','list');
                        break;
                case "notesList":
                        this.title = "Notes";
                        this.back = "quote_information";
                        this.notesFn('quote-notes','list');
                        break;
                case "addNotes":
                    this.title = "Notes";
                    this.back = "notes";
                    this.notesFn('quote-notes/add','add');
                    break;
                case "e_signature_quote_to_insured":

                    break;
                default:
                    break;
            }
        },
    }));
});

function queryParams(params) {
    let statusVal='',comma='';
    $('.customeFilter').find('input[type="checkbox"]:checked').each(function (index, element) {
            const val = $(element).val();
            statusVal += `${comma}${val}`
            comma =",";
    });
    params.statusVal = statusVal;
    return params
}
$(document).on('click', '.closeTask', function() {
    let closeTaskModel = $('#closeTaskModel').remodal();
    closeTaskModel.open()
});
$(document).on('click', '.reopenTask', function() {
    let reopenTaskModel = $('#reopenTaskModel').remodal();
    reopenTaskModel.open()
});
$(document).on('click', '.taskDataGet', async function() {
    let id = $(this).data('id');
    const url = BASE_URL + "task/" + id + "/edit";

    let result = await doAjax(url, 'get');

    if (result) {
        notes = result.notes ?? '';
        var html = `<div class="row text-left">
            <label for="notes" class="col-sm-1 col-form-label ">Notes</label>
            <div class="col-sm-9">
               ${notes}
            </div>
        </div>`;
        htmlAlertModel(html);

    }
});
$(document).on("click", ".policyDetails", async function (e) {
    const $this = $(this);
    const id = $this.data("id");
    let expand = false;
    if (!$this.hasClass("expand")) {
        $this.addClass("expand");
        $this.html('<i class="fa-solid fa-caret-down"></i>');
        const response = await doAjax(
            `${BASE_URL}quotes/policy-details/${id}`,
            "get",
            {},
            null,
            null,
            false
        );
        if (response.status) {
            let html = `<tr><td colspan="8">${response.view}</td></tr>`;
            $this.parents("table").find("tbody").html(html);
            $(".ui.dropdown").dropdown();
            amount();
            percentageInput();
            singleDatePicker($("#inception_date"));
            remotelyDropDown(
                ".insurance_companyDropdown",
                "common/entity/insurance_company"
                ,{istype:'quote'},
                response.insuranceJson
            );
            remotelyDropDown(
                ".general_agentDropdown",
                "common/entity/general_agent",{istype:'quote'},
                response.generalAgentJson
            );
            remotelyDropDown('.broker_dropdown',
            'common/entity/broker',{istype:'quote'}, response.brokerDataJson);
            $(".account_type input").change();
        }
    } else {
        $this.removeClass("expand");
        $this.html('<i class="fa-solid fa-caret-right"></i>');
        $this.parents("table").find("tbody").html(null);
    }
});

$(document).on("click", ".attachmentDetails", async function (e) {
    const $this = $(this);
    const id = $this.data("id");
    let expand = false;
    if (!$this.hasClass("expand")) {
        $this.addClass("expand");
        $this.html('<i class="fa-solid fa-caret-down"></i>');
        const response = await doAjax(
            `${BASE_URL}attachments/${id}/edit?quotesId=${editArr.id}&versionId=${this.versionId}&type=quotes`,
            "get",
            {},
            null,
            null,
            false
        );

        if (response) {
            let html = `<tr><td colspan="8">${response}</td></tr>`;
            $this.parents("table").find("tbody").html(html);
            $(".ui.dropdown").dropdown();
        }
    } else {
        $this.removeClass("expand");
        $this.html('<i class="fa-solid fa-caret-right"></i>');
        $this.parents("table").find("tbody").html(null);
    }
});
$(document).on("click", ".taskDetails", async function (e) {
    const $this = $(this);
    const id = $this.data("id");
    let expand = false;
    if (!$this.hasClass("expand")) {
        $this.addClass("expand");
        $this.html('<i class="fa-solid fa-caret-down"></i>');
        const response = await doAjax(
            `${BASE_URL}quotes/task-edit/${id}/edit?quotesId=${editArr.id}&versionId=${this.versionId}&type=quotes`,
            "get",
            {},
            null,
            null,
            false
        );

        if (response) {
            let html = `<tr><td colspan="8">${response}</td></tr>`;
            $this.parents("table").find("tbody").html(html);
            $(".ui.dropdown").dropdown();
        }
    } else {
        $this.removeClass("expand");
        $this.html('<i class="fa-solid fa-caret-right"></i>');
        $this.parents("table").find("tbody").html(null);
    }
});

$(document).on("click", ".expand_all", async function (e) {
    if($('.attachmentDetails').length > 0){
        $(".attachmentDetails:not(.expand)").click();
    }else if($('.tabDetails').length > 0){
        $(".tabDetails:not(.expand)").click();
    }else{
        $(".policyDetails:not(.expand)").click();
    }

});
$(document).on("click", ".collapse_all", async function (e) {
    if($('.attachmentDetails').length > 0){
        $(".attachmentDetails.expand").click();
    }else if($('.tabDetails').length > 0){
        $(".tabDetails.expand").click();
    }else{
        $(".policyDetails.expand").click();
    }
});
$(document).on("click", ".cancelList", async function (e) {

    $(this).parents('table').find('thead tr td:first').click();
});




$(document).on("click", ".saveData", async function (e) {
    let forM = $(this).parents("form");
    /* console.log(forM); */
    let isValid = isValidation(forM, (notClass = true));
    e.preventDefault();
    e.stopPropagation();
    $(this).attr("disabled", true);
    $(this).find(".button--loading").removeClass("d-none");
	$(forM).find(".alert-danger").remove();
    if (isValid) {
        let formClass = forM;
        let args = await serializeFilter(forM, (filter = true));
        if(forM.hasClass('quoteEditForm') || forM.hasClass('additionalInsuredsForm')){
            titleArr = formTitleObj(forM);
            args.push({name:"titleArr",value:titleArr});
        }
        let url = await forM.attr("action");
        let _method = forM.find(" input[name='_method']").val();
        _method = _method ?? "post";
        let data = await doAjax(
            url,
            _method,
            args,
            {
                dataType: "json",
            },
            formClass
        );

        if (data.status == true) {
            forM.find("input[name='logsArr']").val(null);
            if (forM.hasClass("editForm") && isEmptyChack(data.type)) {
                successAlertModel(data.msg, "", "url", "single");
            } else if (!isEmptyChack(data.type) && data.type == "policyModel") {
                successAlertModel(data.msg, data.url, "url",'hidebutton',[{
                    'text' : 'Add Another Policy',
                    'class' : 'btn btn-info',
                    'url' : data?.policy ?? '#',
                    'type' :'url',
                },{
                    'text' : 'Continue to Terms',
                    'class' : 'btn btn-secondary',
                    'url' :  data?.url ?? '#',
                    'type' :'url',
                }]);

            }else if (!isEmptyChack(data.type)) {
                successAlertModel(data.msg, data.action, "attr", "single");
            } else if (!isEmptyChack(data.url)) {
                successAlertModel(data.msg, data.url, "url",);
            } else if (!isEmptyChack(data.singleurl)) {
                successAlertModel(data.msg, data.singleurl, "url","single");
            } else {
                successAlertModel(data.msg, "", "url", "single");

            }
			const version = $(".termsPayment input[name='version']").val();
			const quote = $(".termsPayment input[name='quote']").val();
			termsData(quote,version);
        }else{
			$(forM).prepend('<div class="alert alert-danger" role="alert">'+data.msg+'</div>');
			$('html, body').animate({
				scrollTop: $(forM).offset().top - 20
			}, 'slow');
		}
    }
    $(this).find(".button--loading").addClass("d-none");
    $(".text_box").addClass("d-none");
    $(this).removeAttr("disabled", true);

});

let logsArr = {};
let prevValueArr = {};

if ($(".editForm").length > 0) {
    $(".editForm input:not([name='save_option']), .editForm select, .editForm textarea, .editForm radio,.editForm checkbox")
        .not('input[type="hidden"]')
        .each(function () {
            let fieldName = $(this).attr("name");
            let fieldType = $(this).attr("type");
            let prevValue = "";
            if (fieldType == "checkbox" || fieldType == "radio") {
                if (fieldName == "billing_schedule[]") {
                    let scheduleDays = editArr["billing_schedule"]?.split(",");
                    !isEmptyChack(scheduleDays) &&
                        $.each(
                            scheduleDays,
                            function (indexInArray, valueOfElement) {
                                $("input[name='billing_schedule[]'][value='"+valueOfElement+"']").click();
                            }
                        );
                } else {
                    $(
                        "input[name='" +
                            fieldName +
                            "'][value='" +
                            editArr[fieldName] +
                            "']"
                    ).attr("checked", "checked");
                }
            } else if ($(this)[0].type == "select-one") {
                let timeValue = editArr[fieldName];
                if (fieldName == "start_time" || fieldName == "end_time") {
                    timeValue = moment(timeValue, "HH:mm:ss").format("hh:mm A");
                }

                $(this)
                    .parent(".ui.dropdown")
                    .dropdown("set selected", timeValue);
                $(this).val(timeValue);
            } else {
                let fieldNameValue = editArr[fieldName];
                if ($(this).hasClass("singleDatePicker")) {
                    fieldNameValue = dateFormatChange(fieldNameValue);
                }
                $(this).val(fieldNameValue);
            }
        });
}

$(document).on("change", "input[name='account_type']", function () {
    var type = $(this).attr("type");
    if (type == "hidden") {
        var line_of_business = $(this).val();
    } else {
        var line_of_business = $("input[name='account_type']:checked").val();
    }

    var url = `${BASE_URL}quotes/get_line_of_business_data`;
    $.ajax({
        url: url,
        method: "post",
        data: {
            line_of_business: line_of_business,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (response) {
            if (response) {
                if (!isEmptyChack(response?.coverage_types)) {
                    let htmloption = `<option value=""></option>`;
                    $.each(
                        response?.coverage_types,
                        function (indexInArray, valueOfElement) {
                            htmloption += `<option value="${valueOfElement?.value}">${valueOfElement?.name}</option>`;
                        }
                    );
                    $("#coverage_type").html(htmloption);
                }
            }
            $("#coverage_type").dropdown("setup menu", {
                values: response?.coverage_types,
            });
            if (!isEmptyChack($("#coverage_type").data("selected"))) {
                let selectedValue = $("#coverage_type").data("selected");
                $("#coverage_type").dropdown("set selected", selectedValue);
            }
        },
    });
    $("input[name='pure_premium']").change();
});
$(document.body).on("change", "input[name='pure_premium']", function () {
    var currentElement = $(this);
    var agency = $("input[name='agency']").val();
    var insured = $("input[name='insured']").val();
    var line_of_business = $("input[name='account_type']:checked").val();
    var origination_state = $("input[name='origination_state']:checked").val();
    var pure_premium = $(this).val();
    var url = `${BASE_URL}quotes/check_pure_premium`;
    $.ajax({
        url: url,
        method: "post",
        data: {
            line_of_business: line_of_business,
            origination_state: origination_state,
            pure_premium: pure_premium,
            agency: agency,
            insured: insured,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (response) {
            if (!response.status) {
                $(currentElement).addClass("is-invalid");
                $(currentElement)
                    .parent()
                    .append(
                        '<div class="invalid-feedback">' +
                            response.error +
                            "</div>"
                    );
            } else {
                $(currentElement).removeClass("is-invalid");
                $(currentElement).parent().find(".invalid-feedback").remove();
            }
        },
    });
});
$(document).on("change", 'input[name="inception_date"]', function () {
    var currentinceptiondate = $(this).val();
    var termvalue = $('select[name="policy_term"]').val();
    termvalue = termvalue.replace("Months", "");
    termvalue = termvalue != "" ? termvalue : expirationdateterm;
    $("#expiration_date").val(formatDate(currentinceptiondate, termvalue));
    if (type_until_first_payment == "month") {
        $("#first_installment_date").val(formatDate(currentinceptiondate, "1"));
    } else {
        $("#first_installment_date").val(
            daysformatDates(currentinceptiondate, until_first_payment)
        );
    }
});
$(document).on("click", '.payModelsCancel', function () {
    let active_payment_methode = $('input[name="active_payment_methode"]').val();
    if(isEmptyChack(active_payment_methode)){
        $('#payment_method_ach').prop('checked',true)
    }else{
        $('input#payment_method_'+active_payment_methode).prop('checked',true)
    }
    clickcount =1
});
$(document).on("change", 'select[name="policy_term"]', function () {
    var termvalues = $(this).val();
    termvalues = termvalues.replace(" Months", "");
    termvalues = termvalues != "" ? termvalues : expirationdateterm;
    var currentinceptiondates = $('input[name="inception_date"]').val();
    $("#expiration_date").val(formatDate(currentinceptiondates, termvalues));
});
$(document.body).on("change", 'input[name="minimum_earned"]', function () {
    $(this).parent("div").find(".invalid-feedback").remove();
    $(this).removeClass("is-invalid");
    var current_minimum_earned = $(this).val();
    if (current_minimum_earned != "" && current_minimum_earned != undefined) {
        current_minimum_earned = current_minimum_earned.replace("%", "");
        if (parseInt(current_minimum_earned) < allowminimumearned) {
            $(this).after(
                '<small class="invalid-feedback">The minimum earned premium you selected was less than the minimum  of ' +
                    allowminimumearned +
                    "%.</small>"
            );
            $(this).addClass("is-invalid");
        } else if (parseInt(current_minimum_earned) > minimum_earnedvalue) {
            $(this).after(
                '<small class="invalid-feedback">The minimum earned premium you selected was less than the maximum  of ' +
                    minimum_earnedvalue +
                    "%.</small>"
            );
            $(this).addClass("is-invalid");
        }
    }
});
let card =null;
let clickcount = 1;
$(document).on("change", 'input[name="payment_method"]', async function () {
    var payment_method = $(this).val();
    if(clickcount > 1){
         return false;
    }
    clickcount++;
  
    $('.paymentReModel form').removeClass('creditCardForm');
    if (payment_method == "ach" || payment_method == "credit_card") {

        var inst = $(".paymentReModel").remodal({
            closeOnOutsideClick: false,
        });
        inst.open();
        $(".paymenttab").removeClass("active").addClass("d-none");
        $(".paymenttab").find("input,select").removeAttr("required");
        $(".paymenttab[data-tab='" + payment_method + "']")
            .addClass("active")
            .removeClass("d-none");
        $(".paymenttab[data-tab='" + payment_method + "']")
            .find("input.required,select.required")
            .attr("required", "required");
        let insuredId = $(".insuredhidden").val();
        const insuredUserData = await doAjax(
            BASE_URL + "common/get-user-details",
            "post",
            { eId: insuredId, type: "insured" },
            null,
            null,
            false
        );
        if (!isEmptyChack(insuredUserData)) {
            if (payment_method == "ach") {
                $(".paymentReModel")
                    .find('input[name="account_name"]')
                    .val(insuredUserData?.name);
            } else {

                $(".paymentReModel")
                    .find('input[name="card_holder_name"]').filter(function( index ) {
                        return isEmptyChack($(this).val());
                    }).val(insuredUserData?.name);
                $(".paymentReModel")
                    .find('input[name="mailing_address"]').filter(function( index ) {
                        return isEmptyChack($(this).val());
                    }).val(insuredUserData?.mailing_address);
                $(".paymentReModel")
                    .find('input[name="mailing_city"]').filter(function( index ) {
                        return isEmptyChack($(this).val());
                    }).val(insuredUserData?.mailing_city);
                $(".paymentReModel")
                    .find('input[name="mailing_state"]').filter(function( index ) {
                        return isEmptyChack($(this).val());
                    }).val(insuredUserData?.mailing_state);
                $(".paymentReModel")
                    .find('input[name="mailing_zip"]').filter(function( index ) {
                        return isEmptyChack($(this).val());
                    }).val(insuredUserData?.mailing_zip);
                $(".paymentReModel")
                    .find('input[name="email"]').filter(function( index ) {
                        return isEmptyChack($(this).val());
                    }).val(insuredUserData?.email);
            }
        }
        if (payment_method == "ach") {
        } else {
            dateDropdowns($(".dateDropdowns"));
            $(".paymentReModel .date-dropdowns").find(".day").hide();
        }

        if (payment_method == "credit_card" && $('#card-container-model').length > 0 && !$('.text_box').hasClass('d-none')) {
            $('.paymentReModel form').addClass('creditCardForm');
            card = await sqCardLoad("#card-container-model");
        } else {
            $(".paymenttab").find('form #card-container-model').html(null)
        }
        
        
        digitLimit(".digitLimit");
    } else {
        $(".mainForm").find(".model_details_fied").remove();
    }
    setTimeout(() => {
        clickcount = 1
    }, 3000);
});

$(document).on("click", ".paySave", async function (e) {
    let forM = $(this).closest(".paymentforms");
    let isValid = isValidation(forM, true);
    const tab = $(".paymenttab.active").data("tab");
    let token = '';
    if (forM.hasClass('creditCardForm')) {
        let showSqCard = false;
        if (forM.hasClass('creditCardForm')) {
            showSqCard = tab == 'credit_card'
        }
        token  = forM.find('input[name="sqtoken"]').val()
        
        if (showSqCard == true && $('.sqcard__payment').length > 0 && isEmptyChack(token)) {
            try {
                const cardResult = await card?.tokenize();
                console.log(cardResult);
                if (cardResult.status == 'OK') {
                    token = cardResult.token;
                    
                    forM.find('input[name="sqtoken"]').val(cardResult.token);
                    forM.find(".sq-card-wrapper").removeClass("sq-error");
                    $(this).click();
                }
            } catch (error) {
                isValid = false;
               /*  console.log(error); */
                console.log(error.msg);
            }
        }
        /*
     if (result.status === 'OK') { */
    }
    if (isValid) {
        let inputHtml = "";
        $(".paymenttab.active")
            .find("input,select")
            .each(function (index, element) {
                const type = $(element).attr("type");
                let val = $(element).val();
                const name = $(element).attr("name");

                if (type == "checkbox" || type == "radio") {
                    if ($(element).is(":checked")) {
                        val = $(element).val();
                    }
                    inputHtml += `<input type='hidden' name="${name}" value="${val}">`;
                } else {
                    inputHtml += `<input type='hidden' name="${name}" value="${val}">`;
                }
            });
      
        inputHtml += `<input type='hidden' name="sqtoken" value="${token}">`;
        inputHtml += `<input type='hidden' name="active_payment_methode" value="${tab}">`;
        inputHtml = `<div class="model_details_fied">${inputHtml}</div>`;
        if ($(".mainForm").find(".model_details_fied").length > 0) {
            $(".mainForm").find(".model_details_fied").remove();
        }
        $(".mainForm").append(inputHtml);
        $(".paymentReModel").remodal().close();
    }
    e.preventDefault();
    e.stopPropagation();
});




$(document).on("change", ".termsPayment input,.termsPayment .ui select", async function (e) {
    const version = $(".termsPayment input[name='version']").val();
    const quote = $(".termsPayment input[name='quote']").val();
    const name = $(this).attr('name');
    const val = $(this).val()?.replace("$", "")?.replace("%", "")?.replace(",", "");
   
	const response = await doAjax(`${BASE_URL}quotes/task-update/${quote}/${version}`,'post',{name:name,value:val});
	if(response.status){
		termsData(quote,version);
	}else{
		$(this).addClass("is-invalid");
		$(this).parent().append('<div class="invalid-feedback">'+response.msg+'<a href="javascript:void(0);" class="revertChangesTerm ml-2"><i class="fa-solid fa-arrow-rotate-left"></i></a></div>');
	}
});

$(document).on("change", ".agent_compensation_box input", async function (e) {
    const version = $(".termsPayment input[name='version']").val();
    const quote = $(".termsPayment input[name='quote']").val();
    const name = $(this).attr('name');
    const val = $(this).val()?.replace("$", "")?.replace("%", "")?.replace(",", "");
   
	const response = await doAjax(`${BASE_URL}quotes/compensation-update/${quote}/${version}`,'post',{name:name,value:val});
	if(response.status){
		termsData(quote,version);
		setTimeout(function(){
			$("#view_agent_compensation").prop('checked',true).change();
		},1000)
	}else{
		$(this).addClass("is-invalid");
		$(this).parent().append('<div class="invalid-feedback">'+response.msg+'<a href="javascript:void(0);" class="revertChangesTerm ml-2"><i class="fa-solid fa-arrow-rotate-left"></i></a></div>');
	}
});
$(document).on("click", ".revertChangesTerm", function(){
	const version = $(".termsPayment input[name='version']").val();
    const quote = $(".termsPayment input[name='quote']").val();
	termsData(quote,version);
});

$(document).on("change", "#loan_payment_schedule", function(){
	if($(this).is(":checked")){
		$(".loan_payment_schedule_box").show();
	}else{
		$(".loan_payment_schedule_box").hide();
	}
});
$(document).on("change", "#quote_exposure", function(){
	if($(this).is(":checked")){
		$(".quote_exposure_box").show();
	}else{
		$(".quote_exposure_box").hide();
	}
});
$(document).on("change", "#view_agent_compensation", function(){
	if($(this).is(":checked")){
		$(".agent_compensation_box").show();
	}else{
		$(".agent_compensation_box").hide();
	}
});

$(document).on("change", "#view_down_payment_rule", function(){
	if($(this).is(":checked")){
		$(".down_payment_rule_box").show();
	}else{
		$(".down_payment_rule_box").hide();
	}
});


 $(document).on("click", ".zinput-inline ", function(){
	$(this).find('input[name="payment_method"]:checked').trigger('change')
}); 


$(document).on('click','.change_card',function(){
   
    clickcount = 1;
    $('.paymentReModel .text_card').addClass('d-none');
    $('.paymentReModel .text_box').removeClass('d-none');
    $('input[name="payment_method"]:checked').trigger('change')
})
$(document).on('click','.change_card_cancel',function(){
    clickcount = 1;
    $('input[name="payment_method"]:checked').trigger('change')
})
$(document).on("change", ".underwriting_information_form input,.underwriting_information_form select",async function(e){
    let forM = $(this).parents("form");
    forM.find('input[type="radio"]').removeAttr('required') ;
    /* console.log(forM); */
    let isValid = isValidation(forM, (notClass = true));
    e.preventDefault();
    e.stopPropagation();
    let args = await serializeFilter(forM, (filter = true));
    let url = await forM.attr("action");
    if (isValid) {
        let  res = await doAjax(url,'post',args,null,null,null,false)
    }
});

 $('#quotes-esignature').on('load-success.bs.table', async function (e, data, status) {
     $('.versionsigdocumentid').html(data.documentId);
     $('.versionsigagentstatus').html(data.agentSignatureStatus);
     $('.versionsiginsuredstatus').html(data.isnuredSignatureStatus);
});



if(!isEmptyChack(quoteRequestActivationButtonIntervalStart)){
    quote_request_activation_button_interval =  setInterval( async () => {
        let quote_request_activation_button = await doAjax(`${BASE_URL}quotes/quote_request_activation_button/${editArr.id}`,'post',null,null,null,false);
        if(quote_request_activation_button.status == true){
            $('.quote_request_activation_button_div').html(quote_request_activation_button.html);
            clearInterval(quote_request_activation_button_interval);
            
        }
    }, 2000);
}