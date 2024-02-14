$(document).ready(function(){

    // color toggle for rows and clickable
    /* This function will:
        1) add a on mouse over event to all dd.clickable areas
        2) will find the href attribute in dd.clickable's child
        3) add url with the link to dd.clickable				
    */			
    $("div.subpage").hover(
        function(){
            $(this).toggleClass('row_om_over');
            var URL = $(this).find('a').attr('href');
            $(this).attr('url', URL);
        }
    );

    // make whole area clickable	
    $("div.subpage").click(function() {
        window.location = $(this).attr("url");
    });	    

    if($(".hilite").length){
            $(".hilite").removeClass("hilite", 1000).addClass("hilite", 1000).removeClass("hilite", 1500);
    }
    
    $("[data-redirect-location]").click(function() {
        var sRedirect = $(this).data("redirect-location");
        window.location = sRedirect;
    });

    if($("select").length){
        // select2 implementation   
        $.insert([
            WB_URL + '/include/select2/js/select2.full.min.js'
        ]);

        function select2IconID (obj, data) {
            var iconUrl = $(obj.element).data('left');
            var iID = obj.id;
            var str = '<span><img src="' + iconUrl + '" class="sel2ico"> ' + obj.text + '</span>';
            if (iID !== '0')
                str += '<span class="select2right">' + iID +'</span>';        
            return $(str);
        };
        function matchWithID (params, data) {
            if ($.trim(params.term) === '') { return data; }
            if (typeof data.text === 'undefined') { return null; }
            var q = params.term.toLowerCase();
            if (data.text.toLowerCase().indexOf(q) > -1 || data.id.toLowerCase().indexOf(q) > -1) {
                return $.extend({}, data, true);
            }
            return null;
        }

        function select2Icon (obj) {
            var iconUrl = $(obj.element).data('left');
            var toHTML = $('<span><img src="' + iconUrl + '" class="sel2ico"> ' + obj.text + '</span>');
            return toHTML;
        };
        function select2Template (obj) {
            var sDefault = $(obj.element).data('right');
            var toHTML = '<span>' + obj.text + '</span>';
            if (sDefault)
                toHTML += '<span class="select2right">' + sDefault +'</span>';        
            return $(toHTML);
        };

        $('select#module').select2({
            width: "99%"
        });     
        $('select#language, select#default_language').select2({
            width: "99%",
            templateSelection: select2IconID,
            templateResult: select2IconID,
            matcher: matchWithID
        });

        $('select#template').select2({
            width: "99%",
            templateSelection: select2Template,
            templateResult: select2Template
        });

        $('select#target, select#menu, select#layoutblock, select#frontend_signup').select2({
            width: "99%",
            minimumResultsForSearch: -1, // don't show search field
            templateSelection: select2Template,
            templateResult: select2Template
        });

        $('select#select_groups').select2({           
            width: "99%"
        });   
        
        
    }
    
});
 



