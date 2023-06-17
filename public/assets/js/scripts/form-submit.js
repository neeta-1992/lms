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
            let _method = forM.find("input[name='_method']").val();
            _method = _method ?? "post";
            let data = await doAjax(url, _method, args, {
                dataType: "json",
            }, formClass);

            if (data.status == true) {

                forM.find("input[name='logsArr']").val(null);
                forM.find(".flow-progress .removeUploedFile").addClass("noAjax").trigger('click');
                if (forM.hasClass('hasAlpine')) {
                    Alpine.start()
                }

                if (forM.hasClass('editForm') && !forM.hasClass('extraButton') && data.type != 'attr' && !forM.hasClass('reloadForm')) {

                    successAlertModel(data.msg, data.backUrl, 'url', 'single');
                } else if (forM.hasClass('extraButton')) {
                    successAlertModel(data.msg, "", 'url', 'single', extraButton = {
                        text: 'Save And Enable',
                        class: 'save_update_status',
                    });

                }  else if (forM.hasClass('singleForm')) {

                    successAlertModel(data.msg, "", 'url', 'single');

                } else if (forM.hasClass('reloadForm')) {

                    successAlertModel(data.msg,data.url, 'url', 'single');
                } else if (data.type == 'attr') {
                    successAlertModel(data.msg, data.action, 'attr', 'single');
                } else {

                     successAlertModel(data.msg, data);
                }
            }
            if (!isEmptyChack(data.isFee) && data.isFee == true) {
                forM.removeClass('extraButton')
            }
        }
        $(this).find(".button--loading").addClass("d-none");
        $(this).removeAttr("disabled", true);
    });


    let logsArr = {};
    let prevValueArr = {};
    let deleteFeeArr = {};

    if ($(".editForm").length > 0) {
        $(".editForm input, .editForm select, .editForm textarea, .editForm radio,.editForm checkbox")
            .not('input[type="hidden"],.addOtherFeeTable  input,input[type="file"]')
            .each(function () {

                let fieldName = $(this).attr("name");
                let fieldType = $(this).attr("type");

                let prevValue = "";
                 if (fieldType == "checkbox" || fieldType == "radio") {
                     if (fieldName.indexOf("[]") > 0) {
                         fieldName = fieldName.replace("[]", '');
                         if (!isEmptyChack(editArr[fieldName]) && $.isArray(editArr[fieldName])) {
                             valuecheckBox = editArr[fieldName];
                         } else {
                             valuecheckBox = editArr[fieldName]?.split(",");
                         }

                         valuecheckBox && $.each(valuecheckBox, function (indexInArray, valueOfElement) {

                             $("input[name='" + fieldName + "[]'][value='" + valueOfElement + "']").attr("checked", 'checked').trigger("change");;
                         });

                     } else {

                         $("input[name='" + fieldName + "'][value='" + editArr[fieldName] + "']").trigger("change").prop("checked", true);
                     }
                 } else if ($(this)[0].type == "select-one") {
                     let timeValue = editArr[fieldName];
                     if(!isEmptyChack(timeValue)){
                        if (fieldName == "start_time" || fieldName == "end_time") {
                            timeValue = moment(timeValue, "HH:mm:ss").format("hh:mm A");
                        }

                        $(this).parent(".ui.dropdown").dropdown("set selected", timeValue);
                        $(this).val(timeValue);
                     }

                 } else if ($(this)[0].type == "select-multiple") {
                    fieldName = fieldName?.replace("[]", '');

                    let values = editArr[fieldName]?.split(",")

                    $(this)
                        .parent(".ui.dropdown")
                        .dropdown("set selected", values);
                    //   $(this).val(editArr[fieldName]);
                } else if (fieldType == 'file') {
                    //currentvalue = $(this)[0].files[0] ? .name;

                } else {
                    /* console.log(fieldName); */
                    fieldName && $(this).val(editArr[fieldName]);
                }

            });
        amount();
    }

    $(document).on("click", '.addRowTableFee', function () {
        let count = $(".addOtherFeeTable tbody tr").length + 1;
        let isValid = isValidation();
        if (!isValid) {
            return;
        }
        $(".addOtherFeeTable tbody svg").remove();
        let row = $(".addOtherFeeTable tbody tr:first").clone();
        let toValue = $(".addOtherFeeTable tbody tr:last").find(".to_amount").val();
        toValue = !isEmptyChack(toValue) ? (numberFilter(toValue) + 0.01) : 0;
        let id = `_${count}`;
        row.html(function (i, oldHTML) {
            return oldHTML.replaceAll("_1", id);
        });
        row.find('input:not(input[type="checkbox"])').val("");
        row.find('input[type="checkbox"]').prop("checked", false);
        row.find('.from_amount').val(toValue);
        $(".addOtherFeeTable tbody").append(row);

        amount();
        percentageInput();
    });



    $(document).on("click", '.deleteRowTableFee', function () {
        let selected = [];
        $(this).parents('form').find('input[name="delete_rows"]').remove();
        $('.fee_amount_row:checked').each(function () {
            selected.push($(this).attr('name'));
        });

        if ($(".fee_amount_row").length === selected.length) {
            $('.addOtherFeeTable tbody tr:first').find('input:not(input[type="checkbox"])').val("");
            $('.addOtherFeeTable tbody tr:first').find('input[type="checkbox"]').prop('checked', false);
            $('.addOtherFeeTable tbody tr:first').removeClass("isDeleted");
            $('.addOtherFeeTable tbody').find(".isDeleted").remove();
        } else {
            $('.addOtherFeeTable tbody').find(".isDeleted").remove();
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

            $('.addOtherFeeTable tbody').find("tr").addClass('isDeleted');
        } else {
            $(".fee_amount_row").prop("checked", false)
            $('.addOtherFeeTable tbody').find("tr").removeClass('isDeleted');
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

        $(".addOtherFeeTable tbody tr").not($this.parents("tr")).each(function (index, element) {
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
        const $this = $(this);
        let toAmount = $this.val();
        toAmount = numberFilter(toAmount) ?? 0;
        let fromAmount = $this.parents("tr").find('.from_amount').val() ?? null;
        fromAmount = numberFilter(fromAmount) ?? 0;
        if (fromAmount > toAmount) {
            $this.parents("tr").find('.to_amount').val("")
        }

        $(".addOtherFeeTable tbody tr").not($this.parents("tr")).each(function (index, element) {
            let fromAmountE = $(element).find(".from_amount").val();
            let toAmountE = $(element).find('.to_amount').val() ?? null;
            fromAmountE = numberFilter(fromAmountE) ?? 0;
            toAmountE = numberFilter(toAmountE) ?? 0;
            if (inRange(toAmount, fromAmountE, toAmountE) || checkIfExistTimeForCal(fromAmount, toAmount, fromAmountE, toAmountE)) {
                $this.val("");
            }/*  else if (toAmount >= fromAmountE && toAmountE >= toAmount) {
            $this.val("");
         } */
        });
    });

    $(document).on("click", '.save_update_status', async function () {
        let forM = $('.editForm');

        forM.find("select[name='status']").closest(".ui.dropdown").removeClass('disabled')
            .dropdown("set selected", 1);
        forM.find("select[name='status']").trigger('change').val(1);
        forM.removeClass('extraButton');
        let formClass = forM;
        let args = await serializeFilter(forM, filter = true);
        let url = await forM.attr("action");

        let _method = forM.find("input[name='_method']").val();
        _method = _method ?? "post";
        let data = await doAjax(url, _method, args, {
            dataType: "json",
        }, formClass);

        if (data.status == true) {
            forM.find("input[name='logsArr']").val(null);
            if (forM.hasClass('editForm') && !forM.hasClass('extraButton')) {
                successAlertModel(data.msg, "", 'url', 'single');
            } else if (forM.hasClass('extraButton')) {
                successAlertModel(data.msg, "", 'url', 'single', extraButton = {
                    text: 'Save And Enable',
                    class: 'save_update_status',
                });
            } else {
                successAlertModel(data.msg, data);
            }
        }

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
    $(document).on('change', 'input[name="payment_gateway"]', function () {
        $(".providers_box").addClass("d-none").find("input").removeAttr("required");
        const value = $(this).val();
        $(".providers_box[data-tab='" + value + "']").removeClass("d-none").find("input").attr("required", true);
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

    $(document).on("change", '.monthsNumber select', function () {
        let value = parseInt($(this).val());
        daysList(".daysList", value);
    });




$(document.body).on("change", ".otherEditForm input,.otherEditForm select,.otherEditForm textarea", function () {
    editFormArr = !isEmptyChack(editFormArr) ? deflate(editFormArr) : {};
    const $this = $(this);
    const name = $this.attr('name');
    const type = $this.attr('type');
    let newName = name.replace('[]', '').replace('[', '.').replace(']', '');
    if (newName.indexOf('option') != -1) {
        newName = newName + '.send_type';
    } else if (newName.indexOf('send_to') != -1) {
        newName = newName.replace('send_to', 'option') + '.send_to';
    }
    let title = $this.parents('tr').find("td:first").text();
    if ($this.parents('table tr').hasClass('isTitleHeading')) {
        const cellIndex = $this.closest('td').index();
        // get the value of the matching header
        const headerVal = $this.closest("table").find("thead > tr > th").eq(cellIndex).html();
        title = `${title} ${headerVal}`;
    }
   /*   console.log(newName); */
    lableText = !isEmptyChack(title) ? removeWhiteSpace(title) : '';
    let preValue = !isEmptyChack(editFormArr[newName]) ? editFormArr[newName] : '';
    let checkVal = '',
        comm = "";
    if (type == 'checkbox' || type == 'radio') {
        $("input[name='" + name + "']:checked").each(function (i) {
            checkVal += comm + $(this).val();
            comm = ",";
        });
    } else if ($this[0].type == "select-one") {
        checkVal = $this.find('option:selected').text();

      /*   console.log( preValue); */
        preValue = $this.find('option[value="' + preValue + '"]').text();
      /*   console.log(checkVal, preValue); */

    } else {
        checkVal = $this.val();
    }



    logsArr[newName] = [];
    if (isEmptyChack(preValue)) {
        msg = `${lableText} was updated to <b>${checkVal}</b>`;
    } else {
        msg = `${lableText} was changed from <b>${preValue}</b> to <b>${checkVal}</b>`;
    }

    if (preValue !== checkVal) {
        logsArr[newName].push({
            key: newName,
            label: lableText,
            value: checkVal,
            prevValue: preValue,
            msg: msg,
        });
    } else {
        delete logsArr[newName];
    }
    delete logsArr["save_option"];
    if (Object.keys(logsArr).length > 0) {
        $this.parents("form").find("input[name='save_option'][value='save_and_reset']").prop("checked", true)
    }
   /*  console.log(logsArr); */
    if (!isEmptyChack(editArr)) {
        const logsJosn = JSON.stringify(logsArr);
        $this.parents("form").find('.logsArr').remove();
        $this.parents("form").append(`<input type="hidden" class="logsArr" name="logsArr" value='${logsJosn}'>`);
    }

});


     let codemirrorEditors;
    if ($('.codemirrorEditorEsignature').length > 0) {
        codemirrorEditors = codemirrorEditor($(".codemirrorEditorEsignature")[0])
    }


    $(document).on("click", '.templatePreviewAdmin', function () {
        const style = editArr ?.css;
        var previewFrame = document.getElementById('templatePreview');
        var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
        preview.open();
        preview.write(codemirrorEditors.getValue());
        preview.close();
        $("#templatePreview").contents().find("head").append(`<style>${style}</style>`);
        $('[data-remodal-id=templatePreviewModel]').remodal().open();
    });
    $(document).on("click", '.templatePreview', async function () {
        console.log("templatePreview");
        let noticeType = "notice-templates";
        let url = $(this).data('url') ?? 'null';
        const id = $("input[name='id']").val();;
        url = BASE_URL + `common/notice-template-data`;
        const result = await doAjax(url, 'post', {
            id: id,
        });
        let templateType = null,
            style = null;
        if (result.status == true) {
            if (!isEmptyChack(result.result?.template_text)) {
                templateType = result.result?.template_text;
                style = result?.style;
            }
        }
        if (isEmptyChack(templateType)) {
        } else {
            iframeSingleAlertModel(templateType, btnType = false, msg = null, style)
        }
    });


    $(document).on("input", "input.am_best_number", function () {
        let AM_best_number = $(this).val();

        if (!isEmptyChack(AM_best_number)) {
            $("input.am_best_url").val(`${AB_BEST_WEBSITE_URL}${AM_best_number}`);
        } else {
            $("input.am_best_url").val(null);
        }
    });


    $(document.body).on("change", ".groupPermissions input,.groupPermissions select,.groupPermissions textarea", function () {
            editFormArr = userPermission;
            const $this = $(this);
            let name = $this.attr('name');
            let dataKey = $this.data('key');
            const type = $this.attr('type');
            let lableText = titlelabelsTextForm($(this));
            let preValue = editFormArr[name] ? editFormArr[name] : "";
            if (type == 'radio') {
                $("input[name='" + name + "']:checked").each(function (i) {
                    checkVal += comm + $(this).val();
                    comm = ",";
                });
            } else if (type == "checkbox") {
                if (name.indexOf('[]')) {
                    const checBoxname = name.replace('[]', '').replace('[', '.').replace(']', '');
                    if (name.includes('permissions')) {

                        value = editFormArr['permission']?.[dataKey] ?? []
                    } else if (name.includes('report')) {
                        value = editFormArr['permission']?.[dataKey] ?? []
                    } else {
                         value = editFormArr?.[checBoxname]  ?? []
                    }
                    let checkBoxvalue = $this.val();
                    if ($.inArray(checkBoxvalue, value) !== -1) {
                        preValue = checkBoxvalue;
                    }
                   /*  console.log(preValue); */
                    name = checBoxname + checkBoxvalue;
                    const checkBoxText = $(this).closest('.checkbox_custom').find('label').text();
                    lableText = `${lableText} ${checkBoxText}`;
                    if (isEmptyChack(preValue) && $(this).is(':checked')) {
                        checkVal = "Enable";
                    } else if (!isEmptyChack(preValue) && $(this).is(':checked')) {
                        checkVal = "";
                        preValue = "";
                    } else if (!isEmptyChack(preValue) && !$(this).is(':checked')) {
                        checkVal = "Disable";
                        preValue = "Enable";
                    } else if (isEmptyChack(preValue) && !$(this).is(':checked')) {
                        checkVal = "";
                        preValue = "";
                    }
                }
            } else if ($this[0].type == "select-one") {
                checkVal = $this.find('option:selected').text();
                /*   console.log( preValue); */
                preValue = $this.find('option[value="' + preValue + '"]').text();
                /*   console.log(checkVal, preValue); */
            } else {
                checkVal = $this.val();
            }

            let prevlogsArr = $(this).parents("form").find("input[name='logsArr']").val();
            logsArr = {};
            if (!isEmptyChack(prevlogsArr)) {
                logsArr = JSON.parse(prevlogsArr);
            }
       /*  console.log(logsArr); */

            logsArr[name] = [];
            if (isEmptyChack(preValue)) {
                msg = `${lableText} was updated to <b>${checkVal}</b>`;
            } else {
                msg = `${lableText} was changed from <b>${preValue}</b> to <b>${checkVal}</b>`;
            }

            if (preValue !== checkVal) {
                logsArr[name].push({
                    key: name,
                    label: lableText,
                    value: checkVal,
                    prevValue: preValue,
                    msg: msg,
                });
            } else {
                delete logsArr[name];
            }
            delete logsArr["save_option"];
            if (Object.keys(logsArr).length > 0) {
                $this.parents("form").find("input[name='save_option'][value='save_and_reset']").prop("checked", true)
            }
            const logsJosn = JSON.stringify(logsArr);
          /*   console.log(logsArr); */
            $this.parents("form").find('input[name="logsArr"]').val(logsJosn);
        });

});


$(document).on("change", '.notices_description_radio', async function () {
    let noticeType = $(this).val();
    $(this).parents("tr").find('.noticeTemplateShow').attr('data-notice-type', noticeType);
});
$(document).on("click", '.noticeTemplateShow', async function () {
    let noticeType = $(this).attr('data-notice-type');

    noticeType = !isEmptyChack(noticeType) ? noticeType : 'null';
    let url = $(this).data('url') ?? 'null';
    url = `${url}/${noticeType}`;
    const result = await doAjax(url, 'post');
    let msg = "There is no Notice Template for this Notice.";
    let templateType = null,style=null;
  /*   console.log(result.result.template_text); */
    if (result.status == true) {
        if (!isEmptyChack(result.result?.template_text)) {
            templateType = result.result?.template_text;
            style = result?.style;
        }
    }

    if (isEmptyChack(templateType)) {
        textAlertModel(false, msg)
    } else {
        iframeSingleAlertModel(templateType, btnType = false, msg = null, style)
    }

  /*   console.log(result); */
});