jQuery(document).on("click", "a.normal", function(){
    jQuery("body").removeClass("big").removeClass("bigger").addClass('normal');
});

jQuery(document).on("click", "a.big", function(){
    jQuery("body").removeClass("normal").removeClass("bigger").addClass('big');
});

jQuery(document).on("click", "a.bigger", function(){
    jQuery("body").removeClass("big").removeClass("normal").addClass('bigger');
});

jQuery(document).on("click", "a.call-center-agent", function(){
    jQuery("#modalagencts").modal();
});

jQuery(document).on("click", "button.navbar-toggle", function(){
    jQuery("#stick-bar").toggleClass('jr-open');
});
jQuery(document).click(function (event) {
var container = jQuery(".journey-nav");
        var clickover = jQuery(event.target);
//console.log(clickover);
        var _opened = jQuery(".journey-nav").hasClass("jr-open");
        if (_opened === true && !clickover.hasClass("icon-bar")&& _opened === true && !clickover.hasClass("navbar-toggle")&&  !container.is(event.target) && container.has(event.target).length === 0) {
          jQuery(".journey-nav").removeClass("jr-open");
        }
    });

jQuery('body').on('click', '.navbar-nav li', function(e){	
     if(e.target.className=='caret') 
         e.preventDefault();
     jQuery(this).find('.dropdown-menu').slideToggle();
     jQuery(this).toggleClass('submenu-open');
});
