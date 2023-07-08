/**
 * cpFilterDivs is a jQuery plugin that filters a set of elements based on the text entered in an input field.
 * The plugin takes an options object as an argument. The options object can contain the following properties:
 * - inputField: The selector for the input field used for filtering. Defaults to #filter-input.
 * - filterSelector: The selector for the elements to be filtered. Defaults to .subpage.
 * - textSelector: The selector for the element containing the text to filter by. Defaults to .subpage-title a.
 */
(function ( $ ) {
    $.fn.cpFilterDivs = function( options ) {
        // Extend default settings with user-provided options
        var settings = $.extend({
            inputField: "#filter-input",
            filterSelector: ".subpage",
            textSelector: ".subpage-title a"
        }, options );
        
        // Listen for keyup event on input field
        $(document).ready(function(){
            $(settings.inputField).on("keyup", function() {
                // Get value of input field and convert to lowercase
                var value = $(this).val().toLowerCase();
                // Filter elements based on whether their text contains the value of the input field
                $(settings.filterSelector).filter(function() {
                    $(this).toggle($(this).find(settings.textSelector).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        
        // Return this to allow chaining
        return this;
    };
}( jQuery ));
