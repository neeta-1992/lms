$(function () {
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
                 successAlertModel(data.msg, data);
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
let deleteFeeArr = {};
if ($(".editForm").length > 0) {
    $(".editForm input:not(.addRateTable input), .editForm select, .editForm textarea, .editForm radio,.editForm checkbox")
        .not('input[type="hidden"]')

        .each(function () {

            let fieldName = $(this).attr("name");
            let fieldType = $(this).attr("type");
            let prevValue = "";
            if ($(this).attr("type") == "checkbox" || $(this).attr("type") == "radio") {

                $(
                    "input[name='" +
                        fieldName +
                        "'][value='" +
                        editArr[fieldName] +
                        "']"
                ).attr("checked", "checked");
            } else if ($(this)[0].type == "select-one") {
                $(this)
                    .parent(".ui.dropdown")
                    .dropdown("set selected", [editArr[fieldName]]);
                 $(this).val(editArr[fieldName]);
            } else {
                $(this).val(editArr[fieldName]);
            }
        });
}

/* $(function () {
    console.log(editArr);
}); */

$(document).on("click", '.addRowTableFee', function () {
    let count = $(".addRateTable tbody tr").length + 1;
    let isValid = isValidation();
    if (!isValid) {
        return;
    }
    $(".addRateTable tbody svg").remove();
    let row = $(".addRateTable tbody tr:first").clone();
    let toValue = $(".addRateTable tbody tr:last").find(".to_amount").val();
    toValue = !isEmptyChack(toValue) ? (numberFilter(toValue) + 0.01) : 0;
    let id = `_${count}`;
    row.html(function (i, oldHTML) {
        return oldHTML.replaceAll("_1", id);
    });
    row.find('input:not(input[type="checkbox"])').val("");
    row.find('input[type="checkbox"]').prop("checked", false);
    row.find('.from_amount').val(toValue);
    $(".addRateTable tbody").append(row);
    var checkbxsCheckmark = Array.prototype.slice.call(document.querySelectorAll('.zinput.zcheckbox input[type="checkbox"]'));
    checkbxsCheckmark.forEach(function (el, i) {
        controlCheckbox(el, 'checkmark');
    });
    amount();
    percentageInput();
});

$(document).on("change", '.fee_amount_row', function () {
    const $this = $(this);
    let deleteId = $this.parents("tr").find('.feeTableRowId').val();
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
      $(this).parents('form').find('input[name="delete_rows"]').remove();
    $('.fee_amount_row:checked').each(function () {
        selected.push($(this).attr('name'));
    });
    if ($(".fee_amount_row").length === selected.length) {
        $('.addRateTable tbody tr:first').find('input:not(input[type="checkbox"])').val("");
        $('.addRateTable tbody tr:first').find('input[type="checkbox"]').prop('checked', false);
        $('.addRateTable tbody tr:first').removeClass("isDeleted");
        $('.addRateTable tbody').find(".isDeleted").remove();
    } else {
        $('.addRateTable tbody').find(".isDeleted").remove();
    }
    if ($(".allFeeAmount").is(":checked")) {
        $(".allFeeAmount").prop("checked", false)
    }
     $(this).parents('form').append(`<input type='hidden' value='${JSON.stringify(deleteFeeArr)}' name='delete_rows'>`)

});
$(document).on("change", '.allFeeAmount', function () {
    const $this = $(this);
    if ($this.is(":checked")) {
        $(".fee_amount_row").trigger("click");
        $('.addRateTable tbody').find("tr").addClass('isDeleted');
    } else {
         $(".fee_amount_row").prop("checked", false)
        $('.addRateTable tbody').find("tr").removeClass('isDeleted');
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

    $(".addRateTable tbody tr").not($this.parents("tr")).each(function (index, element) {
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

     $(".addRateTable tbody tr").not($this.parents("tr")).each(function (index, element) {
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

/* $(document).on("change", ".changesetup", function () {
    var type = $(this).attr('type');

    if (type == 'checkbox') {
        $(this).parents('tr').find(".setup_fee").val("$0.00");
    } else {
        $(this).parents('tr').find(".setup_fees").prop("checked", false);
    }
}); */



/* Agents Assigned  */

$(document).on("click", '.searchAgent', function () {
    $(".serchForm").addClass("d-none");
  $(".agentTable").removeClass("d-none")
});
});
