$(function () {
const allmaskjs = () => {
    amount();
    percentageInput();
    percentageInput('percentage_input');
    if ($(".twodigitno").length > 0) {
        $(".twodigitno").each(function () {
            vanillaTextMask.maskInput({
                inputElement: $(this)[0],
                mask: textMaskAddons.createNumberMask({
                    allowDecimal: ".",
                    prefix: " $",
                    suffix: "",
                    thousandsSeparatorSymbol: ",",
                    allowDecimal: true,
                    decimalLimit: 2,
                    integerLimit: 2,
                }),
            });
        });
    }
    if ($(".twodigit").length > 0) {
        $(".twodigit").each(function () {
            vanillaTextMask.maskInput({
                inputElement: $(this)[0],
                mask: textMaskAddons.createNumberMask({
                    prefix: "",
                    suffix: "",
                    thousandsSeparatorSymbol: ",",
                    integerLimit: 2,
                }),
            });
        });
    }
};
allmaskjs();
$(document).on("click", ".saveData", async function (e) {
    let forM = $(this).parents('form');
    let isValid = isValidation(forM,notClass=true);
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
                successAlertModel(data.msg, "",'url','single');
            } else {
                successAlertModel(data.msg, data);
            }
        }
    }
    $(this).find(".button--loading").addClass("d-none");
    $(this).removeAttr("disabled", true);
});



$(document.body).on("keyup", ".percentageInput", function () {
    let percentage_inputvalue = $(this).val();
    percentage_inputvalue = percentage_inputvalue.replace("%", "");
    if (percentage_inputvalue > 100) {
        $(this).val("100%");
    }
});
$(document.body).on("keyup", ".percentageinput", function () {
    let percentageinputvalue = $(this).val();
    percentageinputvalue = percentageinputvalue.replace("%", "");
    if (percentageinputvalue > 100) {
        $(this).val("100");
    }
});
let logsArr = {};
let prevValueArr = {};
if ($(".editForm").length > 0) {
    $(".editForm input:not(.from_amount,.to_amount,.rate_tab,.no_editd), .editForm select, .editForm textarea, .editForm radio,.editForm checkbox")
        .not('input[type="hidden"]').each(function () {
        let fieldName = $(this).attr("name");
        let fieldType = $(this).attr("type");
        let prevValue = "";
      if (fieldType == "radio") {
           $("input[name='"+fieldName+"'][value='" + editArr[fieldName] + "']").attr('checked', 'checked');
        }else if ($(this)[0].type == "select-one") {
            $(this).parent(".ui.dropdown").dropdown("set selected", [editArr[fieldName]]);
            $(this).val(editArr[fieldName]);
        } else {
           $(this).val(editArr[fieldName]);
        };
    allmaskjs();
  });
}
});




$(document).on("blur", '.from_amount', function () {
    const $this = $(this);
    let fromAmount = $this.val();
    fromAmount = numberFilter(fromAmount) ?? 0;
    let toAmount = $this.parents("tr").find('.to_amount').val() ?? null;
    toAmount = numberFilter(toAmount) ?? 0;
    if (toAmount < fromAmount) {
        $this.parents("tr").find('.to_amount').val("")
    }

    $(this).parents('.mainRow').find(".addRateTable tbody tr").not($this.parents("tr")).each(function (index, element) {
        let fromAmountE = $(element).find(".from_amount").val();
        let toAmountE = $(element).find('.to_amount').val() ?? null;
        fromAmountE = numberFilter(fromAmountE) ?? 0;
        toAmountE = numberFilter(toAmountE) ?? 0;
        if (inRange(fromAmount, fromAmountE, toAmountE)) {
            $this.val("");
        }
    });

});

$(document).on("blur", '.to_amount', function () {
    const $this  = $(this);
    let toAmount = $this.val();
    toAmount     = numberFilter(toAmount) ?? 0;
    let fromAmount = $this.parents("tr").find('.from_amount').val() ?? null;
    fromAmount = numberFilter(fromAmount) ?? 0;
    if (fromAmount > toAmount) {
        $this.parents("tr").find('.to_amount').val("")
    }

    $(this).parents('.mainRow').find(".addRateTable tbody tr").not($this.parents("tr")).each(function (index, element) {
         let fromAmountE = $(element).find(".from_amount").val();
         let toAmountE = $(element).find('.to_amount').val() ?? null;
         fromAmountE = numberFilter(fromAmountE) ?? 0;
         toAmountE = numberFilter(toAmountE) ?? 0;
         if (inRange(toAmount, fromAmountE, toAmountE) || checkIfExistTimeForCal(fromAmount,toAmount, fromAmountE, toAmountE)) {
             $this.val("");
         }/*  else if (toAmount >= fromAmountE && toAmountE >= toAmount) {
            $this.val("");
         } */
     });
});


$(document).on("click", '.addRowTableFee', function () {
    let count = $(this).parents('.mainRow').find(".addRateTable tbody tr").length + 1;
    let isValid = isValidation();
    if (!isValid) {
        return;
    }
    $(this).parents('.mainRow').find(".addRateTable tbody svg").remove();
    let row = $(this).parents('.mainRow').find(".addRateTable tbody tr:first").clone();
    let toValue = $(this).parents('.mainRow').find(".addRateTable tbody tr:last").find(".to_amount").val();
    toValue = !isEmptyChack(toValue) ? (numberFilter(toValue) + 0.01) : 0;
    let id = `_${count}`;
    row.html(function (i, oldHTML) {
        return oldHTML.replaceAll("_1", id);
    });
    row.find('input:not(input[type="checkbox"],.type)').val("");
    row.find('input[type="checkbox"]').prop("checked", false);
    row.find('.from_amount').val(toValue);
    $(this).parents('.mainRow').find(".addRateTable tbody").append(row);
    
    amount();
    percentageInput();
});

let deleteFeeArr = {};
$(document).on("change", '.fee_amount_row', function () {
    const $this     = $(this);
    const val       = $(this).val();
    let deleteId    = $this.parents("tr").find('.feeTableRowId').val();

    if ($this.is(":checked")) {
        deleteFeeArr[deleteId] = deleteId
        $this.parents("tr").addClass('isDeleted');
    } else {
        delete deleteFeeArr[deleteId];
        $this.parents("tr").removeClass('isDeleted');
    }

});

$(document).on("click", '.deleteRowTableFee', function () {
    let selected = [];
    $(this).parents('.mainRow').find('input[name="delete_rows"]').remove();
    $(this).parents('.mainRow').find('.fee_amount_row:checked').each(function () {
        selected.push($(this).attr('name'));
    });
   
    if ($(this).parents('.mainRow').find(".fee_amount_row").length === selected.length) {
        $(this).parents('.mainRow').find('.addRateTable tbody tr:first').find('input:not(input[type="checkbox"],.type)').val("");
        $(this).parents('.mainRow').find('.addRateTable tbody tr:first').find('input[type="checkbox"]').prop('checked', false);
        $(this).parents('.mainRow').find('.addRateTable tbody tr:first').removeClass("isDeleted");
        $(this).parents('.mainRow').find('.addRateTable tbody').find(".isDeleted").remove();
    } else {
        $(this).parents('.mainRow').find('.addRateTable tbody').find(".isDeleted").remove();
    }
    if ($(this).parents('.mainRow').find(".allFeeAmount").is(":checked")) {
        $(".allFeeAmount").prop("checked", false)
    }
    $(this).parents('.mainRow').append(`<input type='hidden' value='${JSON.stringify(deleteFeeArr)}' name='delete_rows'>`)

});