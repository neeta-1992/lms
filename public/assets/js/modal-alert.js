$(document).on('closed', '.remodal', function (e) {
    // Reason: 'confirmation', 'cancellation'
    $(".remodal-wrapper.remodal-is-closed").each(function (index, element) {
        // element == this
        let inserHtml = $(element).html();
        if (isEmptyChack(inserHtml)) {
            $(this).remove();
        }
    });
});
// Validate Select Multiple Tag
const modalSuccess = (msg = null, action = "", type = "url") => {
    let modelAttr = "";
    $(".remodal-overlay,.remodal-wrapper").remove();
    $("[data-remodal-id='successModel']").remove();
    if (type == "attr") {
        modelAttr = action;
    } else {
        modelAttr = `onclick = "location.href='${action}'"`;
    }
    modelHtml = `<div class="remodal" data-remodal-id="successModel"  data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                <button class="remodal-close" data-remodal-action="close"></button>
                <p>${msg}</p><br>
                <div class="buttons text-center">
                  <button class = "btn btn-sm btn-primary"  ${modelAttr}
                  data-remodal-action="confirm"> Ok </button>
                </div>
            </div>`;
    $("body").append(modelHtml);
    var inst = $("[data-remodal-id=successModel]").remodal();
    inst.open();
}
// Validate Select Multiple Tag
const successAlertModel = (msg = null, action = "", type = "url", btnType = null, extraButton = null, appendClass = null) => {
    let modelAttr = "";

    /*     $(".remodal-overlay,.remodal-wrapper").remove(); */
    $("[data-remodal-id='successAlertModel']").remove();

    modelHtml = `<div class="remodal" data-remodal-id="successAlertModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <button class="remodal-close remodalClose" data-remodal-action="close"></button>
                <h4>Success</h4>
                <p class="font-1 fw-300">${msg}</p><br>
                <div class="buttons">`;
    if (btnType == 'single' && btnType != 'hidebutton') {
        modelHtml += `<a href="javascript:void(0)" class="btn btn-sm btn-primary actionButton" data-remodal-action="confirm">
                        Ok </a>`;

    } else if (btnType != 'hidebutton' && btnType != 'cancel') {
        modelHtml += `<a href="javascript:void(0)"   class = "btn btn-sm btn-primary actionButton">
                        Continue </a>

                    <button class="btn btn-default btn-sm cancelButton" data-remodal-action="cancel">Exit</button>`;
    }
    if (!isEmptyChack(extraButton)) {
        /*  console.log(typeof(extraButton[0]) != 'undefined'); */
        if (typeof extraButton == 'object' && typeof (extraButton[0]) != 'undefined') {
            $.each(extraButton, function (indexInArray, valueOfElement) {
                if (valueOfElement.type == "url") {
                    modelHtml += `<a href="javascript:void(0)" data-url="${valueOfElement.url}" class="btn-sm ${valueOfElement.class} cancelButton" data-turbolinks="false" > ${valueOfElement.text}</a>`;
                } else {
                    modelHtml += `<a href="javascript:void(0)" class="btn btn-sm btn-info ${valueOfElement.class}" data-remodal-action="confirm" > ${valueOfElement.text}</a>`;
                }
            });
        } else {
            modelHtml += `<a href="javascript:void(0)"  data-remodal-action="close" class="btn btn-sm btn-info ${extraButton.class}">
            ${extraButton.text}</a>`;
        }

    }

    if (btnType == 'cancel') {
        modelHtml += ` <button class="btn btn-default btn-sm" data-remodal-action="cancel">Exit</button>`;
    }
    /* if(btnType == 'modelCancel') {
        modelHtml += ` <button class="btn btn-default btn-sm" data-remodal-action="cancel">Exit</button>`;
    } */
    /*   console.log(action); */
    modelHtml += `</div>
            </div>`;
    $("body").append(modelHtml);
    setTimeout(() => {
        if (type == "attr") {
            $("[data-remodal-id=successAlertModel] .actionButton").attr('x-on:click', action);
            //   $("[data-remodal-id=successAlertModel] .cancelButton").attr('x-on:click', action);
            if (btnType == 'modelCancel') {
                $("[data-remodal-id=successAlertModel] .cancelButton").removeClass('cancelButton');
            }
        } else {
            if (typeof action == "object") {
                $("[data-remodal-id=successAlertModel] .actionButton").attr('href', action.continue).attr('data-turbolinks', false)
                $("[data-remodal-id=successAlertModel] .cancelButton").attr('href', action.back).attr('data-turbolinks', false)
            } else {

                $("[data-remodal-id=successAlertModel] .actionButton").attr('onclick', (action && `location.href='${action}'`))
                if (btnType != 'modelCancel') {
                    $("[data-remodal-id=successAlertModel] .cancelButton").addClass('backUrl')
                } else {

                    $("[data-remodal-id=successAlertModel] .cancelButton").removeClass('cancelButton');

                }

            }
        }
    }, 500);

    const successAlertModelOptions = {
        closeOnOutsideClick: false,
        appendClass: appendClass
    };
    /*  console.log(successAlertModelOptions); */
    var inst = $("[data-remodal-id=successAlertModel]").remodal(successAlertModelOptions);
    inst.open();
}

