/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */


PAGES_AJAX_DIR = ADMIN_URL + '/pages/ajax';

// remove alert boxes 
// this should only be run if bootstrap JS is not loaded
$(document).ready(function () {
    var dismiss = '[data-dismiss="alert"]';
    $(dismiss).on('click', function () {
        $(this).parent('div').remove();
    });
});


$(document).ready(function () {
    var aStates = ['registered', 'private'];
    var sVisibility = $('#visibility').val();
    if (sVisibility == 'registered' || sVisibility == 'private') {
        $('#allowed_viewers').show();
    } else {
        $('#allowed_viewers').hide();
    }

    $('#visibility').change(function () {
        var sVisibility = $(this).val();
        if (sVisibility == 'registered' || sVisibility == 'private') {
            $('#allowed_viewers').show();
        } else {
            $('#allowed_viewers').hide();
        }
    });

    if ($("#pageTree").length) {
        // HANDLE PAGE TREE TOGGLE AND COOKIES
        if ($.fn.cookie  === undefined) {
            // load cookie plugin if not available yet
            $.insert(PAGES_AJAX_DIR + "/jquery.cookie.js");
        }		
        $("#pageTree li.page").each(function () {
            var closeThis = ($.cookie('p_' + this.getAttribute("rel")) == 'closed');
            if (true == closeThis) {
                $("#" + this.id).removeClass('pt_expanded pt_collapsed').addClass('pt_collapsed');
            }
        });
        $(".pt_expander").delegate($(this).parent().parent().parent(), 'click', function () {
            var sItem = $(this).parent().parent().parent();
            var PageID = (sItem.attr('rel'));
            $.cookie('p_' + PageID, sItem.hasClass("pt_expanded") ? 'closed' : 'open');
            var classToAdd = sItem.hasClass('pt_expanded') ? 'pt_collapsed' : 'pt_expanded';
            sItem.removeClass('pt_expanded pt_collapsed').addClass(classToAdd);
            return false;
        });
        //var dnd_parent_id = "0";					
        $.insert(PAGES_AJAX_DIR + "/drag_drop_pagetree.js");
    }
    if ($("#sortSections").length) {
        $.insert(PAGES_AJAX_DIR + "/drag_drop_sections.js");
    }
});


var lastselectedindex = new Array();
function disabled_hack_for_ie(sel) {
    var sels = document.getElementsByTagName("select");
    var i;
    var sel_num_in_doc = 0;
    for (i = 0; i < sels.length; i++) {
        if (sel == sels[i]) {
            sel_num_in_doc = i;
        }
    }
    // never true for browsers that support option.disabled
    if (sel.options[sel.selectedIndex].disabled) {
        sel.selectedIndex = lastselectedindex[sel_num_in_doc];
    } else {
        lastselectedindex[sel_num_in_doc] = sel.selectedIndex;
    }
    return true;
}

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
            WB_URL + '/include/select2/js/select2.full.min.js',
            WB_URL + '/include/select2/css/select2.min.css'
        ]);

        function select2IconID (obj, data) {
            var iconUrl = $(obj.element).data('left');
            var iID = obj.id;
            var str = '<span><img src="' + iconUrl + '" class="sel2ico" style="width:16px;"> ' + obj.text + '</span>';
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
            var toHTML = $('<span><img src="' + iconUrl + '" class="sel2ico" style="width:16px;"> ' + obj.text + '</span>');
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

