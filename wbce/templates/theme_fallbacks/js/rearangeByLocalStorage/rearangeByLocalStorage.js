(function($) {
    /**
     * Rearrange elements based on click counts stored in localStorage.
     *
     * @param {Object} options - Plugin options.
     * @param {string} [options.storageKey='AdminTools'] - The key to use for storing the click count data in localStorage.
     * @param {string} [options.parentClass='subpages'] - The class of the container element for the subpages.
     * @returns {jQuery} The jQuery object.
     */
    $.fn.rearangeByLocalStorage = function(options) {
        // Default options
        var settings = $.extend({
                storageKey: 'AdminTools',
                parentClass: 'subpages'
            },
            options
        );

        // Click event handler
        this.on('click', function() {
            var recId = $(this).attr('id');
            var recordArray = getRecordsFromStorage() || [];
            var record = recordArray.find(record => record.id === recId);

            if (record) {
                record.clickCount = (record.clickCount || 0) + 1;
            } else {
                recordArray.push({
                    id: recId,
                    clickCount: 1
                });
            }

            localStorage.setItem(settings.storageKey, JSON.stringify(recordArray));
            rearrangeHTML();
        });

        // Rearrange the HTML based on click counts
        function rearrangeHTML() {
            var recordArray = getRecordsFromStorage() || [];
            var allRecords = $(this);
            var subpagesContainer = $('.' + settings.parentClass);

            allRecords.sort(function(a, b) {
                var recIdA = $(a).attr('id');
                var recIdB = $(b).attr('id');

                var recA = recordArray.find(record => record.id === recIdA);
                var recB = recordArray.find(record => record.id === recIdB);

                var clickCountA = recA ? recA.clickCount : 0;
                var clickCountB = recB ? recB.clickCount : 0;

                return clickCountB - clickCountA;
            });

            allRecords.detach().appendTo(subpagesContainer);
        }

        // Retrieve the record array from local storage
        function getRecordsFromStorage() {
            var recordArrayString = localStorage.getItem(settings.storageKey);
            return recordArrayString ? JSON.parse(recordArrayString) : null;
        }

        // Initial rearrangement of HTML based on click counts
        rearrangeHTML.call(this);

        return this;
    };
})(jQuery);