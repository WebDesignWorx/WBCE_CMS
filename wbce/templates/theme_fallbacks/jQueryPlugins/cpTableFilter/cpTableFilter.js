/*
Have a table with a <thead> and <th> elements 
class `sort` is for sorting
class `filter` is for filtering
```html
<table id="myTable">
  <thead>
    <tr>
      <th class="filter sort">Column 1</th>
      <th class="sort">Column 2</th>
    </tr>
  </thead>
  <tbody>
    <!-- Table rows go here -->
  </tbody>
</table>
```

If you want your table to have an initial sort add the following to the table tag
`data-sort-column` is to indicate which column it is (count starts with 0)
`data-sort-direction` asc|desc initial sort
```html
<table id="myTable" data-sort-column="0" data-sort-direction="asc">
```
Then add an input field to your HTML with a data-filter-table attribute set to the ID of the associated table.
```html
<input id="filterInput" data-filter-table="myTable" type="text">
```

To initialize the plugin use:
```js
$('#filterInput').cpTableFilter();
```

Done!
 */
(function($) {
    /**
     * cpTableFilter - jQuery Plugin for filtering and sorting table rows
     * Usage: $('#filterInput').cpTableFilter();
     */
    $.fn.cpTableFilter = function() {
        // Attach event listener to the filter input field
        const $filterInput = $(this);
        $filterInput.on('input', filterAndSortTable);

        function filterAndSortTable() {
            const filterText = $filterInput.val().toLowerCase();
            const tableId = $filterInput.data('filter-table'); // Get the associated table ID
            const $table = $('#' + tableId);
            const $filterableHeaders = $table.find('th.filter');

            // Loop through the rows in the table's tbody
            const $tableRows = $table.find('tbody tr');
            $tableRows.each(function() {
                const $row = $(this);
                let showRow = false;

                // Loop through the cells in the row that correspond to filterable headers
                $filterableHeaders.each(function(index) {
                    const $header = $(this);
                    const columnIndex = $header.index();
                    const $cell = $row.find('td').eq(columnIndex);
                    let cellText = $cell.text();

                    // Check if the cell matches the filter text
                    if (cellText.toLowerCase().includes(filterText)) {
                        showRow = true; // Set showRow to true if any cell matches

                        return false; // Exit the loop if a match is found in any cell
                    }
                });

                // Show or hide the row based on showRow value
                if (showRow) {
                    $row.show(); // Show the row
                } else {
                    $row.hide(); // Hide the row
                }
            });

            // Sort the table rows based on the sort column
            const sortColumnIndex = $table.data('sort-column');
            if (sortColumnIndex !== undefined) {
                const $sortColumnHeader = $table.find('th').eq(sortColumnIndex);
                let sortDirection = $table.data('sort-direction');

                // Toggle sort direction if the same column is clicked again
                if ($sortColumnHeader.hasClass('asc')) {
                    sortDirection = 'desc';
                } else if ($sortColumnHeader.hasClass('desc')) {
                    sortDirection = 'asc';
                } else {
                    sortDirection = 'asc'; // Default sort direction for the first click
                }

                // Remove sort indicator classes from all headers and cells
                $table.find('th, td').removeClass('asc desc');

                // Add sort indicator class to the sort column header and cells
                $sortColumnHeader.removeClass('asc desc').addClass(sortDirection);
                $table.find('tr').each(function() {
                    $(this).find('td').eq(sortColumnIndex).removeClass('asc desc').addClass(sortDirection);
                });

                // Sort the rows based on the sort column and direction
                const rows = $table.find('tbody tr').get();
                rows.sort(function(a, b) {
                    const $cellA = $(a).find('td').eq(sortColumnIndex);
                    const $cellB = $(b).find('td').eq(sortColumnIndex);
                    let valueA = $cellA.data('sort') || $cellA.text();
                    let valueB = $cellB.data('sort') || $cellB.text();

                    if (valueA < valueB) {
                        return sortDirection === 'asc' ? -1 : 1;
                    } else if (valueA > valueB) {
                        return sortDirection === 'asc' ? 1 : -1;
                    } else {
                        return 0;
                    }
                });

                // Reorder the rows in the table
                $.each(rows, function(index, row) {
                    $table.children('tbody').append(row);
                });
            }
        }

        // Add click event listener to table headers with sort class
        const tableId = $filterInput.data('filter-table'); // Get the associated table ID
        const $table = $('#' + tableId);
        $table.on('click', 'th.sort', function() {
            const $header = $(this);
            const columnIndex = $header.index();
            let sortDirection;

            // Toggle sort direction if the same column is clicked again
            if ($header.hasClass('desc')) {
                sortDirection = 'desc';
            } else {
                sortDirection = 'asc';
            }

            // Set the sort column and direction in the table's data attributes
            $table.data('sort-column', columnIndex);
            $table.data('sort-direction', sortDirection);

            // Remove sort indicator classes from all headers and cells
            $table.find('th, td').removeClass('asc desc');

            // Add sort indicator class to the sort column header and cells
            $header.removeClass('asc desc').addClass(sortDirection);
            $table.find('tr').each(function() {
                $(this).find('td').eq(columnIndex).removeClass('asc desc').addClass(sortDirection);
            });

            // Trigger the filterAndSortTable function to update the table
            filterAndSortTable();
        });

        // Show all rows initially
        $table.find('tbody tr').show();

        return this; // Enable method chaining
    };
})(jQuery);
