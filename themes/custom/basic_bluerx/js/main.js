// window.onscroll = function() {myFunction()};

// var navbar = document.getElementById("stick-bar");
// var sticky = navbar.offsetTop;
// var header_left = document.getElementById("header-left");

// function myFunction() {
//   if (window.pageYOffset >= sticky) {
//     navbar.classList.add("fixed-top");
//     header_left.classList.add("nav-fix");
//   } else {
//     navbar.classList.remove("fixed-top");
//     header_left.classList.remove("nav-fix");
//   }
// }
var divs = document.querySelectorAll('.webform-submission-form .panel-title');
for (var i = 0; i < divs.length; i++) {
    divs[i].classList.add('collapse-link');
}
 if (jQuery(window).width() < 768) {
 	if ( window.location.pathname == '/' ){
   var topoffset=jQuery('.pid-120').offset().top;
	}
	else
	{
	 var topoffset=jQuery('.header_wrapper_section').offset().top;	
	}
}
else {
   var topoffset=jQuery('.header_wrapper_section').offset().top;
}
 //console.log(topoffset);
 	jQuery(window).scroll(function(){
  var sticky = jQuery('.header_wrapper_section');
  
      scroll = jQuery(window).scrollTop();

  if (scroll > 20  )
  { 
  	sticky.addClass('fixed-top');
	}
  else
  { 
  	sticky.removeClass('fixed-top');
  }
   if (scroll > 450  )
  { 
  	sticky.addClass('fixed-on-scorll');
	}
  else
  { 
  	sticky.removeClass('fixed-on-scorll');
  }
});


function changeTimezone(date,ianatz) {

     // suppose the date is 12:00 UTC
     var invdate = new Date(date.toLocaleString('en-US', { 
        timeZone: ianatz 
     }));

     // then invdate will be 07:00 in Toronto
     // and the diff is 5 hours
     var diff = date.getTime()-invdate.getTime();

     // so 12:00 in Toronto is 17:00 UTC
     return new Date(date.getTime()+diff);

   }


function show_search(){
	jQuery(".region-header-left .search-block-form").addClass('m-search-block-form');
}

function chk_auth(){
	document.getElementById("edit-agree-terms-enroll-auth").checked = true;
}


(function ($){

	$(document).on('click', function (event) {
	  if (!$(event.target).closest('#header_wrapper_section').length) {
		$(".region-header-left .search-block-form").removeClass('m-search-block-form');
	    
	  }
	});

	$(document).ready(function (){
		$('.send-confirmation').click(function(e) {
            e.preventDefault();
            var email = $('#uemail').val();          
            var dataString = 'email=' + email;
            $.ajax({
            type: "POST",
            url: "/confirmation-email/sid",
            data: {
            	email: $("#uemail").val(),
                webnid: $("input[name='webnid']").val(),
            },
            dataType: "json",
            cache: false,
            success: function(result) {       
            $('.response').html(result.message);
            //$(".response").text(JSON.stringify(result));
            }
            });
        });  
		function toggleItem(elem) {
		  for (var i = 0; i < elem.length; i++) {
		    elem[i].addEventListener("click", function(e) {
		      var current = this;
		      for (var i = 0; i < elem.length; i++) {
		        if (current != elem[i]) {
		          elem[i].classList.remove('cus-tag-link');
		        } else if (current.classList.contains('cus-tag-link') === true) {
		          current.classList.remove('cus-tag-link');
		        } else {
		          current.classList.add('cus-tag-link')
		        }
		      }
		      e.preventDefault();
		    });
		  };
		}
		toggleItem(document.querySelectorAll('.webform-submission-form .panel-title'));
		$('a').filter(function() {
		    return this.hostname && this.hostname !== location.hostname;
		  }).click(function(e) {
		       if(!confirm("You are about to proceed to an external website."))
		       {
		            // if user clicks 'no' then dont proceed to link.
		            e.preventDefault();
		       };
		  });
		// $('#header-left #block-mobilesearch button.m-search').click(function(e){
		// 	console.log('clike');
		// 	 $(".region-header-left .search-block-form").addClass('m-search-block-form');
		// 	 e.preventDefault();
		// 	 return false;
		// });

		// jQuery(".search-block-form"). on("click", function(e){ e.preventDefault();
		//  return false; });

		// $('div.block-search-form-block input[name="keys"]').keypress(function (e) {
		//   if (e.which == 13) {
		//     $(this).closest('form').submit();
		//     return false;
		//   }
		// });

		// $('div.block-search-form-block button').on('click', function (e) {
		//     $(this).closest('form').submit();
		//     return false;
		// });


		$.validator.addMethod("validate_email", function(value, element) {
			if (value.length > 1) {
			    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
			        return true;
			    } else {
			        return false;
			    }
			}else{
				return true;
			}
		}, "Please enter a valid Email.");


		$.validator.addMethod("firstdayDate", function(value, element) {
		    var v = value.split('/'),
		    	n = new Date(parseInt(v[2]), parseInt(v[0]), parseInt(v[1])-1); // Date(year,month,date)
		    return this.optional(element) || v[1] ==  01;
		});

		$.validator.addMethod("xconfirm_email", function(value, element, param) {
		  return this.optional(element) || value.toLowerCase() == $(param).val().toLowerCase();
		}, "Please enter the same value again.");

		$(".nav li.expanded").hover(
		    function(){
		      $(this).addClass("open");
		    },function(){
		      $(this).removeClass("open");
		    }
		);


		var text = {
		  btn : $('.text-size span'),
		  init : function(){
		    text.changeSize();
		  },
		  changeSize : function(){
		    text.btn.on('click', function(){
		      if($(this).hasClass('big')){
		        $('body').removeClass('bigger').addClass('big');
		      } else if($(this).hasClass('bigger')){
		        $('body').removeClass('big').addClass('bigger');
		      } else {
		        $('body').removeClass('big bigger');
		      }
		    });
		  }
		};
		text.init();
		//$('input#id_search').quicksearch('div#docspage ul.pdflist li,div#docspage ul.nobullet li,div#docspage h2,div#docspage h3');
	});
	$("body").on('click', 'a.print-page', function(){
			var printContents = document.getElementsByClassName('webform-confirmation')[0].innerHTML;
		    var originalContents = document.body.innerHTML;
		    document.body.innerHTML = printContents;
		    window.print();
		    document.body.innerHTML = originalContents;
	});
})(jQuery);