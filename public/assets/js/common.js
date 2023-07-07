$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if(!isEmptyChack(toolTip)){
        toolTip = JSON.parse(toolTip);
        $.each(toolTip, function (indexInArray, valueOfElement) { 
            let toolTipField = valueOfElement.field;
            let toolTipDescription = valueOfElement.description;
            let toolTipTitle = valueOfElement.title;
            let html = `<i class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup" data-sm-title="${toolTipTitle}" data-sm-content="${toolTipDescription}"></i>`;
           /*  if($(`[name="${toolTipField}"]`).parents('.row,.form-group').find('.tooltipPopup') != 0){ */
                $(`[name="${toolTipField}"]`).parents('.row,.form-group').children('label').append(html);
            /* } */
           
            tooltipPopup();
        });
    }

    /* make checkbox behave like radio buttons  */
    $(document).on("change", '.checkboxradio', function (event) {
        let name = $(this).attr('name');
        let required = $(this).is(':required');
        if(required){
            $("input[name='"+name+"']").addClass('is_required');
        }
        if($(this).is(':checked')){
            $("input[name='"+name+"']").prop('checked',false);
            $(this).prop('checked',true);
            if($(this).hasClass('is_required')){
                $("input[name='"+name+"']").removeAttr('required');
            }
        }else{
            if($(this).hasClass('is_required')){
                $("input[name='"+name+"']").attr('required','required');
                $("input[name='"+name+"']").removeClass('is_required');
            }
        }
    });


    /*
      This Code Use Remove Focus For Input,Select  And All Tags
    */
    if ($('form label').length > 0) {
         $('form label').not('.zinput label,.checkbox_custom label').attr("for", "");
    }
    if ($('form.disabled').length > 0) {
         $('form.disabled').find('input,select').attr("disabled", "disabled");
    }


   /*  if (typeof toTitleCase == 'function') {
        if ($('form label').length > 0) {
            $('form label:not(.ingnorTitleCase)').each(function (index, element) {
                    let extraContents = "";
                    if ($(this).find('i,span,input').length > 0) {
                        extraContents = $(this).find('i,span,input');
                    }
                    let text = $(this).text();
                    text = toTitleCase(text);
                    $(this).text(text);
                    $(this).append(extraContents);
            });
        }
        /// $('textarea,input').not('input.username').addClass('toTitleCase');
    } */


    let tableIdArr = {};
    $(document).on("click", '.tableSelectCheckBox', function (event) {
        const $this = $(this);
        let deleteId = $this.val();
        if ($this.is(":checked")) {
            tableIdArr[deleteId] = deleteId
            $this.parents("tr").addClass('isDeleted');
        } else {
            delete tableIdArr[deleteId];
            $this.parents("tr").removeClass('isDeleted');
        }
    });

    let cancelButton = null;
    $(document).on("click", '.deleteRow', async function (e) {
        e.preventDefault();
        e.stopPropagation();
        let attr     =  $(this).attr('data-attr');
        let URL     =  $(this).attr('data-url');
        let text    =  $(this).attr('data-text');
        text        =  isEmptyChack(text) ?  `Are you sure?` : `Do you want to delete ${text}?`;

        if(!isEmptyChack(URL)){
            if($(this).hasClass('deleteSuccess')){
                let result = await doAjax(URL, 'delete');
                if(result.status == true){
                    if(result.type == "attr"){
                        cancelButton?.click();
                        $("[data-remodal-id='deleteModel']").remodal()?.close();
                    }
                }
            }else{
                deleteModel(text,type='url',action=URL,{class:'deleteRow deleteSuccess'});
                cancelButton = $(this).closest('.row').find('.cancelList');
            }
            
        }else if(!isEmptyChack(attr)){
            deleteModel(text,type='attr',action=attr);
        }
    });

    /*
    Bootstrap Table Is Empty And Add Pagination Button Defilt 1
    */
    $("table[data-toggle='table']").on('load-success.bs.table', async function (e, data, status) {
        let totalCount = await data.total ?? 0;

        if (isEmptyChack(totalCount)) {
            $(this).addClass('isEmpatyTable')
            $(this).parents('.bootstrap-table').find('.pagination .page-item.page-pre').after('<li class="page-item active"><a class="page-link" aria-label="to page 1" href="javascript:void(0)">1</a></li>');
        }
    });

    $(document).on("click", 'button[data-deleted="isDelete"]', async function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (Object.keys(tableIdArr).length > 0) {
            const url = $(this).attr('data-delete-url');
            let result = await doAjax(url, 'delete', { ids: tableIdArr })
            if (result.status == true) {
                const tableId = $(this).parents('.bootstrap-table').find('.fixed-table-body table').attr('id');
                $('#' + tableId).bootstrapTable('refresh');
            }
        }
    });

    $(document).on("click", '.deleteData', async function (e) {
        e.preventDefault();
        e.stopPropagation();
        const url = $(this).attr('data-url');
        if(!isEmptyChack(url)){
            const text = $(this).attr('data-text') ?? `Are you sure?`;
            confirmationModel(text, {
                url: url,
                class: "deleteConfirmation",
            });
        }

    });


    /*  User Status */
    $(document).on("click", '.suspendStatus', async function (e) {
        e.preventDefault();
        e.stopPropagation();
        const id = $(this).data('id');
        let text = $(this).text()?.toLowerCase();
        text = text == "suspend" ? 'suspended' : 'unsuspend';
        confirmationModel(`Do you want to ${text} account?`, {
            id: id,
            class: "confirmationuSpendStatus",
        });
    });
    /*  User Status */
    $(document).on("click", '.confirmationuSpendStatus', async function (e) {
        e.preventDefault();
        e.stopPropagation();
        const id = $(this).data('id');
        const URL = BASE_URL + "common/user-status-change/" + id
        let response = await doAjax(URL, 'post', { id: id, type: 'spend' });
        if (response.status) {
             location.reload();
          /*   Turbolinks.visit(url, { action: "reload" }) */
        }
    });
});



