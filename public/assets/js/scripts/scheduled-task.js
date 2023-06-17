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
                    if (fieldName == "schedule_days[]") {
                        let scheduleDays = editArr["schedule_days"] ?.split(',');
                        !isEmptyChack(scheduleDays) && $.each(scheduleDays, function (indexInArray, valueOfElement) {
                            $("input[name='schedule_days[]'][value='" + valueOfElement + "']").click();
                        });
                    } else {
                        $("input[name='" +
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

                    $(this).parent(".ui.dropdown").dropdown("set selected", timeValue);
                    $(this).val(timeValue);
                } else {
                    let fieldNameValue = editArr[fieldName];
                    if ($(this).hasClass("singleDatePicker")) {
                        fieldNameValue = !isEmptyChack(fieldNameValue)? dateFormatChange(fieldNameValue) : null;
                    }
                    $(this).val(fieldNameValue);


                }
            });
    }
    let financeAgreementCodemirrorEditor;
    if ($('.financeAgreementCodemirrorEditor').length) {
        CodemirrorEditorPreview = codemirrorEditor($(".financeAgreementCodemirrorEditor")[0])
    }

    $(document).on("click", '.templatePreview', function () {
        /* $(".remodal-overlay").remove(); */
        /*    $("[data-remodal-id='templatePreviewModel']").remove(); */
        var previewFrame = document.getElementById('templatePreview');
        var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
        preview.open();
        preview.write(CodemirrorEditorPreview.getValue());
        preview.close();
        $('[data-remodal-id=templatePreviewModel]').remodal().open();
    });
});
