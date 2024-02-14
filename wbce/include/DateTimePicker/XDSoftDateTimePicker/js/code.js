// add ICONS
$(document).ready(function(){
    
    SELECTOR.datetimepicker({CONFIG});
    SELECTOR.each(function() {		
            var oInputField = this;
            var sFieldID = this.getAttribute('id');
            var CAL_ICON = ' <img alt=\"[show cal]\" rel=\"' + sFieldID + '\" id=\"show_' + sFieldID + '\" class=\"showcal\"  src=\"' + ICON_CALENDER + '\" title=\"' + TEXT_CALENDAR + '\">';
            if(DELETE_DATE == true){
                    var RESET_ICON = ' <img alt=\"[reset]\" rel=\"reset_' + sFieldID + '\" class=\"reset_datetime\" src=\"' + ICON_CALENDER_OFF + '\" title=\"' + TEXT_DELETE_DATE + '\">';
            }else{ 
                    var RESET_ICON = '';
            }
            $(this).after(CAL_ICON + RESET_ICON);
            var RESET_ICON2 = $("img.reset[rel=" + sFieldID + "]");
            if($(this).val() == ''){
                    RESET_ICON2.css({ opacity: 0.2 });
            }else{
                    RESET_ICON2.css('cursor', 'pointer').click(function() {
                       $('input#' + sFieldID).val('');
                       RESET_ICON2.css({ opacity: 0.8 });
                    });
            }	
            $('#show_' + sFieldID).css('cursor', 'pointer').click(function(){							
              oInputField.focus();		
            });		
    });	

    // empty date input
    if(DELETE_DATE == true){
            $('.reset_datetime').click(function () {
                    var FIELD = this.getAttribute('rel');
                    var ID = '#' + FIELD.replace('reset_', '');
                    $(ID).attr('value', '');
            });
    }
});