/*
  Use Semantic Popup
 */
$(function () {
    if ($('.tooltipPopup').length > 0) {
        tooltipPopup('.tooltipPopup');
    }
});


/*
  All Labels And Text Convert to Title Case
*/
/*  $(document).on("input", '.toTitleCase', function () {
     const val = $(this).val();
     if (!isEmptyChack(val)) {
         let text = toTitleCase(val);
         $(this).val(text);
     }
 }); */


/*
  Back Page
*/
$(document).on('click', '.backUrl', function () {
    backUrl();
});


/*
 * Logs Json Create
 */

$(document).on("change",".editForm input:not([name='save_option'],.addRateTable input), .editForm select, .editForm textarea, .editForm radio, .editForm checkbox",
    function () {
        let $this = $(this);
        let fieldName = $(this).attr("name");
        editFormArr = (typeof editFormArr == 'undefined') ? null : editFormArr;
        const fieldType = $(this).attr("type");
        let editFormValue = editFormArr ?? editArr;

        let prevValue = editFormValue[fieldName] ? editFormValue[fieldName] : "";
        let currentvalue = "";
        if ((fieldType == "radio" || fieldType == "checkbox") && !isEmptyChack(fieldName)) {

            if (fieldName.indexOf("[]") > 0) {
                let prevcheckValM = "",checkValM = "", comma = "";
                $("input[name='" + fieldName + "']:checked").each(function (indexInArray, valueOfElement) {
                    currentinpputId = $(this).attr("id");
                    currentlabelTxt = removeWhiteSpace($("label[for='" + currentinpputId + "']").text());
                    checkValM += comma + currentlabelTxt;
                    comma = ",";
                });
                fieldName = fieldName.replace("[]", '');
                currentvalue = checkValM;
                if (!isEmptyChack(editFormValue[fieldName]) && $.isArray(editFormValue[fieldName])) {
                    prevValue = editFormValue[fieldName];
                }else{
                    prevValue = editFormValue[fieldName]?.split(",");
                }

                comma = "";
                prevValue && $.each(prevValue,function(indexInArray, valueOfElement) {
                    currentinpputId = $("input[name='" + fieldName + "[]'][value='" + valueOfElement + "']").attr("id");
                    currentlabelTxt = removeWhiteSpace($("label[for='" + currentinpputId + "']").text());
                    prevcheckValM += comma + currentlabelTxt;
                    comma = ",";
                });

                prevValue = prevcheckValM;
            } else {
                currentinpputId = $("input[name='" + fieldName + "']:checked").attr("id");
                let currentlabelTxt = removeWhiteSpace($("label[for='" + currentinpputId + "']").text());
                if (isEmptyChack(currentlabelTxt)) {
                    if ($("input[name='" + fieldName + "']").is(':checked')) {
                        currentlabelTxt = "Enable"
                    } else {
                         currentlabelTxt = "Disable"
                    }
                }
                previnpputId = $("input[name='" + fieldName + "'][value='" + prevValue + "']").attr("id");
                let prevlabelTxt = removeWhiteSpace($("label[for='" + previnpputId + "']").text());
                if (isEmptyChack(prevlabelTxt)) {
                    if ($("input[name='" + fieldName + "'][value='" + prevValue + "']").is(':checked')) {
                        prevlabelTxt = "Enable"
                    } else {
                        prevlabelTxt = "Disable"
                    }
                }
                prevValue = prevlabelTxt;

                currentvalue = currentlabelTxt;

            }

        } else if ($(this)[0].type == "select-one") {
            if ($(this).closest("div").hasClass("time")) {
                prevValue = moment(prevValue, "HH:mm:ss").format("hh:mm A");
            }
            currentvalue = $(this).find('option:selected').text();
            prevValue = $(this).find('option[value="' + prevValue + '"]').text();


        } else if ($(this)[0].type == "select-multiple") {
            comma = "";
            $(this).find('option:selected').each(function (index, element) {
                let selettText =  $(element).text();
                currentvalue  += `${comma}${selettText}`;
                comma =",";
            });
            comma = "";
            let prevValueText ="";
            fieldNames = fieldName?.replace("[]", '');
            let values = editFormValue[fieldNames]?.split(",")

            $.each(values, function (indexInArray, valueOfElement) {
                let selettText =  $this.find('option[value="' + valueOfElement + '"]').text();
                prevValueText  += `${comma}${selettText}`;
                comma =",";
            });
            prevValue =prevValueText;

        }else if(fieldType == 'file') {
            currentvalue = $(this)[0].files[0]?.name;

        } else   {
            if ($(this).hasClass("singleDatePicker")) {
                prevValue = new Date(prevValue);
                prevValue = dateFormatChange(prevValue);
            }
            currentvalue = $(this).val();
        };
        let prevlogsArr = $(this).parents(".editForm").find("input[name='logsArr']").val();
        logsArr = {};
        if (!isEmptyChack(prevlogsArr)) {
            logsArr = JSON.parse(prevlogsArr);
        }

        if (!isEmptyChack(fieldName)) {
            logsArr[fieldName] = [];
            logsArr = editLogArr(
                fieldName,
                currentvalue,
                prevValue,
                logsArr,
                $(this)
            );
        }
        const logsJosn = JSON.stringify(logsArr);

        $(this).parents(".editForm").find("input[name='logsArr']").val(logsJosn);
    }
);