const textAlertModel = (btnType = false, msg = null) => {
    /*    $(".remodal-overlay,.remodal-wrapper").remove(); */
    $("[data-remodal-id='textAlertModel']").remove();
    modelHtml = `<div class="remodal" data-remodal-id="textAlertModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                <button class="remodal-close" data-remodal-action="close"></button>
                <p class="font-1 fw-300">${msg}</p>`;
    if (btnType) {
        modelHtml += `<div class="buttons"><br><a href="javascript:void(0)" class="btn btn-sm btn-primary actionButton" data-remodal-action="confirm">Ok </a></div>`;
    }
    modelHtml += `</div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };
    var inst = $("[data-remodal-id=textAlertModel]").remodal(successAlertModelOptions);
    inst.open();
}


const htmlAlertModel = (html = null, btnType = false,heading='') => {
    /*    $(".remodal-overlay,.remodal-wrapper").remove(); */
    $("[data-remodal-id='htmlAlertModel']").remove();
    if(!isEmptyChack(heading)){
        heading = `<h4 class="mt-0">${heading}</h4>`;
    }
    modelHtml = `<div class="remodal text-left" data-remodal-id="htmlAlertModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                <button class="remodal-close" data-remodal-action="close"></button>
                 ${heading}
                ${html}`;
    if (btnType) {
        modelHtml += `<div class="buttons"><br><a href="javascript:void(0)" class="btn btn-sm btn-primary actionButton" data-remodal-action="confirm">Ok </a></div>`;
    }
    modelHtml += `</div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };
    var inst = $("[data-remodal-id=htmlAlertModel]").remodal(successAlertModelOptions);
    inst.open();
}


const htmlAlertModelNotice = (html = null, btnType = false) => {
    /*    $(".remodal-overlay,.remodal-wrapper").remove(); */
    $("[data-remodal-id='htmlAlertModel']").remove();
    modelHtml = `<div class="remodal text-left" data-remodal-id="htmlAlertModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                <button class="remodal-close" data-remodal-action="close"></button>
                <div class=" d-flex justify-content-end pr-2">
                    <div class="createdPrint mx-1" id="disclosureprint" data-content=".template_section" title=""><i class="fal fa-print"></i></div>
                    <div class="windowpop_close mx-1" data-remodal-action="close"><i class="fa-regular fa-circle-xmark"></i></div>
                </div>
                <div class="template_section" style="overflow: auto;
                height: 400px;">${html}</div>`;
    if (btnType) {
        modelHtml += `<div class="buttons"><br><a href="javascript:void(0)" class="btn btn-sm btn-primary actionButton" data-remodal-action="confirm">Ok </a></div>`;
    }
    modelHtml += `</div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: true,
    };
    var inst = $("[data-remodal-id=htmlAlertModel]").remodal(successAlertModelOptions);
    inst.open();
}

const confirmationModel = (msg = null, obj = null) => {
    let id = obj?.id ?? '';
    let url = obj?.url ?? '';
    let classText = obj?.class ?? '';
    let cancelUrl = obj?.cancelUrl ?? '';
    let type = obj?.type ?? '';
    $("[data-remodal-id='confirmationModel']").remove();
    modelHtml = `<div class="remodal" data-remodal-id="confirmationModel">
                    <button class="remodal-close" data-remodal-action="close"></button>
                    <p>${msg}</p><br>
                    <div class="buttons">
                        <button class="btn btn-sm btn-primary ${classText}" data-id="${id}"  data-type="${type}" data-url="${url}" data-remodal-action="confirm">Yes</button>
                        <button class="btn btn-default btn-sm cancelButton" data-url="${cancelUrl}" data-remodal-action="cancel">No</button>
                    </div>
                </div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };
    var inst = $("[data-remodal-id=confirmationModel]").remodal(successAlertModelOptions);
    inst.open();
}


