jQuery(function($){
    function resizeDiv() {
    if ($(window).width() >= 1201 || $(window).width() <= 768) {
        $('.submenuLists').show();
        
     }
     else {
        $('.submenuLists').hide();
        $('.menu_breakpoint_btn').on('click',function(){
            $(this).parents('li').find('.submenuLists').stop().slideToggle();
        });
     }
    }
    $(document).ready(function() { 
        resizeDiv();
    });
    $(window).resize(function() { 
        resizeDiv();
    });

    //Upword Mover Slider animation
   
   
});