$(function () {
    /*
        codemirror Editor load In page
    */
    let titleArr = {};
    if ($(".codemirrorEditor").length > 0) {
        $(".codemirrorEditor").each(function (index, element) {
            codemirrorEditor(element);
        });
    }
    if ($(".singleDatePicker").length > 0) {
        $(".singleDatePicker").each(function (index, element) {
            singleDatePicker(this);
        });
    }
    if ($(".timepicker").length > 0) {
        $(".timepicker").each(function (index, element) {
            timepicker(this);
        });
    }
    if ($(".daterangepickers").length > 0) {
        $(".daterangepickers").each(function (index, element) {
            daterangepicker(this);
        });
    }

   /*  if ($(".divSelectOption").length > 0) {
        $(".divSelectOption").trigger('change');
        let constData = $(".divSelectOption").find("input[type='hidden']").val();
        console.log(constData);

    } */
    /* $('.singleDatePicker').on('show.daterangepicker:', function (e) {
        setTimeout(function () {
            $('body').find('.datepicker-container').css({
                'top': $(e.target).offset().top - $(window).scrollTop(), // Don't forget to add margins of target Exp.: +50
                'opacity': 1
            })
        })
    }); */

    /* Laod quill Editor */
    if ($(".qEditor").length > 0) {
        $(".qEditor").each(function (index, element) {

            quillEditorFn(element)
        });
    }

    if ($('[data-meteor-emoji="true"]').length > 0) {
        new MeteorEmoji()
    }

    /* Form Reset */
     $(document.body).on('click', '.resetForm', function () {
         $(this).parents('form').trigger("reset");
         $(this).parents('form').find("input").val(null);
          $('.ui.dropdown').dropdown('clear')
     });

    $(document).on('click', '.dataDropDownClear', function () {
        $('.dataDropDown').closest('div').find('input,select').val(null)
    });

    if ($('.disablesForm').length > 0) {
        disablesForm('.disablesForm');
    }
    if ($(".editForm input[name='save_option']").length > 0) {
        let formEach = $(".editForm:not(.titleArrForm)").find("input,select,textarea").not("input[type='hidden'],input[type='file'].addRateTable input,input[name='save_option'],.addOtherFeeTable  input");
        let tagType = "";

        formEach.each(function (index, element) {
            let lableText = titlelabelsTextForm($(element));
            let name = $(element).attr("name");

            let fieldType = $(element).attr("type");
            let classText = $(element).attr("class");
            classText = !isEmptyChack(classText) ? classText ?.replaceAll("form-control", '') ?.replaceAll("input-sm", '') : '';
            classText = removeWhiteSpace(classText);
            let optionArr = {};
            let fieldName = $(element).attr("name");
            if (fieldType == "radio" || fieldType == "chackbok") {
                currentvalue = $("input[name='" + fieldName + "']:checked").val();
                tagType = fieldType;
            } else if ($(element)[0].type == "select-one") {
                currentvalue = $(element).find('option:selected').text();
                tagType = "select";
                let optionBox = $(element)[0];
                optionArr[fieldName] = [];
                if (!isEmptyChack(optionBox)) {
                    $.each(optionBox, function (indexInArray, valueOfElement) {
                        if (!isEmptyChack(valueOfElement.text)) {
                            optionArr[fieldName][valueOfElement.value] = removeWhiteSpace(valueOfElement.text);
                        }
                    });
                }
            } else {
                currentvalue = $(element).val();
                tagType = "input";
            };

            currentvalue = removeWhiteSpace(currentvalue);
            titleArr[name] = {
                title: lableText,
                class: classText,
                tagType: tagType,
                //  value: currentvalue,
                optionArr: optionArr
            };
        });
        const titleJson = JSON.stringify(titleArr);
        $("form").append("<input type='hidden' name='titleArr' value='" + titleJson + "'/>");
    }

     $(document).on('change', '.notices_description_radio', function () {
        const $this = $(this);
        const isParent = $this.parents('tr').find('input[type="text"]');
      /*   $this.parents('tr').find('input').each(function (index, element) {
            // element == this
            maskInputDestroy(element);
        });
 */

        let thisVal = $(this).val()?.toLowerCase();
        isParent?.removeAttr("readonly")?.removeClass('fax')?.removeClass('is-invalid')?.val(null);
        switch (thisVal) {
            case "mail":
                /* isParent.attr('type', 'email'); */
                break;
            case "email":
              /*   isParent.attr('type', 'email'); */

                break;
            case "fax":
             /*    isParent.attr('type', 'text').addClass("fax");
                faxMaskInput(); */
                break;
            default:
                isParent.attr('type', 'text').attr("readonly", true)
                /*  maskInputDestroy(isParent); */
                break;
        }
    });



    $(document).on("change", 'input:checkbox:not(.deleteCheckBoxFee,.bootstrap-table input,.permissionCheckBox,.checkboxradio)', function () {
        let name = $(this).attr('name');
        if (name.indexOf("[]") > 0) {
            var min = 1 //minumum number of boxes to be checked for this form-group
            if ($('input[name="' + name + '"]:checked').length < min) {
                $('input[name="' + name + '"]').prop('required', true);
            }
            else {
                $('input[name="' + name + '"]').prop('required', false);
            }
        }
    });

    $(document.body).on('change','.year_mask',function(){
		$(this).parents('.form-group').find(".invalid-feedback").remove();
		$(this).removeClass('is-invalid');
		var dt = changeTimeZone(new Date());
		var currentYear = dt.getFullYear();
		var twoHundredYearBefore = 1900;
		if(($(this).val() != '') && ($(this).val() > currentYear  || $(this).val() < twoHundredYearBefore)){
			$(this).addClass('is-invalid');
				$(this).after("<small class='invalid-feedback'>Wrong year value</small>");
		}
    });

    /*
     Html  Clone Add Edit Delete
    */

    $(document).on("click", '.cloneAdd', function () {
        let count = $(".cloneAdd").length + 1;
        let cloneBox = $(".cloneBox:first").clone();
        cloneBox.find('.cloneRemove').removeClass('d-none');
        cloneBox.find('input,select,textarea').val(null)
        let id = `_${count}`;
        cloneBox.html(function (i, oldHTML) {
              return oldHTML.replaceAll("_1", id);
        });

        $(".cloneBox:last").after(cloneBox);
        if (cloneBox.find('.ui.dropdown').length > 0) {
            $('.ui.dropdown').dropdown();
        }
        if (cloneBox.find('.singleDatePicker').length > 0) {
            singleDatePicker('.singleDatePicker');
        }
        if (cloneBox.find('.telephone').length > 0) {
            telephoneMaskInput();
        }
        if (cloneBox.find('.percentageInput').length > 0) {
            percentageInput();
        }
     });
     $(document).on("click", '.cloneRemove', function () {
         $(this).parents('.cloneBox').remove();
     });




});
  var fileArray = [];
