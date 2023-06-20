let card = null;
document.addEventListener("alpine:init", () => {
    Alpine.data("accountDetails", () => ({
        open: "account_information",
        back: null,
        tab: null,
        title: null,
        titleKey :null,
        token: $('meta[name="csrf-token"]').attr('content'),
        init() {
            $(".lodeHtmlData").removeClass("lodeHtmlData");
            $(".htmlData").html("");
        },
        tabs(tab = this.open) {
          
            this.open = tab;
            $(".menu .item").removeClass("d-none");
            $(this.$el).addClass("d-none");
            let title =  $(this.$el).text();
            $(".accountmaindropdown").find('.text').html(title)
        },
        async accountAlertInsertOrUpdate(id = null) {
            const response = await doAjax(
                `${BASE_URL}accounts/alert/create/${editId}`,
                "get",
                { id: id }
            );
            //console.log(response);
            if (!isEmptyChack(response)) {
                $(".htmlData").html(response);
                uiDropdown(".ui.dropdown");
                singleDatePicker(".singleDatePicker");
                dateDropdowns();
            }
            this.open = "htmlData";
            this.titleKey = 'account_alerts';
        },
        async accountAlertDetails(id = null) {
            const response = await doAjax(
                `${BASE_URL}accounts/alert/detilas/${editId}/${id}`,
                "post"
            );
            // console.log(response);
            if (!isEmptyChack(response)) {
                $(".htmlData").html(response);
                $("#accounts-account-alerts-history").bootstrapTable();
            }
            this.open = "htmlData";
            this.titleKey = 'account_alerts';
        },
        async policyDetails(id = null) {
            const response = await doAjax(`${BASE_URL}accounts/policy-details/${editId}/${id}`,"get");
            if (!isEmptyChack(response)) {

                $(".htmlData").html(response.view);
                uiDropdown();
                amount();
                percentageInput();
                singleDatePicker();
                remotelyDropDown(
                    ".insurance_companyDropdown",
                    "common/entity/insurance_company",
                    {},
                    response.insuranceJson
                );
                remotelyDropDown(
                    ".general_agentDropdown",
                    "common/entity/general_agent",
                    {},
                    response.generalAgentJson
                );
                $(".account_type input").change();
                titleJson = formTitleObj($(".htmlData").find('form'));
                if(!isEmptyChack(titleJson)){
                    $(".htmlData").find('form').append(`<input type='hidden' name='titleArr' value='${titleJson}'/>`);
                }
            }
            this.open = "htmlData";
            this.titleKey = 'add_new_policy';
        },
        async attachmentList() {
            const response = await doAjax(
                `${BASE_URL}attachments?accountId=${editId}&type=account`,
                "get"
            );
            //console.log(response);
            if (!isEmptyChack(response)) {
                $(".attachments").html(response);
            }
            this.back = "attachments";
        },
        async uploadAttachment(isPfa = false) {
            this.title = "Attachment";
            const response = await doAjax(
                `${BASE_URL}attachments/add?accountId=${editId}&type=account`,
                "get"
            );
            if (!isEmptyChack(response)) {
                $(".attachments").html(response);
                $(".ui.dropdown").dropdown();
            }
            this.open = "attachment_add";
            this.back = "attachments";
        },
        async logs() {
            $(`#${activePage}-logs`).bootstrapTable({
                url: `${BASE_URL}logs/${activePage}/${editId}`,
            });
        },
        async policiesEndorsments() {
            const response = await doAjax( `${BASE_URL}accounts/policies-endorsments/${editId}`, "post" ,{_token:this.token});
            if (!isEmptyChack(response)) {
                $(".htmlData").html(response.view);
            }
            this.open = "htmlData";
            this.titleKey = 'policies_endorsments';
        },
        async paymentScheduleHistory() {
            $(`#${activePage}-payment-schedule-table`)
                .bootstrapTable("destroy")
                .bootstrapTable({
                    url: `${BASE_URL}accounts/payment-schedule-history/${editId}`,
                    exportOptions: {
                        fileName: function () {
                            return "Payment Schedule History";
                        },
                    },
                });
            $(`#${activePage}-payment-schedule-table`).on(
                "load-success.bs.table",
                async function (e, data, status) {
                    $('.total_payment_row').remove();

                    $(this)
                        .find('tbody tr[data-index="'+data.activeIndex+'"]')
                        .addClass('bg-warning active');

                    let trHtml = `<tr class="total_payment_row">
                                <td colspan="3"></td>
                                <td>${data?.totalMonthlyPayment}</td>
                                <td>${data?.totalInterest}</td>
                                <td>${data?.totalPrincipal}</td>
                                <td colspan="3"></td>
                                </tr>`;
                    $(this).find("tbody tr:last").after(trHtml);
                }
            );
        },
        async notes() {
          /*   console.log(buttons()); */
            $(`#${activePage}-notes`)
            .bootstrapTable("destroy")
            .bootstrapTable({
                url: `${BASE_URL}accounts/notes/${editId}`,
            });
        },
        async accountNotes(id = null) {
            if(isEmptyChack(id)){
                var response = await doAjax(
                    `${BASE_URL}accounts/notes/create/${editId}`,
                    "get",
                    { id: id }
                );
            }else{
                var response = await doAjax(
                    `${BASE_URL}accounts/notes/edit/${editId}/${id}`,
                    "get",
                    { id: id }
                );
            }

            //console.log(response);
            if (!isEmptyChack(response)) {
                $(".htmlData").html(response);
                uiDropdown(".ui.dropdown");
                singleDatePicker(".singleDatePicker");
                dateDropdowns();
            }
            this.open = "htmlData";
            this.back = "notes";
            this.titleKey = 'notes';

        },
        async detailsNotes(id = null) {
            const response = await doAjax(
                `${BASE_URL}accounts/notes/details/${editId}/${id}`,
                "post",
                { id: id }
            );
            //console.log(response);
            if (!isEmptyChack(response)) {
                $(".htmlData").html(response);
                $(`#accounts-notes-append-list`).bootstrapTable();
            }
            this.open = "htmlData";
            this.back = "";
            this.titleKey = 'notes';

        },
        async noticeHistory() {

              $(`#${activePage}-notice-history`)
              .bootstrapTable("destroy")
              .bootstrapTable({
                  url: `${BASE_URL}accounts/notice-history/${editId}`,
              });
             setTimeout(() => {
                uiDropdown(".ui.dropdown");
             }, 1000);
        },
        async transactionHistory() {

            $(`#${activePage}-payment-transaction-history`)
            .bootstrapTable("destroy")
            .bootstrapTable({
                url: `${BASE_URL}accounts/payment-transaction-history/${editId}`,
            });

        },
       async dailyNoticeDetails(id=null) {
            const response = await doAjax(`${BASE_URL}accounts/notice/details/${editId}/${id}`,  "post");

            if(response){
                htmlAlertModelNotice(response?.template)
            }
        },
       async overrideDueDate(id=null) {
            const url = `${BASE_URL}accounts/change-payment-due-date/${editId}/${id}`;
            $("[data-remodal-id=overrideDueDate]").find('form').attr('action',url);
            $("[data-remodal-id=overrideDueDate]").remodal({closeOnOutsideClick: true}).open();
            singleDatePicker(".singleDatePicker");
        },
       async enterPayment(id=null) {
            const response = await doAjax( `${BASE_URL}accounts/enter-payment/${editId}`,  "get",{_token:this.token});
            if(response.status == true){
                  $('.enterPayment').html(response.view);
                  amount();
                  zipMask();
                  digitLimit();
                  $(".ui.dropdown").dropdown();
                  $(".payment_type select").trigger('change');
            }else{
                textAlertModel(true,response.msg);
                this.open = "account_information";
            }
        },
       async enterReturnPremiumCommission(id=null) {
            const response = await doAjax( `${BASE_URL}accounts/enter-peturn-premium-commission/${editId}`,  "post",{_token:this.token});
        // console.log(response);
            if(response.status == true){
          //      console.log(response);
                  $('.enterReturnPremiumCommission').html(response.view);
                  amount();
                  zipMask();
                  digitLimit();
                 uiDropdown();
                /*   $(".payment_type select").trigger('change');  */
            }else{
                textAlertModel(true,response.msg);
               // this.open = "account_information";
            }
        },
       async transactionHistoryDetails(id=null,type='') {
       
           if(type == 'emailReceipt'){
                $('.emailReceiptModel').find('form').find('input.id').val(id);
                var inst = $(".emailReceiptModel").remodal({
                    closeOnOutsideClick: false,
                }).open();
           }else{
                const response = await doAjax( `${BASE_URL}accounts/transaction-history-details/${editId}/${id}`,  "get",{_token:this.token});
                if(response.status == true){
                    htmlAlertModel(response.view,false,'Payment Details');
                }
           }
            
        },

        accountDetailsEffect() {
            if(this.open){
                const keyTitle = this.open != 'htmlData' ? this.open : this.titleKey;
                this.title = dropDownTitle?.[keyTitle];
            }
            switch (this.open) {
                case "attachments":
                    this.attachmentList();
                    break;
                case "account_information":
                    accountInformation(editId);
                    break;
                case "account_alerts":
                    $("#accounts-account-alerts").bootstrapTable("refresh");
                    this.back = "";
                    break;
                case "payment_schedule_history":
                    this.paymentScheduleHistory();
                    break;
                case "policies_endorsments":
                    this.policiesEndorsments();
                    break;
                case "logs":
                    this.logs();
                    break;
                case 'e_signature':
                    $('#quotes-esignature').bootstrapTable('refresh');
                case "notes":
                    this.notes();
                    this.back = "";
                    break;
                case "notice_history":
                    this.noticeHistory();
                    this.back = "";
                    break;
                case "payments_transaction_history":
                    this.transactionHistory();
                    this.back = "";
                    break;
                case "enter_payment":
                    this.enterPayment();
                case "enter_return_premium_commission":
                    this.enterReturnPremiumCommission();
                /* case "account_information_2":
                    this.enterPayment(); */
               /*  case "processPaymentCancel":
                    this.enterPayment();
                    this.open = "enter_payment"; */
                   /*  this.back = ""; */
                    break;
                default:
                    break;
            }
        },
    }));
});

