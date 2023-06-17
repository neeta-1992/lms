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
            if (forM.hasClass('editForm')) {
                successAlertModel(data.msg, "",'url','single');
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
    $(".editForm input, .editForm select, .editForm textarea, .editForm radio,.editForm checkbox")
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
            /* tin(); sstin(); */
        });
}

});
