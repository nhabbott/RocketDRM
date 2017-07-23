function CallActions(action, customer) {
    jQuery.get("/helpers/actions.php", {term: action, customer: customer}).done(function(data) {
        if (data === "worked") {
            window.location.reload();
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
                $.get("/helpers/server_search.php", {term: inputVal}).done(function(data) {
                    $("#tbody").html(data);
                });
            }
        } else {
            $("#tbody").empty();
        }
    });

    $(document).ready(function() {
        jQuery.get("/helpers/server_query.php").done(function(data) {
            var result = $("#tbody");
            result.html(data);
        });
    });

    $(document).ready(function() {
        var bell = $("#bell");
        if($('#dropdown-menu a').length > 0 && $('#dropdown-menu a').attr("id") != "non") {
            bell.addClass("red");
        }
    });

    $('#dropdown-menu').on("click", ".dropdown-item", function() {
        //var count = $('#noticount').text();
        $('#search').val($('#ip').text());
        $('#search').focus();
        $('#search').trigger({type: 'keypress', which: 13, keyCode: 13});
        jQuery.get("/helpers/notify_seen.php", {id: $('#nid').text()});
        $('#noti').remove();
        //$('#noticount').text(count-1);

        if($('#noti-drop a').length == 0) {
            $('#dropdown-menu').html("<a id=\"non\" class=\"dropdown-item\">No new notifications</a>");
            $('#bell').removeClass("red");
        }
    });
});