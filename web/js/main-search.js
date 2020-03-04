$(document).ready( function() {
    var searchAnythingTimer;

    function searchForAnything() {
        let val = $("#input-main-search").val();
        
        if (val.length <= 0) {
            $("#search-for-anything").slideUp(200, function() {
                $("#search-for-anything .tab-pane").removeClass("active");
                $("#search-for-anything .nav-stacked li").removeClass("active");
                $("#search-searching").addClass("active");
            });
            return;
        } 

        var request = $.ajax({
            url: baseUrl + '/site/search',
            type: 'GET',
            cache: false,
            data: {
                term: val,
            },
            beforeSend: function(data) {
                $("#search-for-anything .tab-pane").removeClass("active");
                $("#search-for-anything .nav-stacked li").removeClass("active");
                $("#search-searching").addClass("active");

                $("#search-for-anything").slideDown(200);
            },
            success: function(data) {
                console.log(data);

                let active = null;
                let exactMatch = false;

                // Customers

                let cHtml = "";
                let numCustomers = 0;
                $.each(data.customers, function(key, value) {
                    let address = ``;
                    console.log(value.line_10);
                    if (value.line_1) address = value.line_1 + ", ";
                    if (value.line_10) address += value.line_10;
                    if (value.first_name && val.toLowerCase() == value.first_name.toLowerCase()) exactMatch = true;
                    if (value.last_name && val.toLowerCase() == value.last_name.toLowerCase()) exactMatch = true;
                    if (value.line_10 && val.toLowerCase() == value.line_10.toLowerCase()) exactMatch = true;
                        
                    cHtml += `<tr>
                            <td>${value.first_name} ${value.middle_names} ${value.last_name}</td>
                            <td>${address || '<i class="text-muted">n/a</i>'}</td>
                            <td><a href="${baseUrl}/door/customer/view?id=${value.id}"">View</a>
                        </tr>
                    `;

                    numCustomers++;
                });
                if (cHtml && cHtml.length > 10) {
                    $("#search-customers tbody").html(cHtml);
                    $("#li-search-customers .badge").show().text(numCustomers);
                    active = "customers";
                } else {
                    $("#search-customers tbody").html(`<tr><td colspan="100%" class="text-center">No results</td></tr>`);
                    $("#li-search-customers .badge").hide().text(numCustomers);
                }

                // Loans

                let lHtml = "";
                let numLoans = 0;
                $.each(data.loans, function(key, value) {
                    if (val.toLowerCase() == value.reference.toLowerCase()) {
                        exactMatch = true;
                        active = "loans";
                    }
                    
                    let statusCss = "";
                    if (value.status == "completed") statusCss = "success";
                    if (value.status == "cancelled") statusCss = "danger";
                    if (value.status == "defaulted") statusCss = "danger";
                    if (value.status == "in_arrears") statusCss = "warning";

                    lHtml += `<tr class="${statusCss}">
                            <td>${value.reference}</td>
                            <td>&pound;${value.total_amount_payable}/${value.installments}</td>
                            <td>${value.first_name} ${value.last_name}</td>
                            <td><a href="${baseUrl}/door/loan/view?id=${value.id}"">View</a>
                        </tr>
                    `;
                    numLoans++;
                });
                if (lHtml && lHtml.length > 10) {
                    $("#search-loans tbody").html(lHtml);
                    $("#li-search-loans .badge").show().text(numLoans);
                    if (!exactMatch) active = "loans";
                    if (active == null) active = "loans";
                } else {
                    $("#search-loans tbody").html(`<tr><td colspan="100%" class="text-center">No results</td></tr>`);
                    $("#li-search-loans .badge").hide().text(numLoans);
                }

                // Users

                let uHtml = "";
                let numUsers = 0;
                $.each(data.users, function(key, value) {
                    if (val.toLowerCase() == value.username.toLowerCase()) exactMatch = true;
                        
                    uHtml += `<tr>
                            <td>${value.username}</td>
                            <td>${value.first_name} ${value.last_name}</td>
                            <td><a href="${baseUrl}/admin/user/modify?id=${value.id}"">View</a>
                        </tr>
                    `;
                    numUsers++;
                });
                if (uHtml && uHtml.length > 10) {
                    $("#search-users tbody").html(uHtml);
                    $("#li-search-users .badge").show().text(numUsers);
                    if (!exactMatch) active = "users";
                    if (active == null) active = "users";
                } else {
                    $("#search-users tbody").html(`<tr><td colspan="100%" class="text-center">No results</td></tr>`);
                    $("#li-search-users .badge").hide().text(numUsers);
                }

                // Set the active.
                $("#search-for-anything li").removeClass("active");
                $("#search-for-anything .tab-pane").removeClass("active");
                $(`#li-search-${active}`).addClass("active");
                $(`#search-${active}`).addClass("active");
                $('#search-for-anything .tab-pane').perfectScrollbar();
            },
            error: function(data) {
                console.error(data);
            },
        });
    }

    $(document).ready( function() {
        $("#input-main-search").bind('focus keyup', function(e){
            if (searchAnythingTimer)
                clearTimeout(searchAnythingTimer);
            searchAnythingTimer = setTimeout(searchForAnything, 400); 
        });

        $(document).click( function(e) {
            let clickedInDiv = document.getElementById('search-for-anything').contains(e.target);

            if (!clickedInDiv && e.target.id != "input-main-search") {
                $("#search-for-anything").slideUp(200, function() {
                    $("#search-for-anything .tab-pane").removeClass("active");
                    $("#search-for-anything .nav-stacked li").removeClass("active");
                    $("#search-searching").addClass("active");
                });
            }
        });

    })
})