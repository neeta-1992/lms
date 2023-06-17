
const remotelyDropDown = (element, url, data = {},json=null,method='get') => {
  const selectedtext = $(element).data('selectedtext');
  const selected     = $(element).data('selected');
/*   console.log(element) */
    $(element)
        .dropdown({
            apiSettings: {
                // this url just returns a list of tags (with API response expected above)
                url: `${BASE_URL}${url}?search={query}`,
                data: data,
                cache: false,
                method : method
            },
            filterRemoteData: true,
            saveRemoteData: false,
          /*   minCharacters: 2, */
            clearable: true,
            onChange: function (value, text, $selectedItem) {
				$(element).find('input[type="hidden"]').val(value);
            }
        });

    if(!isEmptyChack(selectedtext)){
        $(element).dropdown('set text', selectedtext);
    }
    if(!isEmptyChack(selected)){
        $(element).dropdown('set value', selected);
    }
    if(!isEmptyChack(json)){
        $(element).dropdown('setup menu',{values:json});
        let text = "",coma ="";
        $.each(json, function (indexInArray, valueOfElement) {
            text += `${coma}${valueOfElement.value}`;
            coma =",";
        });
        $(element).dropdown('set selected', text);
    }

}

const dateDropdowns = (element = $('.dataDropDown'), destroy=false) => {
    const range = element.data('range');
    const required = element.data('required') ?? null;
    let value = element.data('value') ?? null;
    const minYear = element.data('min-year') ?? null;
    const maxYear = element.data('max-year') ?? null;
    let mindate = element.data('min-date') ?? null;
    let displayFormat = element.data('display-format') ?? 'ymd';
    if(mindate){
        mindate = new Date();
    }

    element.dropdownDatepicker({
        minAge: -1,
        maxAge: 1,
        displayFormat: displayFormat,
        monthFormat: 'short',
        ...(value && {defaultDate: value}),
        ...(mindate && {minDate: mindate}),
        ...(minYear && {minYear: minYear}),
        ...(maxYear && {maxYear: maxYear}),
        ...(required && {required: true}),
    });

   /*  if (required) {
        element.closest('.date-dropdowns').find('select').attr('required', 'required')
    } */
}

if ($('.agencyList').length > 0) {
    remotelyDropDown('.agencyList', 'common/entity/agency');
}
if ($('.salesOrganization').length > 0) {
    remotelyDropDown('.salesOrganization', 'common/entity/sales-organization');
}

if ($('.dataDropDown').length > 0) {
    $('.dataDropDown').each(function (index, element) {
       dateDropdowns($(this))
    });
}

$(document).on('change', '.dataDropDown', function () {
    const range = $(this).data('range');
    if (!isEmptyChack(range)) {
        let value = $(this).val();
        if (!isEmptyChack(value)) {
            let arrayValue = value.split("-");
            let year = arrayValue[0];
            let month = arrayValue[1];
            let day = arrayValue[2];
            $(`.${range}`).attr('data-min-year', year).attr('data-min-month', month).attr('data-min-day', day);
           /*  dateDropdowns($(`.${range}`), destroy = true); */
        }
   }
});




