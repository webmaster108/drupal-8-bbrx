(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.clearstone_updates = {
      attach: function (context) {
        
        $.colorbox.close();
        function addYears(num){
          var currYear = new Date().getFullYear();
          var currMonth = new Date().getMonth();
          return new Date(currYear+num, currMonth, 1);
        }



        // $("#edit-partadate").datepicker({
        //   beforeShowDay: function(date){
        //   if (date.getDate() == 1) {
        //     return [true, ''];
        //     }
        //   return [false, ''];
        //   }
        //   //startDate: addYears(-10),
        //   //endDate: addYears(2)
        // });
      }
    };
 })(jQuery, Drupal, drupalSettings);