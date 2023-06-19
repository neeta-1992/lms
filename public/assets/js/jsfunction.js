//Show Page Loader
const showLoader = () => {
    $(".loader.loading").removeClass("d-none");
}
//Hide Loader
const HideLoader = () => {
    $(".loader.loading").addClass("d-none");
}

const hasAttr = (element,name) => {
  return $(element).attr(name) !== undefined;
}

Array.prototype.remove = function () {
    var what, a = arguments,
        L = a.length,
        ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function objClean(obj) {
    for (var propName in obj) {
        if (obj[propName] === null || obj[propName] === undefined || obj[propName] === '') {
            delete obj[propName];
        }
    }
    return obj
}

const changeTimeZone =(date, timeZone = 'America/Los_Angeles') => {
    if (typeof date === 'string') {
		return new Date(
		  new Date(date).toLocaleString('en-US', {
			timeZone,
		  }),
		);
	  }
		return new Date(
		date.toLocaleString('en-US', {
		  timeZone,
		}),
	  );
}
const getCurrentTimeZone = () => {
    var timezone = moment.tz.guess();
    var today = changeTimeZone(new Date());
    var month = today.getMonth()+1;
    month = month < 10 ? '0'+month : month;
    var date = month+'/'+today.getDate()+'/'+today.getFullYear();
    var hour = today.getHours();
    var a = ( hour >= 12 ) ? 'PM' : 'AM';
    hour = hour % 12;
    hour = hour ? hour : 12
    var time = hour + ":" + today.getMinutes()+' '+a;
    return timeformatted = date+' '+time+' '+ moment.tz(timezone).zoneName();
}
/*
  ?This funcion is use Title Case Converter Tool.;
  An easy to use title capitalization tool.
  Convert your standard text into title text with this online title capitalizer.
  Simply enter your standard text into the title case converter on the left and
  see it automatically get generated on the right.
*/
const toTitleCase = (text) => {
   //exclude articles, cordinate conjunction, and some prepositions
    let irrelevance = ["and", "the", "in", "with", "an", "or", "at", "of", "a", "to", "for", 'is', 'on'];
    let OnlyUpperCase = ["us", 'tin', 'efin'];
    return text.replace(/\w+/g, function (word) {
        if (irrelevance.includes(word)) {
            return word;
        } else {
            let titleText = word.charAt(0).toUpperCase() + word.substr(1).toLowerCase();
            titleText = OnlyUpperCase.includes(titleText.toLowerCase()) ? titleText.toUpperCase() : titleText;
            return titleText;
        }
    });

};
const isEmptyChack = (value = null) => {
    let valueType = typeof value;
    switch (valueType) {
        case "string":
            return (
                !value.trim() || typeof value == "undefined" || value === null
            );
            break;
        case "undefined":
            return typeof value == "undefined" || value === null;
            break;
        case "number":
            return value === 0 || isNaN(value);
            break;
        case "object":
            return (
                (value !== null && Object.keys(value).length === 0) ||
                value === null
            );
            break;
        default:
            return value == "";
            break;
    }
};

/*
  Ajax Call And Server Side validation Show In Form
*/
const serverSideValidationError = (errors=null,formClass=null) => {
    if (errors && formClass) {
        let errorsObj = errors?.errors;
        $(".invalid-feedback").remove();

        $.each(errorsObj, function (indexInArray, valueOfElement) {
            formClass.find('[name="' + indexInArray + '"]').addClass('is-invalid').after(`<small class="invalid-feedback">${valueOfElement}</small>`);
        });
    }
}

/*
 *?Remove multiple whitespaces (extra space remove)
 */
const removeWhiteSpace = (text) => {
 return text?.replace(/\s+/g, " ").trim();
}

/*
 * ? disablesForm
 */
const disablesForm = (element) => {
    $(element).find("input,select,textarea").attr('disabled', 'disabled');
    $(element).find(".ui.dropdown").addClass('disabled');
    $(element).find("button").addClass('disabled');
}


const doAjax = async (
    ajaxurl = "",
    method = "POST",
    args = {},
    otherArgs = null,
    formClass = null,
    loader = true,
) => {
    let result;
    ajaxurl = ajaxurl;

    try {
        if (loader) {
            showLoader();
        }

        result = await $.ajax({
            url: ajaxurl,
            type: method,
            data: args,
            ...(otherArgs && typeof otherArgs == "object" && otherArgs),
        });
        HideLoader();
        return result;
    } catch (error) {

        if (error.status === 422) {
            serverSideValidationError(error?.responseJSON,formClass);
        }
      /*   if (error.status == 419) {
            location.reload();
        } */
        HideLoader();
        return { status: error.status, msg: error.statusText };
    }

};

const loadingTemplate = () => {
    return '<i class="fa-thin fa-spinner fa-spin fa-fw fa-2x iconprefix"></i>';
};

const scrolltotop = () => {
    var headerHeight = $("input").height();
    $("html, body").animate({ scrollTop: headerHeight }, "slow");
};
const scrollValidationError = () => {
    const scrollHeight =
        ($("input:invalid,input.is-invalid").eq(0).offset() ?.top ?? 0) - 40;
    $("html,body").animate({ scrollTop: scrollHeight }, 500);
};

const dataFunction = () => {
    let date = new Date();
    let year  = date.getFullYear();
    let month = date.getMonth() + 1;
    let day = date.getDay();
    let totalDay = date.getDate();
    return {
        date, year, month, day, totalDay
    }
}

const getDays = (year, month) => {
    return new Date(year, month, 0).getDate();
};

const dateFormatChange = (date , format = null) => {
    let formatDate = format ?? "MM/DD/YYYY";
    return moment(date).format(formatDate);
};

const backUrl = () => {
    window.history.go(-1);
};

// Check Validate Email
const validateURL = (thisObj) => {
    let fieldValue = thisObj.val().toLowerCase();
    let pattern =
        /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    return pattern.test(fieldValue);
};

//Check Validate Email
const validateEmail = (thisObj) => {
    let fieldValue = thisObj.val();
    let pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    return pattern.test(fieldValue);
};
//Check Validate Username
const validateUsername = (username) => {
  let fieldValue = username.val();
  let pattern = /^[a-z][a-z0-9_.-]{3,50}$/i;
  return pattern.test(fieldValue);
};

// Validate Select One Tag
const validateSelectOne = (thisObj) => {
    let fieldValue = thisObj.val();
    if (fieldValue != null) {
        return true;
    } else {
        return false;
    }
};
//Form Validation For required attr files
const isValidation = (forms = ".validationForm", notClass = false) => {

    const bootstrapForm = notClass == true ? forms : $(forms);
    /* console.log(bootstrapForm); */
    if (bootstrapForm.length) {
        let isValidate = true;

        Array.prototype.filter.call(bootstrapForm, function (form) {

            $(form).find("select").parent(".ui.dropdown").removeClass("is-invalid");
            isValidate = form.checkValidity();

            if ($(form).find(".divUiDropdown").find('input[type="hidden"]').prop('required')) {
                $(form).find(".divUiDropdown").each(function (index, element) {
                    if (hasAttr($(element).find('input[type="hidden"]'), "required")) {
                        if (isEmptyChack($(element).find('input[type="hidden"]').val())) {
                            $(element).addClass("is-invalid");
                            isValidate = false;
                        } else {
                            $(element).removeClass("is-invalid");
                        }
                    }
                });
            }

            if ($(form).find(".sq-card-wrapper").length > 0) {
                let sqvalue =  $(form).find('input[name="sqtoken"]').val();
                if (isEmptyChack(sqvalue)) {
                    $(form).find(".sq-card-wrapper").addClass("sq-error");
                    isValidate = false;
                }else {
                    $(form).find(".sq-card-wrapper").removeClass("sq-error");
                }
            }


            if ($(form).find(".inputfile").length > 0) {
                $(form).find(".inputfile ").each(function (index, element) {
                    if (hasAttr($(element), "required")) {
                        if (isEmptyChack($(element).val())) {
                            $(element).parent('.custom_file').addClass("is-invalid");
                            isValidate = false;
                        } else {
                            $(element).parent('.custom_file').removeClass("is-invalid");
                        }
                    }
                });
            }

            if ($(form).find(".quillEditor").length > 0) {
                $(form).find(".quillEditor").each(function (index, element) {
                    if (hasAttr($(element).find('input.quillEditorInput'), "required")) {
                        if (isEmptyChack($(element).find('input.quillEditorInput').val())) {
                            $(element).addClass("is-invalid");
                            isValidate = false;
                        } else {
                            $(element).removeClass("is-invalid");
                        }
                    }
                });
            }


            if (isValidate === false) {
                form.classList.add("invalid");
                scrollValidationError();
                /* console.log($(form).find("select:invalid")); */
                if ($(form).find("select:invalid").length > 0) {
                    $(form).find("select:invalid")
                        .closest(".ui.dropdown")
                        .addClass("is-invalid");
                }

            }

            form.classList.add("was-validated");
          /*   isValidate = form.checkValidity(); */
        });

        return isValidate;
    }
};


const serializeFilter = (attr = null, isFilter = false,isFom) => {
    const filterPattern = (/[`~!#$%^*()|\?;:'",<>\{\}\[\]\\\/]/gi, "");
    const atttName        = attr ?? "form";
    let serializeData = $(atttName).serializeArray();
    if (isFilter) {
        const NotFilterName = ["logsArr", "titleArr", 'attachments', '_token', '_method', "date_format", 'time_format', 'date_format_value', 'time_format_value', 'delete_rows','template'];
        const realArray = $.map(serializeData, function (val) {
            let name = val.name;
            let value = $.trim(val.value);
          //  console.log($.inArray(name, NotFilterName), name);
            if ($.inArray(name, NotFilterName) == -1) {
                  value = value
                      .replace("$", "")
                      .replace("%", "")
                      .replace(",", "");
            }
            value = !isEmptyChack(value) ? value : '' ;
            return { name: name, value: value };
        });
        serializeData = realArray;
    }

    return serializeData;
};

const titlelabelsTextForm = (element) => {

    let lableText = "",space = "",Mlabel="";
    let labelObj = element.parents(".row").closest(".row").find(".col-form-label:first");
    if (labelObj.length >= 2) {
        const lableKey = labelObj.length - 1;

        if (element.parents('form').hasClass('fullLableText') && lableKey > 1) {
            for (let i = 1; i <= lableKey; i++) {
                Mlabel += `${space}${labelObj[i].textContent}`;
                space = " ";
            }
            lableText = Mlabel;
        } else if (element.parents('form').hasClass('quoteEditForm') && lableKey > 1) {
               lableText  = element.closest(".form-group.row").find("label:first").text();
        } else {

            lableText = labelObj[lableKey]?.textContent;

            if (isEmptyChack(lableText)) {
                lableText = labelObj[lableKey - 2]?.textContent;
            }

        }

    } else {
        lableText = labelObj[0]?.textContent;
    }

    if(isEmptyChack(lableText)){
       lableText = element.closest('.form-group,.row').find('.labelText').text();
    }

    lableText = lableText?.replace(/[\s\n\r]+/g, " ");
    return lableText;
}


const editLogArr = (attrname,currentValue,preValue,logsArr=[],$this) => {
    let isDoller = "", isPercentage = "", msg = "";

    let lableText = titlelabelsTextForm($this);
        if ($this.hasClass("percentageinput") || $this.hasClass("percentageInput")
        ) {
            if (!isEmptyChack(preValue)) {
                preValue = `${preValue}%`;
            }
            if (!isEmptyChack(currentValue)) {
                currentValue = `${currentValue}%`;
            }
        }

        if ($this.hasClass("amounts") || $this.hasClass("amount")) {

        if (!isEmptyChack(preValue) && preValue.indexOf('$') !== 1) {
                preValue = parseFloat(preValue).toLocaleString();
                preValue = (`$${preValue}`);
            }else{
                preValue = preValue;
            }
            if (!isEmptyChack(currentValue) && currentValue.indexOf('$') !== 1) {
                 currentValue = parseFloat(currentValue).toLocaleString();
                 currentValue = (`$${currentValue}`);
            }else{
                currentValue = currentValue;
            }

        }
        if (isEmptyChack(preValue)) {
            msg = `${lableText} was updated to <b>${currentValue}</b>`;
        } else {
            currentValue = !isEmptyChack(currentValue) ? currentValue : 'None';
            msg = `${lableText}  was changed from <b>${preValue}</b> to <b>${currentValue}</b>`;
        }

        if ($this.hasClass("templateEditor")) {
            msg = `<a href="javascript:void(0)" class="templateEditorLogsPreview" data-id="{LOGSID}">${lableText} was changed</a>`;
        }

        msg = msg.replace(/\s+/g, " ").trim();
       // console.log(msg);
        if (currentValue != preValue) {
            logsArr[attrname].push({
                key: attrname,
                label: lableText,
                value: currentValue,
                prevValue: preValue,
                msg: msg,
            });
        } else {
            delete logsArr[attrname];
    }
    delete logsArr["save_option"];
    if (Object.keys(logsArr).length > 0) {
        $this.parents("form").find("input[name='save_option'][value='save_and_reset']").prop("checked",true)
    }

    return logsArr;

}

/* form Rest */
const resrtForm = (form) => {
    $(form).not(".quote_subject,.qId,.vId,.version").trigger("reset");
    $(form).find("input:not(.quote_subject,.qId,.vId,.version)").val(null);
    $(form).find('.ui.dropdown').dropdown('clear');
    $(form).find('.ui.dropdown').dropdown('setup menu',{values:[]});
    if($(form).find("#message-editor").length > 0){
        var quill = $(form).find("#message-editor")[0].__quill;
         quill.innerHTML = "";
    }
}

/* Form Input ,select and other fields title And select option obj get for create code side log create */
const formTitleObj = (form) => {

    let formEach = form.find("input,select,textarea");
    let tagType = "";
    let titleArr = {};
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
        }else if (fieldType == "hidden") {
           if($(element).closest('div.divUiDropdown').length > 0){
               tagType = "select";
               let divUiDropdownoptionBox = $(element).closest('div.divUiDropdown').find('.menu div')
               currentvalue = $(element).closest('div.divUiDropdown').find('.menu div.selected').attr('data-value') ?? null;;
               optionArr[fieldName] = [];
                if (!isEmptyChack(divUiDropdownoptionBox)) {
                    divUiDropdownoptionBox.each(function (index, element) {
                        const uiValue = element.getAttribute('data-value');
                        const uiText = element.getAttribute('data-text');
                        /* console.log(uiText); */
                        if(!isEmptyChack(uiText)){
                            optionArr[fieldName][uiValue] = removeWhiteSpace(uiText);
                        }

                   });
                }
           }else{
               currentvalue = $(element).val();
           }
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
        } else if (fieldType != "hidden") {
            currentvalue = $(element).val();
            tagType = "input";
        };

        currentvalue = !isEmptyChack(currentvalue) ?  removeWhiteSpace(currentvalue) : null;
        tagType = !isEmptyChack(tagType) ?  tagType : null;
        (tagType && name) && (titleArr[name] = {
            title: lableText,
            class: classText,
            tagType: tagType,
            ...(!isEmptyChack(optionArr) &&  {optionArr:optionArr})
        });
    });
  /*   console.log(titleArr); */
    const titleJson = JSON.stringify(titleArr);
    return titleJson;
}

/*
 * Single Date Range Picker Select
 */

const singleDatePicker = (element = ".singleDatePicker") => {
    const container=$(element).length>0 ? $(element).parent() : "body";
    const currentDateAftrer = $(element).data('current-date') ?? false;
    $(element).daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        container:container,
        ...(currentDateAftrer && {minDate:new Date()})
    });

    $(element).on('apply.daterangepicker', function (ev, picker) {
        if (picker.singleDatePicker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY'));
        } else {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        }

        $(this).trigger("change");

    });

    $(element).on('cancel.daterangepicker', function (ev, picker) {
       // $(this).val('');
    });

}
const timepicker = (element) => {
    $(element)?.timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
}

const daterangepicker = (element) => {
    const container=$(element).length>0 ? $(element).parent() : "body";
    let isTime = $(element).data('time-picker');
    isTime = !isEmptyChack(isTime) ? true : false;

    $(element).daterangepicker({
        timePicker: isTime,
        autoUpdateInput: false,
        container:container

    });

     $(element).on('apply.daterangepicker', function (ev, picker) {
        if (picker.timePicker) {
             $(this).val(picker.startDate.format('MM/DD/YYYY hh:mm A') + ' - ' + picker.endDate.format('MM/DD/YYYY hh:mm A'));
        } else {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        }

    });

    $(element).on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

}

var buttonhtml = '<div class="editor-toolbar">'+
	'<ul>'+
		'<li class="searchbox-enable">'+
			'<a href="javascript:void(0);" title="" data-original-title="Open Search box (<strong>ctrl+f</strong>)">'+
				'<i class="fa-solid fa-magnifying-glass"></i>'+
			'</a>'+
		'</li>'+
		'<li class="replacebox-enable">'+
			'<a href="javascript:;" title="" data-original-title="Open Replace box (<strong>ctrl+h</strong>)">'+
				'<i class="fa-duotone fa-shuffle"></i>'+
			'</a>'+
		'</li>'+
		'<li class="fullscreen-enable">'+
			'<a href="javascript:;" title="" data-original-title="Enter fullscreen mode (<strong>ctrl+shift+f</strong>)">'+
				'<i class="fa-sharp fa-solid fa-desktop"></i>'+
			'</a>'+
		'</li>'+
	'</ul>'+
'</div>';

/*
 codemirror Editor Function Create textarea to codemirror editor
*/
const ExcludedIntelliSenseTriggerKeys = {
    "8": "backspace",
    "9": "tab",
    "13": "enter",
    "16": "shift",
    "17": "ctrl",
    "18": "alt",
    "19": "pause",
    "20": "capslock",
    "27": "escape",
    "33": "pageup",
    "34": "pagedown",
    "35": "end",
    "36": "home",
    "37": "left",
    "38": "up",
    "39": "right",
    "40": "down",
    "45": "insert",
    "46": "delete",
    "91": "left window key",
    "92": "right window key",
    "93": "select",
    "107": "add",
    "109": "subtract",
    "110": "decimal point",
    "111": "divide",
    "112": "f1",
    "113": "f2",
    "114": "f3",
    "115": "f4",
    "116": "f5",
    "117": "f6",
    "118": "f7",
    "119": "f8",
    "120": "f9",
    "121": "f10",
    "122": "f11",
    "123": "f12",
    "144": "numlock",
    "145": "scrolllock",
    "186": "semicolon",
    "187": "equalsign",
    "188": "comma",
    "189": "dash",
    "190": "period",
    "191": "slash",
    "192": "graveaccent",
    "220": "backslash",
    "222": "quote"
}
const codemirrorEditor = (element) => {
	var parentElement = $(element).parent('div');
	const codemirrorConfig = {
        mode: "text/html",
        matchTags: {
            bothTags: true
        },
        extraKeys: {
			"Alt-F": "findPersistent",
            "Ctrl-Space": "autocomplete"
        },
        lineNumbers: true,
        keyMap: "sublime",
        lineWrapping: true,
        autoCloseTags: true,
        minHeight: "100%",
        styleActiveLine: true,
        selfClosingTags: true,
        theme: 'material-ocean',

    };
    let htmlEditor = CodeMirror.fromTextArea(element, codemirrorConfig);
     htmlEditor.on("keyup", function (editor, event) {
         var __Cursor = editor.getDoc().getCursor();
         var __Token = editor.getTokenAt(__Cursor);
         if (!editor.state.completionActive &&
             !ExcludedIntelliSenseTriggerKeys[(event.keyCode || event.which).toString()] &&
             (__Token.type == "tag" || __Token.string == " " || __Token.string == "<" || __Token.string == "/")) {
             CodeMirror.commands.autocomplete(editor, null, {
                 completeSingle: false
             });
         }
     });
    htmlEditor.on('change', (editor) => {
        const text = editor.doc.getValue();
        $(element).val(text).change();
    });
	parentElement.find(".CodeMirror").append(buttonhtml);
	parentElement.find('.editor-toolbar .searchbox-enable').on('click',function(){
		$(this).toggleClass("active");
		CodeMirror.commands.findPersistent(htmlEditor);
	})
	parentElement.find('.editor-toolbar .replacebox-enable').on('click',function(){
		$(this).toggleClass("active");
		CodeMirror.commands.replace(htmlEditor);
	})
	parentElement.find('.editor-toolbar .fullscreen-enable').on('click',function(){
		$(this).toggleClass("active");
		parentElement.find(".CodeMirror").toggleClass('editor-fullscreen')
		var isFullscreen=parentElement.find(".CodeMirror").hasClass('editor-fullscreen')
		if(isFullscreen){
			$('body').css({overflow:'hidden'})
			$('body').addClass("fullscreen_view");
		}else{
			$('body').css({overflow:'inherit'})
			$('body').removeClass("fullscreen_view");
		}
	})

    return htmlEditor;
}


/*
   Number Filter
*/
const numberFilter = (number) => {
    let filNumber = number?.replace('$', "")?.replace('%', "")?.replace(',', "")?.replace(/,/g, '');
    return parseFloat(filNumber);
}

/*
   Number Check In Range
*/
const  inRange = (x, min, max) => {
    if ((x >= min && x <= max)) {
        return true;
    } else {
        return false;
    }
}

const checkIfExistTimeForCal = (start_time_str = null, end_time_str = null, intStartStr = null, endPeriodStr = null) => {
    $res = ((start_time_str >= intStartStr && start_time_str < endPeriodStr) ||
        (start_time_str <= intStartStr && end_time_str > endPeriodStr) ||
        (end_time_str > intStartStr && end_time_str <= endPeriodStr) ||
        (start_time_str >= intStartStr && end_time_str <= endPeriodStr));
    return $res;
}


function removeHashGromUrl() {
     var uri = window.location.toString();
     if (uri.indexOf("#") > 0) {
         var clean_uri = uri.substring(0,
        uri.indexOf("#"));
        window.history.replaceState({},document.title, clean_uri);
     }
 }


const daysList = (element = ".daysList", month) => {
    const  getDateAll = dataFunction();
    year = getDateAll?.year;
    month = month ?? getDateAll?.month;
    let totDay = getDays(year, month);

    let opthtml = "";
    $(element + " select").val("");
    $(element + " .text").html("Day").addClass('default');
    for (let index = 1; index <= totDay; index++) {
        var key = index;
        if (index == 1 || index == 21 || index == 31) {
            value = `${index}st`
        } else if (index == 2) {
            value = `${index}nd`
        } else if (index == 3) {
            value = `${index}rd`
        } else {
            value = `${index}th`
        }
        opthtml += `<option value='${key}'>${value}</option>`;
    }

    $(element + " select").html(opthtml);
    setTimeout(() => {
        const selected = $(element + " select").attr('data-selected');
        if (!isEmptyChack(selected)) {
            $(element)
                .dropdown("set selected", selected)
        }

     }, 500);;

}

/* Creating deflate() as a standalone function */
const deflate = function (source, pathArray, result) {

    pathArray = (typeof pathArray === 'undefined') ? [] : pathArray;
    result = (typeof result === 'undefined') ? {} : result;

    var key, value, newKey;

    for (var i in source) {

        if (source.hasOwnProperty(i)) {

            key = i;
            value = source[i];

            pathArray.push(key);

            if (typeof value === 'object' && value !== null) {

                result = deflate(value, pathArray, result);

            } else {

                newKey = pathArray.join('.');
                result[newKey] = value;
            }

            pathArray.pop();
        }
    }

    return result;
};
function windowpop(url, width, height) {
    var left = (screen.width / 2) - (width / 2);
    var top = (screen.height / 2) - (height / 2);
    const popup =   window.open(url, "", "menubar=no,toolbar=no,status=no,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left);

    $(document).on("click",'.windowpop_close', function () {
        popup.close();
    });

}



const fileUploadAjax = async (formData, $this, fileArray) => {
    const URL = BASE_URL + "common/file-upload";
    const imageResult = await doAjax(URL, 'post', formData, {
        contentType: false,
        cache: false,
        processData: false,
    })
    if (imageResult) {
        fileArray.push(imageResult.imageName);
      /*   console.log($('.image_list_box').length); */
        if ($this.parents('form').find('.image_list_box').length > 0) {
               $('.image_list_box').append(imageResult.msg)
        } else {
            $this.parent('.custom_file').after(imageResult.msg)
        }

    };

    return fileArray;
}


const quillEditorFn = async (element, $this) => {
	let id = $(element).attr('id');
	var tollbarid = $(element).parents('.quillEditor').find('.ql-toolbar').attr('id');
	/* console.log(id); */
    id = `#${id}`;
	let quill = new Quill(id, {
         theme: 'snow',
         placeholder: 'Type your message...',
         modules: {
           //  syntax: true,
             toolbar: '#'+tollbarid
         },
    });
   quill.on('text-change', function (delta, oldDelta, source) {
        const contentText = quill.root.innerText;
       let content = quill.root.innerHTML;
       content = !isEmptyChack(contentText) ? content : null;
       const quillEditorInput = $(element).parents('.quillEditor').find('.quillEditorInput');

       quillEditorInput.val(content);
        if (!isEmptyChack(quillEditorInput.val()) && $(element).parents('.quillEditor').hasClass('is-invalid')) {
           /*  console.log("werwer"); */
            $(element).parents('.quillEditor').removeClass('is-invalid');
        } else if (hasAttr(quillEditorInput, 'required') && isEmptyChack(quillEditorInput.val())) {
            $(element).parents('.quillEditor').addClass('is-invalid');
        }

    });
    quill.on('selection-change', function (range, oldRange, source) {
        const contentText = quill.root.innerText;
        let content = quill.root.innerHTML;
        content = !isEmptyChack(contentText) ? content : null;
        if ($(element).parents('.quillEditor').find('.quillEditorInput').val() == '' && (quill.getContents().ops[0].insert == '\n' && quill.getLength() < 2 == true)) {} else {
            $(element).parents('.quillEditor').find('.quillEditorInput').trigger('change');
        }
    });


}


const  ValidateCreditCardNumber = (card_number,cardtypesArr) => {
 /*    console.log(card_number,cardtypesArr); */
    var cardmessage = '';
    var ccNum = card_number;
    var visaRegEx = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
    var mastercardRegEx = /^(?:5[1-5][0-9]{14})$/;
    var amexpRegEx = /^(?:3[47][0-9]{13})$/;
    var discovRegEx = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
    var isValid = false;
    if(visaRegEx.test(ccNum) && cardtypesArr.includes("visa")) {
        isValid = true;
    }else if(mastercardRegEx.test(ccNum) && cardtypesArr.includes("mastercard")) {
        isValid = true;
    } else if(amexpRegEx.test(ccNum)  && cardtypesArr.includes("americanexpress")) {
        isValid = true;
    } else if(discovRegEx.test(ccNum) && cardtypesArr.includes("discover")) {
        isValid = true;
    }
    return isValid;
}




const  ValidateCVV = (card_number,cvv) => {
    var cvvisValid = false;
    var cvvCheck3 =/^[0-9]{3}$/;
    var cvvCheck4 =/^[0-9]{4}$/;
    var visaRegEx = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
    var mastercardRegEx = /^(?:5[1-5][0-9]{14})$/;
    var amexpRegEx = /^(?:3[47][0-9]{13})$/;
    var discovRegEx = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
    if (visaRegEx.test(card_number) && cvvCheck3.test(cvv)) {
       cvvisValid = true;
    }else if (mastercardRegEx.test(card_number) && cvvCheck3.test(cvv)) {
       cvvisValid = true;
    }else if (amexpRegEx.test(card_number) && cvvCheck4.test(cvv)) {
        cvvisValid = true;
    }else if (discovRegEx.test(card_number) && cvvCheck3.test(cvv)) {
       cvvisValid = true;
    }
    return cvvisValid;
}

let interval=null;
const countdown = (time) => {
    clearInterval(interval);
    var timer2 = time;
    interval = setInterval(function () {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        if (parseFloat(minutes) + parseFloat(seconds) > 0 && parseFloat(minutes) !=  -1) {
            $('.countdown').html(minutes + ':' + seconds);
            $('.resendBtn').attr('disabled','disabled');
        } else {
            $('.countdown').html('');
            $('.resendBtn').removeAttr('disabled');
        }
        timer2 = minutes + ':' + seconds;
    }, 1000);
}


/* A Function to Set a Cookie */
const  setCookie = (cname, cvalue, exdays) => {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/* A Function to Get a Cookie */
const  getCookie = (cname) => {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


const uiDropdown = (element=".ui.dropdown") =>{
    $(element+':not(.notUi)').each(function (index, element) {
        const plachoder = $(element).data('placeholder') ?? null;
        let clearable = true
        if($(element).hasClass('maindropdown')){
            clearable = false;
        }
        $(element).dropdown({
            clearable: clearable,
            placeholder: 'any'
       },
       );
    });
}


function checkBoxFormat (value,row) {

    return `<div class="checkbox_custom">
        <input  type="checkbox" value="${row.id}" id="${row.id}">
        <label for="${row.id}"></label>
    </div>`;
}



const dollerFA = (amount) => {
    amount = parseFloat(amount);
  /*   console.log(amount); */
    amount =  amount.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
      })
     /*  console.log(amount); */
    return amount;
}


const sqCardLoad =  async  (element) => {
    showLoader();
	if($(element).find(".sq-card-wrapper").length == 0){
        if (window.Square) {
            const payments = window.Square.payments(appId, locationId); 
        try {
            const card = await payments.card();
            await card.attach(element);
            if($(element).find(".sq-card-wrapper").length > 0){
                HideLoader();
            }
          
            return card;  
            } catch (e) {
                console.error('Initializing Card failed', e);
                HideLoader();
                return;
              
            }
        }
	
	}else{
        HideLoader();
		console.log(card);
	}
  
}