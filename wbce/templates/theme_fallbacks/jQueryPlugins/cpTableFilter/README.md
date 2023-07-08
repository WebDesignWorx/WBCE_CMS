cpTableFilter - jQuery Plugin for Filtering and Sorting Table Rows
==================================================================

This plugin allows you to filter and sort table rows by attaching it to an input field. The input field should have a `data-filter-table` attribute with the value set to the ID of the associated table. 

The table headers with a `filter` class will be used for filtering, and headers with a `sort` class will be used for sorting.

## Usage:
1. Include the cpTableFilter plugin code in your HTML file after including the jQuery library.
```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // cpTableFilter plugin code goes here
</script>
```
2. Add an input field to your HTML file with a data-filter-table attribute set to the ID of the associated table.
```html
<input id="filterInput" data-filter-table="myTable" type="text">
```
3. Add a table to your HTML file with an ID that matches the value of the data-filter-table attribute in the input field. Add a filter class to the headers that you want to use for filtering, and a sort class to the headers that you want to use for sorting.
```html
<table id="myTable">
  <thead>
    <tr>
      <th class="filter sort">Column 1</th>
      <th class="filter sort">Column 2</th>
    </tr>
  </thead>
  <tbody>
    <!-- Table rows go here -->
  </tbody>
</table>
```

4. Call the cpTableFilter plugin on the input field.
```html
<script> 
 $(document).ready(function() {
    $('#filterInput').cpTableFilter();
  });
</script>
```


### Initial sorting
(Optional) If you want to sort the table initially, you can set the `data-sort-column` and `data-sort-direction` attributes on the table element. 
The `data-sort-column` value should be set to the index of the column you want to sort by, and the `data-sort-direction` value should be set to either 'asc' or 'desc'.
Here is an example:

```html
<table id="myTable" data-sort-column="0" data-sort-direction="asc">
  <!-- Table content goes here -->
</table>
```


**Alternatively**, you can set these values programmatically using *jQuery* before calling the `cpTableFilter` plugin:
```js
const $table = $('#myTable');
$table.data('sort-column', 0); // Sort by first column
$table.data('sort-direction', 'asc'); // Sort in ascending order

$('#filterInput').cpTableFilter();
```

### `data-sort` Filtering dates
(Optional) If you have columns with dates in different formats, you can use the data-sort attribute on the td elements to specify a date value in a consistent format for sorting. The value of this attribute should be set to a date string in the yyyy-mm-dd format.
```html
<td data-sort="2022-01-01">January 1, 2022</td>
```
*The `data-sort` attribute can be also used for other information that needs sorting, for example if you want to sort images, icons etc. Be creative!


Happy coding.