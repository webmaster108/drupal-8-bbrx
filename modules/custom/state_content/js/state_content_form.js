// (function ($) {

//   Drupal.behaviors.stateContentForm = {
//     attach: function (context) {
//       Drupal.ajax.prototype.commands.stateResult = function(ajax, response, status)
//       {
//         if(response.result == false){
//           if($.colorbox){
//             $.colorbox.resize();
//           }
//           $('#state-content-popup').find('.form-item, .form-submit, #state-intro').hide();
//         } else {
//           var url = '/'+response.path;
//           if(response.state){
//             url = url+'?state='+response.state;
//           }
//           window.location = url;
//         }
//       }
//       $('.reset-state').on('click', function(e){
//         e.preventDefault();
//         $('#state-content-popup').find('.form-item, .form-submit, #state-intro').show();
//         $('#state-content-popup #state-results').html('');
//       });


//       var state = {
//         form : $('#state-content-popup'),
//         block : $('#block-state-content-state-home'),
//         currentState : Drupal.settings.state_content.state,
//         btn : $('.show-state'),
//         init : function(){
//           state.hideForm();
//           state.zOpen();
//           state.zbtnOpen();
//         },
//         hideForm : function(){
//           state.block.css('display', 'none');
//         },
//         zOpen : function(){
//           if($('body').hasClass('state-based-content') && state.currentState == '' && state.form.length){
//             $.colorbox({
//               href : state.form,
//               inline : true,
//               maxWidth : '95%',
//               maxHeight : '85%',
//               fixed : true,
//               onClosed : function(){
//                 window.location.reload();
//               }
//             });
//           }
//         },
//         zbtnOpen : function(){
//           state.btn.on('click', function(e){
//             e.preventDefault();
//             $.colorbox({
//               href : state.form,
//               inline : true,
//               maxWidth : '95%',
//               maxHeight : '85%',
//               fixed : true,
//               onClosed : function(){
//                 window.location.reload();
//               }
//             });
//           });
//         }
//       };
//       state.init();



//     }

//   };

// })(jQuery);
