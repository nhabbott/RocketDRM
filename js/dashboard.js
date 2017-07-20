$(document).ready(function() {
    $('#search').on("keypress", function(e) {
        console.log("Vars");
        var inputVal = $(this).val();
        var result = $('#tbody');

        if(e.which == 13) {
            if(inputVal.length) {
                console.log(inputVal);
                $.get("/helpers/server_search.php", {term: inputVal}).done(function(data) {
                    result.html(data);
                });
            }
        } else {
            result.empty();
        }
    });
});

/*$(document).ready( function() {
    jQuery.get("/helpers/server_query.php").done(function(data) {
         var result = $('#tbody');
        result.html(data);
    });
});*/