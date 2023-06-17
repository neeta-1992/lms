var buttonsArr = {};

let checkBoxFitteHtml = null;

$("[data-table='bootstrap-table']").each(function (index, element) {
    // element == this
   /*  console.log(element); */
   
    let bootstrapTableButtonObj = {};
    const id = $(element).attr('id');
    if (!isEmptyChack(id)) {
        let josnArr = iconsArr[id];
        if (josnArr?.Column?.status) {
            $(element).attr('data-show-columns', true);
        }
        if (josnArr?.Refresh?.status) {
            $(element).attr('data-show-refresh', true);
        }
        if (josnArr?.Search?.status) {
            $(element).attr('data-search', true);
        }
        if (josnArr?.export?.status) {
            $(element).attr('data-show-export', true);
           
            
        }
    }

    $(element).bootstrapTable();
    /*
        Bootstrap Table Is Empty And Add Pagination Button Defilt 1
    */
    $(element).on('load-success.bs.table', async function (e, data, status) {
        let currenttableid = $(this).attr('id');
        let totalCount = await data.total ?? 0;
        if (isEmptyChack(totalCount)) {
            $(this).addClass('isEmpatyTable')
            $(this).parents('.bootstrap-table').find('.pagination .page-item.page-pre').after('<li class="page-item active"><a class="page-link" aria-label="to page 1" href="javascript:void(0)">1</a></li>');
        }
  
        if(typeof iconsArr[currenttableid] != undefined &&  !isEmptyChack(iconsArr[currenttableid]?.export?.class)){
            $(this).parents('.bootstrap-table').find('.export').addClass(`${iconsArr[currenttableid]['export']['class']}`)
        }
    });



});

function CheckBoxFormat(value, row, index) {
    return `<div class="checkbox_custom ">
	    <input type = "checkbox" class = "form-check-input styled-checkbox tableSelectCheckBox" id="table_check_box_${index}" value="${row.id}">
	    <label for="table_check_box_${index}"></label>
    </div>`;
}

$(document).on('change', '.customeFilter input', function () {
    const tableId = $(this).parents('.bootstrap-table').find('.fixed-table-body table').attr('id');
    $(`#${tableId}`).bootstrapTable('refresh');
});


