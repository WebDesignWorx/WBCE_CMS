/**
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

var fixHelper = function (e, ui) {
    ui.children().each(function () {
        $(this).width($(this).width());
    });
    return ui;
};
var ICONS_DIR = ADMIN_URL + "/pages/ajax/icons/";
$(function () {
    var oDragArea = $("#dndSections ul");
    oDragArea.sortable({
        appendTo: 'body',
        items: "> li:not(.tableHeader)",
        placeholder: 'sortPlaceholder',
        forcePlaceholderSize: true,
        revert: 200,
        opacity: 0.90,
        cursor: 'move',
        helper: fixHelper,
        delay: 150, // delay before dragging starts
        update: function () {
            $.ajax({
                type: 'POST',
                url: ADMIN_URL + "/pages/ajax/dd_sections.php",
                data: $(this).sortable("serialize") + '&action=updateArray',
                dataType: 'json',
                success: function (json_respond) {
                    $("#dragableResult").html(
                            '<img id="jsonOutput" src="' + ICONS_DIR + json_respond.icon + '" alt="" />'
                            ).fadeIn();
                    $("#dragableResult").fadeOut(4000);
                    //location.href = location.href.replace(/&?msg=([^&]$|[^&]*)/i, ""); // remove previous msg-strings from URI
                    if (json_respond.success != true) {
                        alert(json_respond.message);
                    }
                }
            });
        }
    })
}); 