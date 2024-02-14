/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

var ICONS_DIR = ICONS_DIR ? ICONS_DIR : PAGES_AJAX_DIR + "/icons/";
(function ($) {
    $("#dndPages ol").sortable({
        opacity: 0.9,
        items: "> li:not(.staticItem)",
        placeholder: 'placeholder',
        forcePlaceholderSize: true,
        handle: '.moveable',
        delay: 100, // delay before dragging starts		
        revert: true,
        update: function () {
            $.ajax({
                type: 'POST',
                url: PAGES_AJAX_DIR + "/ajax_dragdrop.php",
                data: $(this).sortable("serialize") + '&action=updateArray',
                dataType: 'json',
                success: function (json_respond) {
                    $("#dragableResult").html(
                            '<img id="jsonOutput" src="' + ICONS_DIR + json_respond.icon + '" alt="" />'
                            ).fadeIn(250);

                   // console.log(json_respond.message)
                    $("#jsonOutput").fadeOut(2800);
                    if (json_respond.success != true) {
                        alert(json_respond.message);
                    }
                },
                error: function (json_respond) {
                    console.log(json_respond.message)
                }
            });
        }
    });
})(jQuery);