$(document).on("click", '.removeUploedFile', async function () {

        const image = $(this).attr('data-file-name');
        const imageid = $(this).attr('data-id');
        const imageType = $(this).attr('data-type');
        const imageHtml = $(this).attr('data-html') ?? false;
        fileArray = $(this).parents('form').find('.attachments').val() ?? [];
        if (!isEmptyChack(fileArray)) {
            fileArray = fileArray.split(",");
        }
        if (imageHtml) {
                fileArray.remove(image);
                $(this).closest('form').find('.attachments').val(fileArray)
                $(this).parents('.flow-progress').remove();
                return ;
        }

        if (!$(this).hasClass('noAjax')) {
            const URL = BASE_URL + "common/remove-file";
            const imageResult = await doAjax(URL, 'post', {
                image: image,
                imageid: imageid,
                imageType: imageType,
            })
        }

      fileArray.remove(image);
      if (fileArray.length == 0) {
          $(this).parents('form').find('.custom_file input').val(null)
          const textLabels = $(this).parents('form .custom_file').find('label').data('label');
          $(this).parents('form .custom_file').find('label span').text(textLabels);
          $(this).parents('form').find('.attachments').val(null);
      }
     if ($(this).parents('form').find('.attachments').length > 0) {
         $(this).parents('form').find('.attachments').val(fileArray);
     } else {
         $(this).parents('form').append(`<input type="hidden" class="attachments" name="attachments" value="${fileArray}">`);
     }


      $(this).parents('form').find('.attachments').val(fileArray);
      $(this).parents('form').find('.attachments').trigger('change');
      $(this).parents('.flow-progress').remove();
});


