var previousElement;

function btnWarning(element, text, disabled = true) {
    previousElement = element.clone();

    $(element).addClass("btn-fill")
        .addClass("btn-warning")
        .removeClass("btn-success")
        .removeClass("btn-danger")
        .removeClass("btn-primary")
        .removeClass("btn-info")
        .html(`<i class="fa fa-spin fa-refresh"></i> ${text}`);

    if (disabled)
        $(element).addClass("disabled");
    else 
        $(element).removeClass("disabled");

    return element;
}

function btnSuccess(element, text, disabled = false) {
    $(element).addClass("btn-fill")
        .addClass("btn-success")
        .removeClass("btn-warning")
        .removeClass("btn-danger")
        .removeClass("btn-primary")
        .removeClass("btn-info")
        .html(`<i class="fa fa-check"></i> ${text}`);

    if (disabled)
        $(element).addClass("disabled");
    else 
        $(element).removeClass("disabled");

    return element;
}

function btnDanger(element, text, disabled = false) {
    $(element).addClass("btn-fill")
        .addClass("btn-danger")
        .removeClass("btn-warning")
        .removeClass("btn-success")
        .removeClass("btn-primary")
        .removeClass("btn-info")
        .html(`<i class="fa fa-times"></i> ${text}`);

    if (disabled)
        $(element).addClass("disabled");
    else 
        $(element).removeClass("disabled");

    return element;
}
