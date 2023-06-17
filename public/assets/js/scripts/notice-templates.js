
$(function () {
    "use script";
    subjectShowBySendBy();
    cronBoxShowByTemplateBy();
    let logsArr = {};
    let prevValueArr = {};


    function subjectShowBySendBy() {
        let selectVal = $('select[name="send_by"]').val();
        if (selectVal == "email") {
            $("input[name='subject']").attr("required", true).closest(".row").removeClass('d-none')
        } else {
            $("input[name='subject']").attr("required", false).closest(".row").addClass('d-none')
        }
    }

    function cronBoxShowByTemplateBy() {
        let selectVal = $('select[name="template_type"]').val();
        if (selectVal == "cron") {
            $(".cronBox").removeClass('d-none').find("input").attr("required", true);
        } else {
            $(".cronBox").addClass('d-none').find("input").attr("required", false);
        }
    }



    if ($(".editForm").length > 0 && typeof editArr !== "undefined") {
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
                    $(this)
                        .parent(".ui.dropdown")
                        .dropdown("set selected", [editArr[fieldName]]);
                    $(this).val(editArr[fieldName]);
                } else {
                     $(this).val(editArr[fieldName]);
                }
            });
    }



    $(document).on("change", 'select[name="send_by"]', function () {
        subjectShowBySendBy()
    });
    $(document).on("change", 'select[name="template_type"]', function () {
        cronBoxShowByTemplateBy()
    });

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
                    successAlertModel(data.msg, "", 'url', 'single');
                } else {
                    successAlertModel(data.msg, data);
                }
            }
        }
        $(this).find(".button--loading").addClass("d-none");
        $(this).removeAttr("disabled", true);
    });

    let noticeCodemirrorEditor;
    if ($('.noticeCodemirrorEditor').length > 0) {
        noticeCodemirrorEditor = codemirrorEditor($(".noticeCodemirrorEditor")[0])
    }

    if ($('.headernoticeCodemirrorEditor').length > 0) {
       /*  console.log("ddd"); */
        headernoticeCodemirrorEditor = codemirrorEditor($(".headernoticeCodemirrorEditor")[0])
    }
    if ($('.footernoticeCodemirrorEditor').length > 0) {
        footernoticeCodemirrorEditor = codemirrorEditor($(".footernoticeCodemirrorEditor")[0])
    }


    $(document).on("click", '.templatePreviewAdmin', function () {
        const style = editArr ?.css;
        var previewFrame = document.getElementById('templatePreview');
        var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
        preview.open();
        preview.write(noticeCodemirrorEditor.getValue());
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
});
