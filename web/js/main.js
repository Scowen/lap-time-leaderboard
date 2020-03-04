$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip()

    $(".link-disabled").click(function(e) {
        e.preventDefault();
    })

    $(".switches").bootstrapSwitch({
        'onText': 'YES',
        'offText': 'NO'
    });

    $('.datetimepicker').datetimepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });

    $('.datepicker').datetimepicker({
    format: 'DD/MM/YYYY',    //use this format if you want the 12hours timpiecker with AM/PM toggle
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    }
});

    $('.timepicker').datetimepicker({
    //          format: 'H:mm',    // use this format if you want the 24hours timepicker
    format: 'h:mm A',    //use this format if you want the 12hours timpiecker with AM/PM toggle
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    }

});

    let totalOutstanding = 0;
    let numLoans = $(".loan.add-to-total").length;
    let loansCount = 0;
    console.log(`Num Loans: ${numLoans}`);
    $.each($(".loan"), function(index, value) {
        let loan = $(this);
        let id = $(loan).attr("data-id");

        var request = $.ajax({
            url: baseUrl + '/customer/loan/outstanding',
            type: 'GET',
            cache: false,
            data: {
                id: id
            },
            beforeSend: function(data) {
                $(loan).find(".loan-outstanding").html("<i class='fa fa-spinner fa-pulse'></i>");
            },
            success: function(data) {
                $(loan).find(".loan-outstanding").html(number_format(data, 2));

                if ($(loan).hasClass("add-to-total")) {
                    totalOutstanding += parseFloat(data);
                    loansCount++;
                    if (numLoans == loansCount)
                        $(".total-outstanding").html(number_format(totalOutstanding, 2));
                }
            },
            error: function(data) {
                console.error(data);
                $(loan).find(".loan-outstanding").html("<i class='fa fa-times text-danger'></i> Error");
            },
        });
    })
});
