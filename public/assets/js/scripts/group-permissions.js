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
                forM.find("input[name='logsArr']").val(null);
                if (forM.hasClass('groupPermissions')) {
                    successAlertModel(data.msg, data.url,'url','single');
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
   // editArr = typeof editArr != undefined ? deflate(editArr) : [];
    if ($(".groupPermissions").length > 0) {
        $(".groupPermissions input, .groupPermissions select, .groupPermissions textarea")
        .not('input[type="hidden"]')
        .each(function () {
            let fieldName = $(this).attr("name");
            let fieldType = $(this).attr("type");
            let prevValue = "";

            if (fieldType == "radio") {
                console.log(editArr, fieldName);
                 $("input[name='" + fieldName + "'][value='" + editArr[fieldName] + "']").trigger("change").prop("checked", true);
            } else if (fieldType == "checkbox") {
                if (fieldName.indexOf('[]')) {
                    const checBoxname = fieldName.replace('[]', '').replace('[', '.').replace(']', '');
                    $('input[name="' + fieldName + '"]').each(function (index, element) {
                        // element == this
                        let dataKey = $(element).data('key');

                        if (fieldName.includes('permission')) {
                             value = editArr['permission']?.[dataKey] ?? []

                        } else if (fieldName.includes('report')) {
                             value = editArr['report']?.[dataKey] ?? []

                        } else {
                            value = editArr?.[checBoxname]  ?? []
                        }

                        $(element).filter(function () {
                            return $.inArray(this.value, value) !== -1;
                        }).prop("checked", "true");
                    });
                 }
            } else if ($(this)[0].type == "select-one") {
                $(this).parent(".ui.dropdown").dropdown("set selected", [editArr[fieldName]]);
                $(this).val(editArr[fieldName]);
            } else {
                $(this).val(editArr[fieldName]);
            }

        });
        amount();
    }



$(document.body).on("change", ".groupPermissions input,.groupPermissions select,.groupPermissions textarea", function () {
    editFormArr = editArr;
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
                        console.log((editArr['permission']?.[dataKey] ?? null));
                        value = editArr['permission']?.[dataKey] ?? []
                    } else if (name.includes('report')) {
                        value = editArr['permission']?.[dataKey] ?? []
                    } else {
                         value = editArr?.[checBoxname]  ?? []
                    }
            let checkBoxvalue = $this.val();
            if ($.inArray(checkBoxvalue, value) !== -1) {
                preValue = checkBoxvalue;
            }

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
    console.table(logsArr);
    $this.parents("form").find('input[name="logsArr"]').val(logsJosn);


});
});
