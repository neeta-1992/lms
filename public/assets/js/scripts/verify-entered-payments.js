let formInfo = {};
let installmentArr = [],payoffArr = [],achId = null,allId = null;

document.addEventListener('alpine:init', () => {
    Alpine.data('findData', () => ({
        checkbox : null,
        init() {
           
        },
        allDropDown($el){
            if(!$el.checked){
                $('.userDropDown').removeClass('disabled');
                remotelyDropDown(".userDropDown","common/user-list",{type:"payment_user",'dropdown':true},null,'post');
            }else{
                $('.userDropDown').addClass('disabled');
                $('.userDropDown').dropdown('clear');
                $('.userDropDown select').removeAttr('required')
            }
        }
        ,async findForm(formData) {
            let fillerObj = objClean(formData);
            let isValid = isValidation($('.findForm'), (notClass = true));
            if (isValid) {
                let res = await doAjax(`${BASE_URL}payments/find-payment`,'post',fillerObj);
                if(!isEmptyChack(res)){
                    $('.htmlData').html(res);
                    this.open = 'findData';
                    $('#verify-entered-payments-find-payment').bootstrapTable();
                    $('.page_table_heading h4').text('Process Entered Payments');
                }
            }
        },
        async processEnteredFn(){
           
            if(installmentArr.length > 0 || payoffArr.length){
                let res = await doAjax(`${BASE_URL}payments/find-payment`,'post',{installment:installmentArr,payoff:payoffArr,'type':"process"});
                if(!isEmptyChack(res)){
                    $('.htmlData').html(res);
                    this.open = 'findData';
                    $('.page_table_heading h4').text('Process Entered Payments');
                    $('#verify-entered-payments-find-payment').bootstrapTable();
                }
            } else{
                this.open = 'findData';
            }
        },
        async commitProcessEntered(){
            if(installmentArr.length > 0 || payoffArr.length){
                let res = await doAjax(`${BASE_URL}payments/commit-process-entered`,'post',{installment:installmentArr,payoff:payoffArr,'type':"commit"});
                    if(!isEmptyChack(res) && res.status == true){
                        $('.htmlData').html(res.view);
                        this.open = 'findData';
                        $('#verify-entered-payments-commit-find-payment').bootstrapTable();
                        if(!isEmptyChack(res?.achId)){
                            achId = res.achId
                            $('button[data-action-download="nacha"]').removeClass('d-none') 
                        }else{
                            $('button[data-action-download="nacha"]').addClass('d-none') 
                        }
                        if(!isEmptyChack(res?.paymentId)){
                            allId = res.paymentId
                        }
                    
                    } else{
                        textAlertModel(true,res.msg);
                        this.open = 'findData'; 
                    }
             }  else{
                this.open = 'findData'; 
            }
        },
        async formEffect(){
        /*     console.log(this.open); */
            switch (this.open) {
                case 'isForm':
                    installmentArr = [];
                    payoffArr = [];
                    $('.page_table_heading h4').text('Verify Entered Payments');
                    break;
                case 'processEnteredFn':
                    this.processEnteredFn();
                    break;
                case 'commitProcessEntered':
                    this.commitProcessEntered();
                    break;
            
                default:
                    break;
            }
          /*   let res =  doAjax(`${BASE_URL}payments/find-payment`,'post',{installment:installmentArr,payoff:payoffArr});
          console.log(res); */
        }
    }))
})


$(document.body).on('change','#verify-entered-payments-find-payment .paymentmethod',function(){
    const $this = $(this);
    const value = $this.val();
    const type  = $this.data('type');
    if($this.is(':checked')){
        $(`.checkpayment[data-type="${type}"][data-method="${value}"]`).prop('checked',false);
        $(`.checkpayment[data-type="${type}"][data-method="${value}"]`).trigger('click'); 
    }else{
        $(`.checkpayment[data-type="${type}"][data-method="${value}"]`).prop('checked',true);
        $(`.checkpayment[data-type="${type}"][data-method="${value}"]`).trigger('click'); 
    }	
});


$(document.body).on('change','#verify-entered-payments-find-payment .checkpayment',function(){
    const $this = $(this);
    const value = $this.val();
    const type  = $this.data('type');
    const method  = $this.data('method');
    let allCheckBox =  $(`.checkpayment[data-type="${type}"][data-method="${method}"]`).length;
    if($this.is(':checked')){
        if(type == 'installment'){
            installmentArr.push(value);
        }else{
            payoffArr.push(value);
        }
        $(`.checkpayment[data-type="${type}"][data-method="${value}"]`).prop('checked',true); 
    }else{
        if(type == 'installment'){
            installmentArr.remove(value);
        }else{
            payoffArr.remove(value);
        }
    }	
});



$(document.body).on('click','button[data-action-download="nacha"]',function(){
    if(!isEmptyChack(achId)){
        window.location.href = BASE_URL+ `payments/download-nacha-file?id=`+ achId
    }
});
$(document.body).on('click','button[data-action-download="iif"]',function(){
    if(!isEmptyChack(allId)){
        window.location.href = BASE_URL+ `payments/download-iif-file?id=`+ allId
    }
    
});