$(document).on('change', '.fileUpload', async function () {
       const $this = $(this);
       const textLabels = $(this).closest('custom_file').find('label').data('label');
       let acceptFile = $(this).attr('accept') ?? [];
       let filePath = $(this).data('file') ?? '';
       let filesUploaded = $(this).prop('files') ?? '';
       const isMultiple = hasAttr(this, 'multiple') ?? false;
       fileArray = $(this).parents('form').find('.attachments').val() ?? [];
       if (!isEmptyChack(fileArray)) {
           fileArray = fileArray.split(",");
           console.log(fileArray);
       }
       fileArray = !isEmptyChack(fileArray) ? fileArray : [];
       let attrName = 'file';
       if (isMultiple) {
           attrName = 'file';
       } else {
           $(".removeUploedFile").trigger('click');
       }

        let formData = new FormData();
        formData.append('accept', acceptFile);
        formData.append('file_path', filePath);
       if (hasAttr(this, 'multiple')) {
           if (filesUploaded.length > 0) {
                   formData.append('ismultiple', true);
                   $.each(filesUploaded, function (indexInArray, valueOfElement) {
                       formData.append(attrName, valueOfElement);
                       fildeObje = fileUploadAjax(formData, $this, fileArray);
                 });
           }
       } else {
           filesUploaded = filesUploaded[0];
           formData.append(attrName, filesUploaded);
           fildeObje = fileUploadAjax(formData, $this, fileArray);
       }
       fildeObje = await fildeObje;
       if ($(this).parents('form .custom_file').find('.attachments').length > 0) {
            $this.parents('form .custom_file').find('.attachments').val(fildeObje);
       } else {
            $this.parents('form .custom_file').append(`<input type="hidden" class="attachments" name="attachments" value="${fildeObje}">`);
       }

       $this.parents('form .custom_file').find('.attachments').trigger('change');
   });