const deleteModel = (msg = null, type = "attr", action = "", obj = null) => {
    /*    $(".remodal-overlay,.remodal-wrapper").remove(); */
    let id = obj?.id ?? '';
    let url = obj?.url ?? '';

    let title = obj?.title ?? 'Delete';
    $("[data-remodal-id='deleteModel']").remove();
    modelHtml = `<div class="remodal" data-remodal-id="deleteModel">
                    <button class="remodal-close" data-remodal-action="close"></button>
                    <h4>${title}</h4>
                    <p>${msg}</p><br>
                    <div class="buttons">
                        <button class="btn btn-sm btn-primary actionButton">Delete</button>
                        <button class="btn btn-default btn-sm" data-remodal-action="cancel">No</button>
                    </div>
                </div>`;
    $("body").append(modelHtml);

    setTimeout(() => {
        if (type == "attr") {
            $("[data-remodal-id=deleteModel] .actionButton").attr('x-on:click', action);

        } else {
            $("[data-remodal-id=deleteModel] .actionButton").attr('data-url', action);
        }
    }, 500);

    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };
    var inst = $("[data-remodal-id=deleteModel]").remodal(successAlertModelOptions);
    inst.open();
}



const iframeSingleAlertModel = (iframeContent = null, btnType = false, msg = null, style = null, type = null) => {

    $(".remodal-overlay,.remodal-wrapper").remove();
    $("[data-remodal-id='iframeSingleAlertModel']").remove();
    modelHtml = `<div class="remodal" data-remodal-id="iframeSingleAlertModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                <button class="remodal-close" data-remodal-action="close"></button>`;
    if (msg) {
        modelHtml += `<p class="font-1 fw-300">${msg}</p>`;
    }
    modelHtml += `<div class="row" id="videoModalIframeWrapper">
    <div class="col-md-12"><iframe id="iframeShowContent" class="w-100 border-0"  allowfullscreen="true" class="w-100 border-0 "  height="400"></iframe></div> </div>
    </div>`

    if (btnType) {
        modelHtml += `<div class="buttons"><br><a href="javascript:void(0)" class="btn btn-sm btn-primary actionButton" data-remodal-action="confirm">Ok </a></div>`;
    }
    modelHtml += `</div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };

    var inst = $("[data-remodal-id=iframeSingleAlertModel]").remodal(successAlertModelOptions);
    var dstFrame = document.getElementById('iframeShowContent');
    var dstDoc = dstFrame.contentDocument || dstFrame.contentWindow.document;
    dstDoc.write(iframeContent);
    dstDoc.close()
    $("#iframeShowContent").contents().find("head").append(`<style>${style}</style>`);
    inst.open();
}


const fileIframeModel = (url = null) => {

    $(".remodal-overlay,.remodal-wrapper").remove();
    $("[data-remodal-id='iframeSingleAlertModel']").remove();
    modelHtml = `<div class="remodal" data-remodal-id="iframeSingleAlertModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                <button class="remodal-close" data-remodal-action="close"></button>`;

    modelHtml += `<div class="row" id="videoModalIframeWrapper">
    <div class="col-md-12"><iframe src="${url}" id="iframeShowContent" class="w-100 border-0"  allowfullscreen="true" class="w-100 border-0 "  height="400"></iframe></div> </div>
    </div>`

    modelHtml += `</div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };
    var inst = $("[data-remodal-id=iframeSingleAlertModel]").remodal(successAlertModelOptions);
    //$("#iframeShowContent").contents().find("head").append(`<style>${style}</style>`);
    inst.open();
}


$(document).on('click', '.cancelButton', function () {
    let url = $(this).data('url');
    if (!isEmptyChack(url)) {
        window.location.href = url;
    }
  
    /* Turbolinks.visit(url) */
});
$(document).on('click', '.remodalClose', function () {
    const url = window.location.href;
    Turbolinks.visit(url)
});

$(document).on('click', '.deleteConfirmation', async function () {
    const url = $(this).data('url');
    let response = await doAjax(url, 'delete');
    if (response.status) {
        window.location.href = response.url;
    }
});
/* $(document).on('click', '.actionButton', function () {
     $('html').removeClass('remodal-is-locked');

}); */
