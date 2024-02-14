/**
 *  plugins and functionality that is common to all backend themes.
 */
    
$(document).ready(function () {

    /**
     *  convert subpage title, description and link to a clickable area
     *  This is used for the sections: Start, Addons, AdminTools, Access
     */ 
    if ($("article.subpage").length) {
        // subpages: clickable article
        $(document).on('click', 'article.subpage', function() {
            // Get the link URL from the first <a> tag within the article
            const link = $(this).find('a:first').attr('href');
            // Redirect the user to the link URL
            window.location.href = link;
        });    
    }
    
    
    /**
     *  AdminTools Overview, load and apply plugins for 
     *  filtering and remembering latest used tools
     */ 
    if ($("#AdminToolsFilter").length) {
        
        // Filter AdminTools
        $.insert(JQUERY_PLUGINS + '/cpFilterDivs/cpFilterDivs.js');        
        $(".subpages").cpFilterDivs({
            inputField: "#AdminToolsFilter",
            filterSelector: ".subpage",
            textSelector: ".subpage-title"
        });
        
        // Remember and Rearange by local storage
        $.insert(JQUERY_PLUGINS + '/rearangeByLocalStorage/rearangeByLocalStorage.js');
        $('.subpage').rearangeByLocalStorage({
            storageKey: 'toolArray',
            parentClass: 'subpages'
        });
    };
    
    /**
     *  TableFilter 
     *  (search/filter in table) 
     */      
    if ($(".cp-table-filter").length) {
        $.insert(JQUERY_PLUGINS + '/cpTableFilter/cpTableFilter.js');    
        // initiate table filter and search
        $('#filterInput').cpTableFilter();      
    }
    
    /**
     *  cp-toggle-section
     *  Event handler for the '.toggle-section' class checkboxes
     */
    $('.toggle-section').on('change', function () {
        // derrive the divID from data-div-id attribute from the checkbox element
        var sectionElement = $(this).closest('.cp-toggle-section').find('section');
        $(sectionElement).toggle(this.checked);
        
        // Find the closest parent div with class 'cp-toggle-section'
        var cpToggleSection = $(sectionElement).closest('.cp-toggle-section'); 

        if (this.checked == false) {
            // Add the desired class when the checkbox is checked
            cpToggleSection.addClass('cp-toggle-section-closed'); 
        } else {
            // Remove the class when the checkbox is not checked
            cpToggleSection.removeClass('cp-toggle-section-closed'); 
        }
    }).change(); // Ensure visible state matches initially   
    
    /**
     *  cp-required class
     *  Add class cp-required to cp-setting-name if the corresponding element
     *  has the `required` attribute.
     */
    $('.cp-setting-value input[required], .cp-settings .cp-setting-value select[required]').each(function() {
        // Find the closest preceding `.cp-setting-name` element
        var $label = $(this).closest('.cp-setting-value').prev('.cp-setting-name');
        // Add the class `cp-required` to the `cp-setting-name` element
        $label.addClass('cp-required');
    });

    /**
     * Redirect location in buttons using data-redirect-location attribute
     * <button type="button" data-redirect-location="index.php" class="button ico-back">BACK</button>
     */
    $('[data-redirect-location]').click(function() {
        var redirectLocation = $(this).data('redirect-location');
        window.location.href = redirectLocation;
    });
  
});