$(document).on("click", '.templateEditorLogsPreview', async function () {
    let id = $(this).data("id");
    const route = BASE_URL + "logs-details/" + id;
    let response = await doAjax(route, "post");
    let style = response?.css ?? null;
    $('body').append(`<div id="templateEditorLogsPreview"
    class="remodal remodal-video" style="min-width: 90%;">
    <button data-remodal-action="close" class="remodal-close">
    </button>
    <div class="row" id="videoModalIframeWrapper">
    <div class="col-md-6">  <div class="border pl-2"><div class="text-left fw-600 pt-2 m-2 border-bottom">Prior</div> <iframe id="oldValueLogs" class="w-100 border-0"  allowfullscreen="true" class="w-100 border-0 "  height="400"></iframe></div> </div>
    <div class="col-md-6">  <div class="border pl-2"><div class="text-left  fw-600  pt-2  m-2 border-bottom">New</div> <iframe id="newValueLogs" class="w-100 border-0"  allowfullscreen="true" class="w-100 border-0 "  height="400"></iframe></div> </div>
    </div></div>`);
    var $Modal = $('#templateEditorLogsPreview').remodal();
    var $videoModalIframeWrapper = $("#templateEditorLogsPreviewIframeWrapper");
    var oldValueLogsFrame = document.getElementById('oldValueLogs');
    var oldValueLogspreview = oldValueLogsFrame.contentDocument || oldValueLogsFrame.contentWindow.document;
    oldValueLogspreview.open();
    oldValueLogspreview.write(response?.old_value);
    oldValueLogspreview.close();
    $("#oldValueLogs").contents().find("head").append(`<style>${style}</style>`);
    var newValueLogsFrame = document.getElementById('newValueLogs');
    var newValueLogspreview = newValueLogsFrame.contentDocument || newValueLogsFrame.contentWindow.document;
    newValueLogspreview.open();
    newValueLogspreview.write(response?.new_value);
    newValueLogspreview.close();
    $("#newValueLogs").contents().find("head").append(`<style>${style}</style>`);
    $Modal.open();
});

$(document).on('click', '.dropdown-toggle', function () {
    $(this).closest(".btn-group").find('.dropdown-menu').toggleClass('show');
});


$(document).on('click', '.ui.dropdown', function () {
    if($('.table-responsive,.table-responsive-sm').find('.fixed-table-body').length > 0){
        if($(this).hasClass('active')){
            $('.table-responsive,.table-responsive-sm').find('.fixed-table-body').css('overflow', 'inherit');
        }else{
            $('.table-responsive,.table-responsive-sm').find('.fixed-table-body').css('overflow', 'auto');
        }
    }else{
        if($(this).hasClass('active')){
            $('.table-responsive,.table-responsive-sm').css('overflow', 'inherit');
        }else{
            $('.table-responsive,.table-responsive-sm').css('overflow', 'auto');
        }
    }
});


