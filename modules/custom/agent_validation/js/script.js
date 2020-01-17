/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
//(function ($, Drupal, window, document, undefined) {
   // $(document).ready(function (){
      // To understand behaviors, see https://drupal.org/node/756722#behaviors
      Drupal.behaviors.agent_validation = {
        attach: function(context, settings) {
           //alert('a');
        (function($) {
          var agent = {
            check : $('div.form-item-preparer input[value="agent"]'),
            form : $('#npa-search-form'),
            selection: 'input[name^="preparer"]',
            agencyid : $('input[name="agencyid"]'),
            init : function(){
              agent.hideBlock();
              agent.showBlock();
              agent.resizeColorbox();
              agent.checkFields();
            },
            hideBlock : function(){
              $('.block-agent-validation').hide();
            },
            showBlock : function(){
              if(agent.check.is(':visible')){
                agent.check.on('click', function(){
                  $.colorbox({
                    href : agent.form,
                    inline : true,
                    width : '45%',
                    height : '65%',
                    fixed : true,
                    returnFocus : false,
                    overlayClose : false,
                    escKey : false,
                    closeButton : false
                  });
                });
              }
            },
            resizeColorbox : function(){
              agent.form.find('#npn-search input[type="submit"]').on('click', function(){
                setTimeout(function(){
                  $.colorbox.resize({'width' : '45%', 'height' : '65%'});
                },400);
              });
            },
            checkFields : function(){
              $('form.webform-submission-form').on('click mousedown', agent.selection, function(){
                if($(this).val() != 'agent'){
                  agent.agencyid.attr('value', '');
                }
              });
            }
          };
            //console.log(agent);

          //$('body').one('agent-validation', function() {
          // $(document).ready(function (){
          //   alert('saa');
          //   agent.init();
          // });
          //});
            agent.init();
          })(jQuery);
        }
      };
//});
//})(jQuery, Drupal, this, this.document);
