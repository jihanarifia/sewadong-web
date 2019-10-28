$(document).ready(function() {
    $('div a').bind('click',function(event){
		var $anchor = $(this);       
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 700);
        event.preventDefault();
    });
});