/*$(document).on("click", function (event) {
    var $trigger = $(".dropdown");
    if ($trigger !== event.target && !$trigger.has(event.target).length) {
        $(".dropdown-menu").removeClass('show');
    }
}); */

 $(document).on('change','.office_select select', async function () {
    let value = $(this).val();
    let userId = $(this).parents('form').find('input[name="userId"]').val();
    let opthtml = "";
    const URL = BASE_URL + 'common/office-wish-role';
    const result = await doAjax(URL, 'post', {
        office: value,
        userId: userId
    });
    if(result.status == true){
        const role  = result?.role;
        $.each(role, function (indexInArray, valueOfElement) {
            opthtml += `<option value='${indexInArray}'>${valueOfElement}</option>`;
        });
    }
    $('.role_select .text').html(null)
    $('.role_select select').val(null)
    $('.role_select select').html(opthtml);
    let role_selectvalue = $('.role_select select').attr('data-selected');
    $(".role_select").dropdown("set selected", role_selectvalue);

});


function formatDate(date, monthCount,datetime='') {
	var date = new Date(date);
	var d = date.getDate();
	date.setMonth(date.getMonth() + +monthCount);
	if (date.getDate() != d) {
	  date.setDate(0);
	}
	let m = (date.getMonth() + 1).toString().padStart(2, '0');
	let da = date.getDate().toString().padStart(2, '0');
	let y = date.getFullYear();
	return m + "/" + da + "/" + y;
}

