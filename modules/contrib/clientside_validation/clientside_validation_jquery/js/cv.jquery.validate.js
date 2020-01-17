/**
 * @file
 * Attaches behaviors for the Clientside Validation jQuery module.
 */
(function ($, Drupal, drupalSettings) {
  'use strict';

  /**
   * Attaches jQuery validate behavior to forms.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *  Attaches the outline behavior to the right context.
   */
  Drupal.behaviors.cvJqueryValidate = {
    attach: function (context) {
      if (typeof drupalSettings.cvJqueryValidateOptions === 'undefined') {
        drupalSettings.cvJqueryValidateOptions = {};
      }

      if (typeof Drupal.Ajax !== 'undefined') {
        // Update Drupal.Ajax.prototype.beforeSend only once.
        if (typeof Drupal.Ajax.prototype.beforeSubmitCVOriginal === 'undefined') {
          var validateAll = 2;
          try {
            validateAll = drupalSettings.clientside_validation_jquery.validate_all_ajax_forms;
          }
          catch(e) {
            // Do nothing if we do not have settings or value in settings.
          }

          Drupal.Ajax.prototype.beforeSubmitCVOriginal = Drupal.Ajax.prototype.beforeSubmit;
          Drupal.Ajax.prototype.beforeSubmit = function (form_values, element_settings, options) {
            if (typeof this.$form !== 'undefined' && (validateAll === 1 || $(this.element).hasClass('cv-validate-before-ajax'))) {
              $(this.$form).removeClass('ajax-submit-prevented');

              $(this.$form).validate();
              if (!($(this.$form).valid())) {
                this.ajaxing = false;
                $(this.$form).addClass('ajax-submit-prevented');
                return false;
              }
            }

            return this.beforeSubmitCVOriginal();
          };
        }
      }

      if (drupalSettings.clientside_validation_jquery.force_validate_on_blur) {
        drupalSettings.cvJqueryValidateOptions.onfocusout = function(element) {
          // "eager" validation
          this.element(element);
        };
      }

      // Allow all modules to update the validate options.
      // Example of how to do this is shown below.
      $(document).trigger('cv-jquery-validate-options-update', drupalSettings.cvJqueryValidateOptions);

      $(context).find('form').each(function() {
        $(this).validate(drupalSettings.cvJqueryValidateOptions);
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
