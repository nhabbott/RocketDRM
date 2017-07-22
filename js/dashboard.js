function CallActions(action, customer) {
    jQuery.get("/helpers/actions.php", {term: action, customer: customer}).done(function(data) {
        console.log(data);
        if (data === "worked") {
            window.location.reload();
            console.log("worked");
        } else if (data === "failed") {
            console.log("failed");
        }
    });
}

$(document).ready(function() {
    $("#search").on("keypress", function(e) {
        var inputVal = $(this).val();

        if(e.which == 13) {
            if(!inputVal.length) {
                $.get("/helpers/server_query.php").done(function(data) {
                    var result = $("#tbody");
                    result.html(data);
                });
            } else if(inputVal.length) {
                console.log("inputVal");
                $.get("/helpers/server_search.php", {term: inputVal}).done(function(data) {
                    $("#tbody").html(data);
                });
            }
        } else {
            $("#tbody").empty();
        }
    });

    $(document).ready( function() {
        jQuery.get("/helpers/server_query.php").done(function(data) {
            var result = $("#tbody");
            result.html(data);
        });
    });
});