

const zipMask = (element = ".zip_mask") => {
    $(element).inputmask({ mask: "99999" });
};

const yearMask = (element = ".year_mask") => {
    $(element).inputmask({ mask: "99999" });
};
const sstin = (element = ".sstin") => {
    $(element).inputmask({ mask: "999-99-9999" });
};
const tin = (element = ".tin") => {
    $(element).inputmask({ mask: "99-9999999" });
};
;
const amount = (element = ".amount") => {
    prefix = element == '.amount' ? ' $' : '';
    $(element).each(function () {
        vanillaTextMask.maskInput({
            inputElement: $(this)[0],
            mask: textMaskAddons.createNumberMask({
                allowDecimal: '.',
                prefix: prefix,
                suffix: '',
                thousandsSeparatorSymbol: ',',
                allowDecimal: true,
                decimalLimit: 2,
                integerLimit: 6
            })
        });
    });
};
const onlyNumber = (element = ".onlyNumber") => {
    $(element).each(function () {
        let maxNumber = $(this).data('maxlength');
       vanillaTextMask.maskInput({
           inputElement: $(this)[0],
           mask: textMaskAddons.createNumberMask({
               prefix: '',
               suffix: '',
               thousandsSeparatorSymbol: '',
               ...(maxNumber && {
                   integerLimit: maxNumber
               })

           })
       });
   });
};
const percentageInput = (element = ".percentageInput") => {
    suffix = element != '.percentageInput' ? '%' : '';
    $(element).each(function () {
        vanillaTextMask.maskInput({
            inputElement: $(this)[0],
            mask: textMaskAddons.createNumberMask({
                prefix: '',
                suffix: suffix,
                thousandsSeparatorSymbol: '',
                allowDecimal: true,
                decimalLimit: 2,
                integerLimit: 3
            })
        });
    });
};
const digitLimit = (element = ".digitLimit") => {
    $(element).each(function () {
        const limit = $(this).data("limit") ?? 2;
       /*  console.log(limit); */
       vanillaTextMask.maskInput({
           inputElement: $(this)[0],
           mask: textMaskAddons.createNumberMask({
               prefix: '',
               suffix: '',
               thousandsSeparatorSymbol: '',
               integerLimit: limit
           })
       });
   });
};
const nonActive = (element = ".nonactive") => {
   $(element).each(function () {
			vanillaTextMask.maskInput({
				inputElement:$(this)[0],
				mask: textMaskAddons.createNumberMask({
					prefix: '',
					suffix: '',
					thousandsSeparatorSymbol: '',
				})
			});
		});
};
const faxMaskInput = (element = ".fax") => {
  $(element).each(function () {
    vanillaTextMask.maskInput({
        inputElement: $(this)[0],
        mask: [
            "(",
            /[1-9]/,
            /\d/,
            /\d/,
            ")",
            " ",
            /\d/,
            /\d/,
            /\d/,
            "-",
            /\d/,
            /\d/,
            /\d/,
            /\d/,
        ],
    });
    });

};

const maskInputDestroy = (element = null) => {
    vanillaTextMask.maskInput({
        inputElement: element,
        mask: textMaskAddons.createNumberMask({
            prefix: '',
            suffix: '%',
            thousandsSeparatorSymbol: '',
            allowDecimal: true,
            decimalLimit: 2,
            integerLimit: 3
        })
    }).destroy();
}

const telephoneMaskInput = (element = ".telephone") => {
    $(element).each(function () {
         vanillaTextMask.maskInput({
             inputElement: $(this)[0],
             mask: [
                 "(",
                 /[1-9]/,
                 /\d/,
                 /\d/,
                 ")",
                 " ",
                 /\d/,
                 /\d/,
                 /\d/,
                 "-",
                 /\d/,
                 /\d/,
                 /\d/,
                 /\d/,
             ],
         });
    });
};
const taxId = (element = ".taxId") => {
    $(element).each(function () {
        vanillaTextMask.maskInput({
           inputElement: $(this)[0],
           mask: [/[0-9]/, /\d/, '-', /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/]
       });
    });
};


$(function () {
     if ($(".zip_mask").length > 0) {
         zipMask();
     }
     if ($(".year_mask").length > 0) {
         yearMask();
     }
     if ($(".sstin").length > 0) {
         sstin();
     }
     if ($(".tin").length > 0) {
         tin();
     }

     if ($(".taxId").length > 0) {
         taxId();
     }
     if ($(".amount").length > 0) {
         amount();
     }
     if ($(".amounts").length > 0) {
         amount('.amounts');
     }

     if ($(".percentageInput").length > 0) {
         percentageInput();
     }
     if ($(".percentage_input").length > 0) {
         percentageInput(".percentage_input");
     }
     if ($(".digitLimit").length > 0) {
         digitLimit();
     }
     if ($(".nonactive").length > 0) {
         nonActive();
     }
     if ($(".onlyNumber").length > 0) {
         onlyNumber();
     }
     if ($(".fax").length > 0) {
         faxMaskInput();
         /*  $(".fax").each(function (index, element) {
              faxMaskInput(this);
          }); */
     }
     if ($(".telephone").length > 0) {
         telephoneMaskInput();
     }
     if ($(".daysList").length > 0) {
         daysList(".daysList");
     }

     $(document).on("input", ".percentageInput,.percentage_input", function () {
         let percentageInput = $(this).val();
         percentageInput = parseInt(percentageInput.replace("%", ""));
         if (percentageInput > 100) {
             $(this).val("100%");
         }
     });

});
