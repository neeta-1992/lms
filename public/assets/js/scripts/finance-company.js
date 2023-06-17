$(document.body).on("change", 'select[name ="tin_select"]', function () {
  var tin_select = $(this).val();
  if (tin_select == "EIN") {
    $('input[name ="tin"]')
      .removeClass("sstin")
      .addClass("tin")
      .attr("placeholder", "xx-xxxxxxx");
    tin();
  } else {
    $('input[name ="tin"]')
      .removeClass("tin")
      .addClass("sstin")
      .attr("placeholder", "xxx-xx-xxxx");
    sstin();
  }
});
$(document).on("change", "input[name='date_format']", function () {
    var dateformat = $(this).val()?.toLowerCase();;
    if (dateformat == "custom") {
        $(".dateformatvalue").attr("required", true);
    } else {
       setTimeout(() => {
            $(".dateformatvalue").val(" ").removeAttr("required");
       }, 500);
    }
});
$(document).on("change", "input[name='time_format']", function () {
    var timeformat = $(this).val()?.toLowerCase();
  if (timeformat == "custom") {
    $(".timeformatvalue").attr("required", true);
  } else {
    setTimeout(() => {
        $(".timeformatvalue").removeAttr("required").val(" ");
    }, 500);

  }
});

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
            successAlertModel(data.msg, data.backurl, 'url', 'single');
        }
    }
    $(this).find(".button--loading").addClass("d-none");
    $(this).removeAttr("disabled", true);
});


$(document).on("click", ".deactiveCompany", async function (e) {
        e.preventDefault();
        e.stopPropagation();
        const id = $(this).data('id');
        confirmationModel(`Are you sure you want to deactive ${editArr.comp_name}.Please click to confirm.Are you sure?`, {
            id: id,
            class: "deactiveCompanyUser",
        });
});
$(document).on("click", ".deactivefinancecompany", async function (e) {
    e.preventDefault();
    e.stopPropagation();
    const id = $(this).data('id');
    let data = await doAjax(BASE_URL + 'finance-company/deactive-user-confirmation', 'post', {
            id: id
        }, {
        dataType: "json",
    });
    if (data.status == true) {
        window.location.href = data.url
    }
});


$(document).on("click", ".activeCompany", async function (e) {
    e.preventDefault();
    e.stopPropagation();
    const id = $(this).data('id');
    let data = await doAjax(BASE_URL + 'finance-company/active-company', 'post', {
            id: id,status:1
        }, {
        dataType: "json",
    });
    if (data.status == true) {
        successAlertModel(data.msg, data.url, 'url', 'single');
    }
});


$(document).on("click", ".deactiveCompanyUser", async function (e) {
    e.preventDefault();
    e.stopPropagation();
    const id = $(this).data('id');
    let data = await doAjax(BASE_URL + 'finance-company/deactive-user', 'post', {
            id: id
        }, {
        dataType: "json",
    });
    if (data.status == true) {
        window.location.href = data.url
    }
});



let logsArr = {};
let prevValueArr = {};
if ($(".editForm").length > 0) {

    $(".editForm input, .editForm select, .editForm textarea").not('input[type="hidden"]').each(function () {
        let fieldName = $(this).attr("name");
        let fieldType = $(this).attr("type");
        let prevValue = "";
        if ( $(this).attr("type") == "checkbox" || $(this).attr("type") == "radio" ) {

            $("input[name='" + fieldName +
                    "'][value='" +
                    editArr[fieldName] +
                    "']"
            ).trigger("change").attr("checked", "checked");
        } else if ($(this)[0].type == "select-one") {
            $(this)
                .parent(".ui.dropdown")
                .dropdown("set selected", [editArr[fieldName]]);
            $(this).val(editArr[fieldName]);
        } else {
            $(this).val(editArr[fieldName]);
        }
        tin(); sstin();
    });

}
