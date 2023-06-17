$(document).on("input", ".validationForm input", function (e) {
    $(this).removeClass("is-valid is-invalid");
    let fieldType = this.type;
    let name = $(this).attr("name");
    $(".invalid-feedback[data-name='"+name+"']").remove();
    let username = $(this).hasClass("username");
    let cardNumber = $(this).hasClass("cardNumber");
    if(cardNumber){
        fieldType = 'cardNumber';
    }else if(username){
        fieldType = 'username';
    }else if($(this).hasClass("cardCVV")){
        fieldType = 'cardCVV';
    }
   /*  console.log(fieldType); */
    let isvalied = true;
    switch (fieldType) {
        case "text":
        case "password":
        case "textarea":
            // validateText($(this));
            break;
        case "email":
            if (validateEmail($(this))) {
                $(this).addClass("is-valid");

            } else {
                $(this).addClass("is-invalid");
                $(this).after(`<div class="invalid-feedback" data-name="${name}">Invalid Email </div>`);
                isvalied = false;
            }

            break;
        case "url":
            if (validateURL($(this))) {
                $(this).addClass("is-valid");

            } else {
                $(this).addClass("is-invalid");
                $(this).after(
                    `<div class="invalid-feedback" data-name="${name}">Invalid Url </div>`
                );
                 isvalied = false;
            }
            break;
        case "username":
            if (validateUsername($(this))) {
                $(this).addClass("is-valid");

            } else {
                $(this).addClass("is-invalid");
                 isvalied = false;
                $(this).after(`<div class="invalid-feedback" data-name="${name}">Invalid Value for this field </div>`);
            }
            break;
        case "cardNumber":
            if (ValidateCreditCardNumber($(this).val(),cardtypesArr)) {
                $(this).addClass("is-valid");
            } else {
                $(this).addClass("is-invalid");
                isvalied = false;
                let cardtypesType = !isEmptyChack(cardtypesArr) ?  cardtypesArr?.join(", ") : '';
                $(this).after(`<div class="invalid-feedback" data-name="${name}">Please add card number ${cardtypesType} </div>`);
            }
            break;
            case "cardCVV":
                if (ValidateCVV($('.cardNumber').val(),$(this).val())) {
                    $(this).addClass("is-valid");
                } else {
                    $(this).addClass("is-invalid");
                    isvalied = false;
                    $(this).after(`<div class="invalid-feedback" data-name="${name}">Invalid CVV</div>`);
                }
                break;
        case "select-multiple":
            //validateSelectMultiple($(this));
            break;
        default:
            break;
    }
   /*  console.log(isvalied); */
    if (isvalied == false) {
        $(this).parents('form').find('button[type="submit"]').attr('disabled', 'disabled')
    } else {
        $(this).parents('form').find('button[type="submit"],.saveData').removeAttr('disabled')
    }
});
// Reset form and remove validation messages
$(":reset").click(function () {
    $(":input, :checked").removeClass("is-valid is-invalid");
    $(form).removeClass("was-validated");
});

/* Space Not allow In Password input */
$(document).on('keydown', 'input[type="password"]', function (e) {
    if (e.which === 32)
         return false
});
