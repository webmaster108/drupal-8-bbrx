 (function ($) {

 Drupal.behaviors.stateContentSummaries = {
   attach: function (context) {

//     // Provide the summary for the node type form.
//     $('fieldset.state-content-form', context).drupalSetSummary(function(context) {
//       var vals = [];
//       // Default comment setting.
//       vals.push($(".form-item-state-content-state-enable input:checked", context).next('label').text());
//       return Drupal.checkPlain(vals.join(', '));
//     });
    var match = jQuery('.dialog-off-canvas-main-canvas').html().match(/\[[^\]]*\]/);
	if (match) {
		$("#change-state-popup").trigger("click");
		$('#myModal').on('hidden.bs.modal', function () {
          document.location.reload();
       })
	}
       
   }
 };

 })(jQuery);
