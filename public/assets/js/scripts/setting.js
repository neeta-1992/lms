$(function () {
    $(document).on("click", ".saveData", async function (e) {
        let forM = $(this).parents('form');
        let isValid = isValidation(forM, notClass = true);
        e.preventDefault();
        e.stopPropagation();
        $(this).attr("disabled", true);
        $(this).find(".button--loading").removeClass("d-none");
        if (isValid) {
            let formClass = forM;
            let args = await serializeFilter(forM, filter = true);
            let url = await forM.attr("action");
            let _method = forM.find(" input[name='_method']").val();
            _method = _method ?? "post";
            let data = await doAjax(url, _method, args, {
                dataType: "json",
            }, formClass);
            if (data.status == true) {
                if (forM.hasClass('editForm')) {
                     forM.find("input[name='logsArr']").val(null);
                    successAlertModel(data.msg, "", 'url', 'single');
                } else {
                    successAlertModel(data.msg, data);
                }
            }
        }
        $(this).find(".button--loading").addClass("d-none");
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
                    if (fieldName.indexOf("[]") > 0) {
                        fieldName = fieldName.replace("[]", '');
                        if(!isEmptyChack(editArr[fieldName]) &&  $.isArray(editArr[fieldName])){
                            valuecheckBox = editArr[fieldName];
                        }else{
                            valuecheckBox = editArr[fieldName]?.split(",");
                        }

                        valuecheckBox && $.each(valuecheckBox,function(indexInArray, valueOfElement) {

                            $("input[name='"+fieldName+"[]'][value='" + valueOfElement + "']").attr("checked",'checked').trigger("change");;
                        });

                    } else {
                        $("input[name='" + fieldName + "'][value='" + editArr[fieldName] + "']").trigger("change").prop("checked", true);
                    }
                } else if ($(this)[0].type == "select-one") {
                    let timeValue = editArr[fieldName];
                    if (fieldName == "start_time" || fieldName == "end_time") {
                        timeValue = moment(timeValue, "HH:mm:ss").format("hh:mm A");
                    }

                    $(this).parent(".ui.dropdown").dropdown("set selected", timeValue);
                    $(this).val(timeValue);
                } else {
                    let fieldNameValue = editArr[fieldName];
                    if ($(this).hasClass("singleDatePicker")) {
                        fieldNameValue = dateFormatChange(fieldNameValue);
                    }
                    $(this).val(fieldNameValue);
                }
            });
            amount();digitLimit();percentageInput();
    }
});
/* setTimeout(() => {
  $("#hold_all_payables").removeAttr("required");
}, 500); */
 $(document.body).on('keyup', '.digitLimit', function () {
     var value = $(this).val();
     var maxvalue = $(this).data("maxvalue");
     if (!isEmptyChack(maxvalue) && value > maxvalue) {
         $(this).val(maxvalue);
     }
 });
 $(document).on('change', 'input[name="payment_gateway"]', function () {
    $(".providers_box").addClass("d-none").find("input").removeAttr("required");
    const value = $(this).val();
    $(".providers_box[data-tab='" + value + "']").removeClass("d-none").find("input").attr("required",true);
 });

 $(document).on("change", ".show_select_box select", function () {
     let radioVal = $(this).val();
     let selectNAme = $(this).attr("name");
     if (!isEmptyChack(radioVal) && radioVal == "ACH per statement") {
         $(`.${selectNAme}_select_box`).removeClass('d-none').find('input').attr('required', true);
     } else {
         $(`.${selectNAme}_select_box`).addClass('d-none').find('input').removeAttr('required');
     }
 });

 $(document).on("change", "input[name='mailing_address_radio']", function () {
     let radioVal = $(this).val();
     if (!isEmptyChack(radioVal) && radioVal == "no") {
         $(".mailing_address_box").removeClass('d-none');
     } else {
         $(".mailing_address_box").addClass('d-none');
     }
 });