let  paymentArr  = null;
    $(document).on("click", ".saveData", async function (e) {
        let forM = $(this).parents("form");
        let isValid = isValidation(forM, (notClass = true));
        
        if(forM.hasClass('enterPayment') || forM.hasClass('creditCardForm')){
            let showSqCard = false;
            if(forM.hasClass('enterPayment')){
                showSqCard =  forM.find('[name="payment_method"]').val() == 'Credit Card' 
            }else if(forM.hasClass('creditCardForm') ){
                showSqCard =  forM.find('[name="payment_method"]').val() == 'credit_card' 
            }
            if(showSqCard == true && $('.sqcard__payment').length > 0){
                try {
                    const cardResult = await card.tokenize();
                    if(cardResult.status == 'OK'){
                        forM.find('input[name="sqtoken"]').val(cardResult.token);
                        forM.find(".sq-card-wrapper").removeClass("sq-error");
                    }
                } catch ( error) {
                    console.log(error.msg);
                }
            }
           /*  
        if (result.status === 'OK') { */
        }
        
        e.preventDefault();
        e.stopPropagation();
        $(this).attr("disabled", true);
        $(this).find(".button--loading").removeClass("d-none");
        if (isValid) {
            let formClass = forM;
            let args = await serializeFilter(forM, (filter = true));
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
                } else if (
                    !isEmptyChack(data.type) &&
                    data.type == "policyModel"
                ) {
                    successAlertModel(data.msg, data.url, "url", "hidebutton", [
                        {
                            text: "Add Another Policy",
                            class: "btn btn-info",
                            url: data?.policy ?? "#",
                            type: "url",
                        },
                        {
                            text: "Continue to Terms",
                            class: "btn btn-secondary",
                            url: data?.url ?? "#",
                            type: "url",
                        },
                    ]);
                } else if (!isEmptyChack(data.type)) {
                    if(data.type == 'payment_due_date'){
                        $(`#${activePage}-payment-schedule-table`).bootstrapTable("refresh");
                        successAlertModel(data.msg, "", "url", "single");
                        forM.trigger('reset');

                    }else if(data.type == 'process'){
                        paymentArr = args;
                        $('.enterPayment').html(data.view)
                    
                    }else if(data.type == 'account'){
                        successAlertModel(data.msg, "", "url", "single");
                        accountInformation(editId);
                    }else if(data.type == 'attr'){
                        successAlertModel(data.msg, data.action, "attr", "single");
                    }else{
                        successAlertModel(data.msg, data.action, "attr", "single");
                    }

                } else if (!isEmptyChack(data.url)) {
                    successAlertModel(data.msg, data.url, "url");
                } else if (!isEmptyChack(data.singleurl)) {
                    successAlertModel(
                        data.msg,
                        data.singleurl,
                        "url",
                        "single"
                    );
                } else {
                    successAlertModel(data.msg, "", "url", "single");
                }
            }
        }
        $(this).find(".button--loading").addClass("d-none");
        $(this).removeAttr("disabled", true);
    });