var specialElementHandlers = {
    '#pdfeEditor': function (element, renderer) {
        return true;
    }
};
$(document).on('click','.createdPdf', async function () {
   // $("body").append('<div id="pdfeEditor"></div>');
    const name = $(this).data('name');
    let element = $(this).data('content');
    let url = $(this).data('url');

    var doc = new jsPDF();
    doc.fromHTML($(element).html(), 15, 15, {
        'width': 170,
        'elementHandlers': function() {
        return true;
        }
    });
    doc.save(name+'.pdf');


});
$(document).on('click','.createdPrint', async function () {
    let contetElement = $(this).data('content');

    var divContents = $(contetElement)[0].innerHTML;
    var a = window.open('', '', 'height=1000, width=1500');
    a.document.write('<html>');
    a.document.write('<body>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
    a.close();
});




if ($(".tableForm").length > 0) {
    let tableFormArr = {};
    let formEach = $(".tableForm:not(.titleArrForm)").find("input,select,textarea").not("input[type='hidden'],input[type='file'].addRateTable input,input[name='save_option'],.addOtherFeeTable  input");
    let tagType = "";
    optionArr = {};
    formEach.each(function (index, element) {
        const fieldName = $(element).attr('name');
        const fieldType = $(element).attr('type');
        let title = $(element).parents('tr').find("td:first").text();
        let classText = $(element).attr("class");
        classText = !isEmptyChack(classText)?classText?.
                    replaceAll("form-control", '') ?.
                    replaceAll("input-sm", '')?.
                    replaceAll("form-check-input", '')?.
                    replaceAll("zinput-inline w-75", '') : '';
        classText = removeWhiteSpace(classText);
        if (fieldType == "radio" || fieldType == "chackbok") {
            currentvalue = $("input[name='" + fieldName + "']:checked").val();
            tagType = fieldType;
        } else if ($(element)[0].type == "select-one") {
            currentvalue = $(element).find('option:selected').text();
            tagType = "select";
            let optionBox = $(element)[0];
            optionArr[fieldName] = [];
            if (!isEmptyChack(optionBox)) {
                $.each(optionBox, function (indexInArray, valueOfElement) {
                    if (!isEmptyChack(valueOfElement.text)) {
                        optionArr[fieldName][valueOfElement.value] = removeWhiteSpace(valueOfElement.text);
                    }
                });
            }
        } else {
            currentvalue = $(element).val();
            tagType = "input";
        };

        title = removeWhiteSpace(title);
        tableFormArr[fieldName] = {
            title: title,
            class: classText,
            tagType: tagType,
            //  value: currentvalue,
            optionArr: optionArr
        };
    });
   /*  console.log(tableFormArr) */
    const titleJson = JSON.stringify(tableFormArr);
    $(".tableForm").append("<input type='hidden' name='titleArr' value='" + titleJson + "'/>");
}






$(document).on('change','.selectDataTabs select', async function () {
    let $this   = $(this);
    $val        = $this.val()?.toLowerCase();
    $name        = $this.attr('name');
 
    $('[data-stab][data-name="'+$name+'"]').addClass('d-none').find('input.required,select.required').removeAttr('required').val(null);
    $('[data-stab="'+ $val +'"][data-name="'+$name+'"]').removeClass('d-none').find('input.required,select.required').attr('required','required');
    
    if($name == 'apply_payment' && $val == 'allow_agent_commission_rp'){
       $('.enterReturnPremiumCommissionForm .agent_commision_none_fields').addClass('d-none')
    }else{
        $('.enterReturnPremiumCommissionForm .agent_commision_none_fields').removeClass('d-none')
    }

    if($name == 'apply_payment' && ($val == 'allow_cancel_rp_net' || $val == 'allow_cancel_rp_gross')){
        
        $('.enterReturnPremiumCommissionForm .agent_return_commission_due_div,.agent_commission_due_amount_div').removeClass('d-none')
     }else{
         $('.enterReturnPremiumCommissionForm .agent_return_commission_due_div,.agent_commission_due_amount_div').addClass('d-none')
     }
});



$(document).on('change','.tinSelect', async function () {
    let value = $(this).val();
    let parentEle = $(this).closest('.row');
    parentEle.find('input[name="tin"]').removeClass('sstin tin');
    if(value == "SSN"){
        parentEle.find('input[name="tin"]').addClass('sstin');
        sstin();
    }else if(value == "EIN"){
        parentEle.find('input[name="tin"]').addClass('tin');
        tin();
    }
});

let statusTypeent= "",enstatus=null;
$(document).on('click','.entityStatusChange', async function () {
    let id = $(this).data('id');
    let status = $(this).data('status');
    let type = $(this).data('type');
    statusTypeent = type;
    enstatus = status;
    $("[data-remodal-id='statusModel']").remove();
    modelHtml = `<div class="remodal" data-remodal-id="statusModel">
    <button class="remodal-close" data-remodal-action="close"></button>
    <h4>${status} Status</h4>
    <p>Do you want to ${status?.toLowerCase()} ${type?.toLowerCase()} ?</p><br>
        <div class="buttons">
            <button class="btn btn-sm btn-primary entityStatusChangeBtn" data-id="${id}" >${status} Status</button>
            <button class="btn btn-default btn-sm" data-remodal-action="cancel">Cancel</button>
        </div>
    </div>`;
    $("body").append(modelHtml);
    const successAlertModelOptions = {
        closeOnOutsideClick: false,
    };
    var inst = $("[data-remodal-id=statusModel]").remodal(successAlertModelOptions);
    inst.open();
});


$(document).on('click','.entityStatusChangeBtn', async function () {
    let id = $(this).data('id');
    let response = await doAjax(`${BASE_URL}${statusTypeent}/status-update/${id}`,'post',{status:enstatus});

    if(response.status == true){
        successAlertModel(response.msg,response.single, 'url', 'single');
    }
}
);


$(document).on('click','.togglePassword', async function () {
    let type = 'password';
    if($(this).hasClass('fa-eye')){
         type = 'text';
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
    }else{
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
    }
    $(this).closest('div.position-relative').find('input').attr('type',type)
});



/* Paasword set eye icon */
if($('input[type="password"]').length > 0){
    $('input[type="password"]').each(function (index, element) {
        // element == this
        $(element).closest('div').addClass('position-relative').append(function(){
            if($(this).find('.togglePassword').length == 0){
                $(this).append('<i class="far fa-eye togglePassword" ></i>');
            }
        })
    });
}
$(function () {
	$(document).mouseup(function(e)
	{
		var container = $(".dropdown");
		if (!container.is(e.target) && container.has(e.target).length === 0)
		{
			$(".dropdown-menu").removeClass('show');
		}
	});
});