function buttons() {
    var currenttableid = $($(this)[0].$el).attr("id");
    let otherArr = $(`#${currenttableid}`).data('other')  ?? null;
    let customeFilter = $(`#${currenttableid}`).data('custome-filter') ?? null;

    let customeFilterChecked = $(`#${currenttableid}`).data('custome-filter-checked')  ?? null;
    if (!isEmptyChack(otherArr)) {
        iconsArr = $.extend({}, iconsArr, otherArr);
    }


    buttonsArr = {};
    if (currenttableid != '' && currenttableid != undefined) {
        if (iconsArr[currenttableid] != undefined && iconsArr[currenttableid] != '') {
            $.each(iconsArr[currenttableid], function (key, value) {
                if ((key != 'Search' && key != 'Refresh' && key != 'Columns') && iconsArr[currenttableid][key]['status'] == true) {
                    let buttonhtml = (iconsArr[currenttableid][key]['html'] != undefined) && (iconsArr[currenttableid][key]['html'] != '') ? iconsArr[currenttableid][key]['html'] : '';
                    let buttonClass = (iconsArr[currenttableid][key]['class'] != undefined) && (iconsArr[currenttableid][key]['class'] != '') ? iconsArr[currenttableid][key]['class'] : '';
                 /*   console.log(buttonClass); */
                    buttonsArr[key] = {
                        'icon': iconsArr[currenttableid][key]['icon'],
                        'text': iconsArr[currenttableid][key]['text'],
                        'actiontype': iconsArr[currenttableid][key]['actiontype'],
                        'action': iconsArr[currenttableid][key]['action'],
                        'html': buttonhtml,
                        'class': buttonClass
                    };
                }
            });
        }
    }

    var arr = {};
    $.each(buttonsArr, function (key, value) {
        var classBtn = !isEmptyChack(value['class']) ? value['class'] : '';
        var style = !isEmptyChack(value['style']) ? value['style'] : '';
        if (key == 'Exit') {
            var buttontext = !isEmptyChack(value['text']) ? value['text'] : 'Exit';
            var buttonicon = !isEmptyChack(value['icon']) ? value['icon'] : 'fa-times';
            
            arr[key] = {
                'text': buttontext,
                'class': classBtn,
                //'icon':buttonicon,
                'event': function () {
                    if (value['actiontype'] == "url") {
                        setTimeout(function () {
                            if (value['action'] != '' && value['action'] != undefined) {

                                window.location.href = value['action'];
                            }
                            localStorage.setItem("exit", "true");
                        }, 50);
                    }
                },
            }
        } else if (key == 'Edit') {
            var buttontext = !isEmptyChack(value['text']) ? value['text'] : 'Edit';
            var buttonicon = !isEmptyChack(value['icon']) ? value['icon'] : 'fa-times';
            
            arr[key] = {
                'text': buttontext,
                'class': classBtn,
                //'icon':buttonicon,
                'event': function () {
                    if (value['actiontype'] == "url") {
                        setTimeout(function () {
                            if (value['action'] != '' && value['action'] != undefined) {

                                window.location.href = value['action'];
                            }
                            localStorage.setItem("exit", "true");
                        }, 50);
                    }
                },
                attributes: {
                    ...(value.actiontype == "button" && {
                        'x-on:click': "open = 'isForm'"
                    })
                }
            }
        } else {
            
            var buttontext = !isEmptyChack(value['text']) ? value['text'] : 'Add';
            var buttonicon = !isEmptyChack(value['icon']) ? value['icon'] : '';
            

            if (!(key == 'Add' && $(`#${currenttableid}`).hasClass('disabledTable'))) {

                if (value['actiontype'] == "url") {
                    arr[key] = {
                        'text': buttontext,
                        'class': classBtn,

                        //'icon':buttonicon,
                        'event': function () {
                            //	console.log( sessionStorage);
                            window.location.href = value['action'];
                        },
                    }
                    /*  arr[key] = {
                         'text': buttontext,
                         "html": "asdasd",
                         //'icon':buttonicon,
                         'event': function () {
                             //	console.log( sessionStorage);
                             window.location.href = value['action'];
                         },
                     } */
                } else if (value['actiontype'] == "click") {
                   /*  console.log(classBtn); */
                    arr[key] = {
                        'text': buttontext,
                        'icon': buttonicon,
                        'class': classBtn,
                        ...((value['html'] != undefined && value['html'] != null && value['html'] != '') && {
                            html: '<div class="btn-group keep-open createdropdown ' + key + '"> <button class="btn btn-default borderless dropdown-toggle" type="button" data-toggle="dropdown" aria-label="' + key + '"  aria-expanded="false"><i class="fa-thin ' + buttonicon + '"></i> ' + buttontext + '</button><div class="typedropdown ' + buttonclass + ' dropdown-menu dropdown-menu-right">' + value['html'] + '</div></div>'
                        }),
                        'event': {
                            'click': () => {
                                if (!isEmptyChack(value['action'])) {
                                    value['action']()
                                }

                            }
                        },
                        attributes: {
                           
                        }
                    }
                } else if (value['actiontype'] == "attributes") {
                    let attributesAction = value['action'];
                    var buttonclass = !isEmptyChack(value['class']) ? value['class'] : '';

                    arr[key] = {
                        'text': buttontext,
                        'icon': buttonicon,
                        'class': '',
                        ...(!isEmptyChack(value['html']) && {
                            html: '<div class="btn-group keep-open createdropdown ' + key + '"> <button class="btn btn-default borderless dropdown-toggle" type="button" data-toggle="dropdown" aria-label="' + key + '"  aria-expanded="false"><i class="fa-thin ' + buttonicon + '"></i> ' + buttontext + '</button><div class="typedropdown ' + buttonclass + ' dropdown-menu dropdown-menu-right">' + value['html'] + '</div></div>'
                        }),
                        'event': {
                            'click': () => {


                            }
                        },
                        attributes: {
                            ...(attributesAction && attributesAction),
                            ...(style && style),
                            classbtn : buttonclass,
                
                            
                        }
                    }
                } else {

                    arr[key] = {
                        'text': buttontext,
                        'icon': buttonicon,
                        'event': {
                            'click': () => {
                                value['action']();
                            }
                        },
                        html: value['html'] != "undefined" && value['html'] != null && value['html'] != '' ? value['html'] : '',
                    }
                }
            }
        }
    });
    let checkEd = "";

    if (!isEmptyChack(customeFilter)) {

        checkBoxFitteHtml = `<div class="btn-group dropdown dropup customeFilter">
                                <button data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default borderless dropdown-toggle">Filter<span class="caret"></span></button>
                            <div class="dropdown-menu">`;
        $.each(customeFilter, function (indexInArray, valueOfElement) {

            if (!isEmptyChack(customeFilterChecked)) {
                if ($.inArray(parseInt(indexInArray), customeFilterChecked) == 0) {
                    checkEd = 'checked';
                 }
             }
            checkBoxFitteHtml += `<label class="dropdown-item dropdown-item-marker">
                             <input type="checkbox" data-field="id" value="${indexInArray}" ${checkEd}>
                              <span>${valueOfElement}</span></label>`;
        });
        checkBoxFitteHtml += `</div> </div>`;

    }else{
        checkBoxFitteHtml ="";
    }

    if (!isEmptyChack(checkBoxFitteHtml)) {
        let FitteObj = {
            btnAdd: {
                html: checkBoxFitteHtml,
                event: function () {
                   /*  console.log("asdasd"); */
                },
            }
        }
         Object.assign(arr, FitteObj);
    }
    return arr;
}
