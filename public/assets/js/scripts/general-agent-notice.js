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
             successAlertModel(data.msg, "", 'url', 'single');
        }
    }
    $(this).find(".button--loading").addClass("d-none");
    $(this).removeAttr("disabled", true);
});

let logsArr = {};
let prevValueArr = {};

editArr = !isEmptyChack(editArr) ? deflate(editArr) : '';

$(document.body).on("change", "input,select,textarea", function () {
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
    if ($this.parents('table').hasClass('isTitleHeading')) {
        const cellIndex = $this.closest('td').index();
        // get the value of the matching header
        const headerVal = $this.closest("table").find("thead > tr > th").eq(cellIndex).html();
        title = `${title} ${headerVal}`;
    }
    lableText = !isEmptyChack(title) ? removeWhiteSpace(title) : '';
    let preValue = !isEmptyChack(editArr[newName]) ? editArr[newName] : '';
    let checkVal = '',
        comm = "";
    if (type == 'checkbox' || type == 'radio') {
        $("input[name='" + name + "']:checked").each(function (i) {
            checkVal += comm + $(this).val();
            comm = ",";
        });
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

    if (!isEmptyChack(editArr)) {
        const logsJosn = JSON.stringify(logsArr);
        $('.logsArr').remove();
        $this.parents("form").append(`<input type="hidden" class="logsArr" name="logsArr" value='${logsJosn}'>`);
    }

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

});


