// jQuery to collapse the navbar on scroll
function collapseNavbar() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
}

$(window).scroll(collapseNavbar);
$(document).ready(collapseNavbar);

// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $(this).closest('.collapse').collapse('toggle');
});

//DIV function for 'dashboard.php'
var element_pos = 0;    //Postion of the newly created elements
var iCnt = 0;
$(document).ready(function() {
    $(function() { $('#dashboard-panel-container').draggable(); });
    $(function() { $("#dashboard-panel-container").draggable().resizable(); });
    //Create more DIV, with 'ABSOLUTE' positioning
    $('#dashboard-panel-container').click(function() {
        element_pos = element_pos + $('#dashboard-panel-container').width() + 20;
        iCnt = iCnt + 1;
    });
});