$(document).on("click", ".attachmentDetails", async function (e) {
    const $this = $(this);
    const id = $this.data("id");
    let expand = false;
    if (!$this.hasClass("expand")) {
        $this.addClass("expand");
        $this.html('<i class="fa-solid fa-caret-down"></i>');
        const response = await doAjax(
            `${BASE_URL}attachments/${id}/edit?quotesId=${editId}&type=account`,
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
    if ($(".attachmentDetails").length > 0) {
        $(".attachmentDetails:not(.expand)").click();
    } else if ($(".tabDetails").length > 0) {
        $(".tabDetails:not(.expand)").click();
    } else {
        $(".policyDetails:not(.expand)").click();
    }
});
$(document).on("click", ".collapse_all", async function (e) {
    if ($(".attachmentDetails").length > 0) {
        $(".attachmentDetails.expand").click();
    } else if ($(".tabDetails").length > 0) {
        $(".tabDetails.expand").click();
    } else {
        $(".policyDetails.expand").click();
    }
});

$(document).on("click", "button[classbtn='downloadCsv']", async function (e) {
    $('.export .dropdown-item[data-type="csv"]').click();
});
$(document).on("change", ".noticeStatus select", async function (e) {
    let accountId = $(this).data('account');
    let id = $(this).data('id');
    let status = $(this).val();
    if(!isEmptyChack(status)){
        let prevnoticetype = $(this).data('notice');

		if(status != prevnoticetype){
			if(status == 'resend'){
                confirmationModel('Do you want to resend this notice?',{id:id,'class':'noticeStatusUpdate',type:status})
			}else{
                confirmationModel('Do you want to change the "How to Sent/How Sent" from '+prevnoticetype+' to '+status+'?',{id:id,'class':'noticeStatusUpdate',type:status})
			}

		}
    }

});
$(document).on("click", ".noticeStatusUpdate", async function (e) {
    let id = $(this).data('id');
    let type = $(this).data('type');
    let res = await doAjax(`${BASE_URL}accounts/notice-action-update/${id}`,'post',{type:type});
    if(res.status == true){
        successAlertModel(res.msg, "", '', "single");
        $(`#${activePage}-notice-history`)
        .bootstrapTable('refresh');
        setTimeout(() => {
            uiDropdown(".ui.dropdown");
         }, 1000);
    }

});


$(document).on("click", ".dailyNoticeDetails", async function (e) {
    let id = $(this).data('id');
    let account = $(this).data('account');
    const response = await doAjax(`${BASE_URL}accounts/notice/details/${account}/${id}`,  "post");
    if(response){
        htmlAlertModelNotice(response?.template)
    }
});


async function accountInformation(accountId){
    const response = await doAjax(`${BASE_URL}accounts/view-account/${accountId}`,  "post",{_token:$('meta[name="csrf-token"]').attr('content')});
    if(response.status ==true){
        $('.viewAccountDetails').html(response.view);
    }

}


/* Enter Payment Javascript Code  */
let convenienceFee =0,totalAmount = 0,convenienceShow=false,applyToInstallment =0,paymentType=null;
$(document).on('change','.payment_type select',async function (e) {
    paymentType = $(this).val();
    let accountId = $(this).parents('form').find('input[name="account_id"]').val();
    if(!isEmptyChack(accountId) && !isEmptyChack(paymentType)){
        $('.installmentAmountShow,.payoffAmountShow').addClass('d-none');
        if(paymentType == 'installment'){
            $('.installmentAmountShow').removeClass('d-none');
        }else{
            $('.payoffAmountShow').removeClass('d-none');
        }
    }
    $('.payment_method select').trigger('change');
});

const showConvenienceFee = async () => {
    let paymentType  = $('.enterPayment .payment_type select').val()?.toLowerCase();
    let payment_method  = $('.enterPayment .payment_method select').val()?.toLowerCase();
    let accountId       = $('.enterPayment').find('input[name="account_id"]').val();
    let amount          = $('.enterPayment').find('.amount_apply_installment input').val()?.replace("$",'')?.replace(",",'');
    let isTrue          = false;

    if(payment_method == "credit card" || payment_method == "echeck"){
        const response = await doAjax(`${BASE_URL}accounts/enter-payment/${accountId}`,"post",{_token:$('meta[name="csrf-token"]').attr('content'),'type':paymentType,'payment_method':paymentType,amount:amount},null,null,false);
        if(response.status){
            convenience_show    =  response.data.convenience_show;
            convenience_fee     =  response.data.convenience_fee;
            totalAmountPaid     =  parseFloat(response.data.amount) + parseFloat(convenience_fee);
        }
        if(payment_method == "credit card"){
            isTrue = true;
        }else if(payment_method == "echeck"){
            isTrue = true;
        }
        if(isTrue == true ){
            if(convenience_show == true){
                $('#convenience_fee').parents('td').addClass('convenience_fee');
                $('.convenience_fee').parents('tr').removeClass('d-none').find('input').val(convenience_fee);
            }else{
                $('.convenience_fee').parents('tr').removeClass('d-none').find('input').val(convenience_fee).attr('readonly','readonly');
                $('#convenience_fee').parents('td').removeClass('convenience_fee');
            }

        }
        totalAmountPaid = dollerFA(totalAmountPaid);
    }else{
        $('.convenience_fee').parents('tr').addClass('d-none').find('input').val(null);
        if(paymentType == 'installment'){
            totalAmountPaid =  $('.amount_apply_installment input').val();
        }else{
            totalAmountPaid =  $('.payoffAmountShow .total_amount_due').text();
        }
    }

    $('.total_amount_paid').text(totalAmountPaid);
    /* amount(); */
}


$(document).on('change','.payment_method select',async function (e) {
    let value = $(this).val()?.toLowerCase();
    $(this).parents('form').find('button.saveData').attr('type','submit');
    $("#card-container").html(null)
    $('.echeck').addClass('d-none').find('input.required,select.required,.required select').removeAttr('required');
    $('.credit_card_box').addClass('d-none').find('input.required,select.required,.required select').removeAttr('required');
    if(value == "credit card"){
        credit_card_box =  $('.credit_card_box').removeClass('d-none');
        if($('#card-container').length > 0){
            card = await sqCardLoad("#card-container");
            $(this).parents('form').find('button.saveData').attr('type','button');
        }
        credit_card_box.find('input.required,select.required,.required select').attr('required','required');
    }else if(value == "echeck"){
        $('.echeck').removeClass('d-none').find('input.required,select.required,.required select').attr('required','required');
    }
    showConvenienceFee();
});

$(document).on('input','.convenience_fee input',function (e) {
    let value = $(this).val()?.replace("$",'')?.replace(",",'');
    value = isEmptyChack(value) ? 0 : value;
    let  total_amount_paid = 0;
    if(paymentType == 'installment'){
        totalAmount = $('.amount_apply_installment input').val()?.replace("$",'')?.replace(",",'');
        totalAmount = parseFloat(totalAmount) ;
    }else{
        totalAmount = $('.payoffAmountShow .total_amount_due').text()?.replace("$",'')?.replace(",",'');;
    }
    total_amount_paid = parseFloat(totalAmount) + parseFloat(value);
    $('.total_amount_paid').text(dollerFA(total_amount_paid));
});


$(document).on('input','.amount_apply_installment input',function (e) {
    $('.payment_method select').trigger('change');
    let totalAmount = $(this).val()?.replace("$",'')?.replace(",",'');
    totalAmount = isEmptyChack(totalAmount) ? 0 : totalAmount;
    let value = $('.convenience_fee input').val()?.replace("$",'')?.replace(",",'');
    value = isEmptyChack(value) ? 0 : value;
    let total_amount_paid = parseFloat(totalAmount) + parseFloat(value);
    $('.total_amount_paid').text(dollerFA(total_amount_paid));
});



$(document).on('click','.savePayment',async function (e) {

    if(!isEmptyChack(paymentArr)){
        let result = await doAjax(`${BASE_URL}accounts/save-payment`,'post',paymentArr);
        if(result.status == true){
            successAlertModel(result.msg, result.url, "url", "hidebutton", [
                {
                    text: "Enter another Payment",
                    class: "btn btn-info",
                    url: result?.continue ?? "#",
                    type: "url",
                },
                {
                    text: "Cancel",
                    class: "btn btn-secondary",
                    url: result?.back ?? "#",
                    type: "url",
                },
            ]);
        }

    }

});

$(document).on('change','.paymentReModel input[name="type"]',async function(){
    let payment_method = $(this).val();
    if(payment_method ==  "credit_card" && $('#card-container-model').length > 0){
        card = await sqCardLoad("#card-container-model");
    } else{
        $(".paymenttab.active").find('form #card-container-model').html(null)
    }
    $(".paymenttab").removeClass("active").addClass("d-none");
    $(".paymenttab").find("input,select").removeAttr("required");
    $(".paymenttab[data-tab='" + payment_method + "']").addClass("active").removeClass("d-none");
    $(".paymenttab[data-tab='" + payment_method + "']").find("input.required,select.required").attr("required", "required");
    $(".paymenttab.active").find('.titleArr').remove()
    let insuredId = $(".insuredhidden").val();
    const insuredUserData = await doAjax( BASE_URL + "common/get-payment-details","post", { accountId: editId, type: payment_method }, null, null, false);
    if (!isEmptyChack(insuredUserData)) {

        $(".paymenttab.active").find('form').find('input,select').each(function (index, element) {
            // element == this
            let fieldName = $(this).attr("name");
            let fieldType = $(this).attr("type");
            let valueOfElement = insuredUserData[fieldName];
            if (fieldType == "checkbox" || fieldType == "radio") {
                $("input[name='" + fieldName + "'][value='" + valueOfElement + "']").trigger("change").prop("checked", true);
            }else if(fieldType == "text" || fieldType == "email" || fieldType == "tel"){
               /*  console.log(fieldName); */
                $("input[name='" + fieldName + "']").val(valueOfElement);
            }else if ($(this)[0].type == "select-one") {
                $(this).parent(".ui.dropdown").dropdown("set selected", valueOfElement);
                $(this).val(valueOfElement);
            }
        });
        
    }
    let titleJson = formTitleObj($(".paymenttab.active").find('form'));
    if(!isEmptyChack(titleJson)){
        $(".paymenttab.active").find('form').append(`<input type='hidden' class="titleArr" name='titleArr' value='${titleJson}'/>`);
    }
    
    zipMask();
    amount();
    uiDropdown();
    if (payment_method != "ach") {
        dateDropdowns($(".dateDropdowns"));
        $(".paymentReModel .date-dropdowns").find(".day").hide()
    } 
    digitLimit(".digitLimit");
})


$(document).on("click", '.payMenthodModel', async function () {
    var payment_method = $(this).data('type');
    var inst = $(".paymentReModel").remodal({
        closeOnOutsideClick: false,
    });
    inst.open();
   /*  console.log(payment_method); */
    $('.paymentReModel input[name="type"][value="'+payment_method+'"]').prop('checked',true).trigger('change')
});



$(document).on("change", '.emailReceiptSendTo select', async function () {
    let val = $(this).val();
    console.log(val);
    if(val == 'other'){
         $('.emailReceiptModel').find('.emailBox').removeClass('d-none').find('input').attr('required','required');
    }else{
        $('.emailReceiptModel').find('.emailBox').addClass('d-none').find('input').removeAttr('required');
    }

});


$(document).on("change", '.enterReturnPremiumCommissionForm .insurance_policy_coverage_type select', async function () {
    let val = $(this).val();
    if(!isEmptyChack(val)){
        const res = await doAjax( BASE_URL + "accounts/change-quote-policy/"+val,"post", { }, null, null, false);
        if(!isEmptyChack(res.options)){
            let option =  "<option value=''></option>";
            $.each(res.options, function (indexInArray, valueOfElement) { 
                option += `<option value='${valueOfElement.value}'>${valueOfElement.name}</option>`;
            });
            $('.enterReturnPremiumCommissionForm .return_premium_from select').html(option);
        }
     
        $('.enterReturnPremiumCommissionForm .return_premium_from').dropdown({values:res.options});
    }else{
        $('.enterReturnPremiumCommissionForm .return_premium_from select').html(null);
        $('.enterReturnPremiumCommissionForm .return_premium_from').dropdown({values: {}});
    }
});



