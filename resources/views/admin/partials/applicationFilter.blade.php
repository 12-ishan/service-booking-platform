
@if(isset($includeOffset) && $includeOffset)

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" defer></script>

<!-- offset area start -->
<div class="filter-button-area">
        <div class="filter-button-close"><i class="ti-close"></i></div>

        <div class="offset-settings filterData">
                    <h4>Filter Data</h4>
                    <div class="settings-list">

                       
                        <div id="filter-popup">
                        <button id="add-filter">Add Filter</button>
                        <form id="filter-form">
                    

                     
                        <!-- Filter rows will be added here dynamically -->

                 

                        <div class="applyResetBtn">
                        <button type="submit" class="applyBtn">Apply Filters</button>
                        <button type="button" class="resetBtn" id="reset-filters">Reset Filters</button></div>
                        </form>
                        </div>

                  

                       
                    </div>
        </div>
       
       
    </div>
    <!-- offset area end -->

<script>
    $(document).ready(function () {

        let config = <?= json_encode($finalColumnSettings); ?>;
       

        function addFilterRow(column, operation, value) {
            

            let options = '';
                config.forEach(function (item) {
                options += '<option value="' + item.column + '">' + item.title + '</option>';
                
               
            });

            let row = '<div class="form-row mb-2 filterDiv">' +
                '<div class="col-4 inputData">' +
                '<select class="form-control filter-column " name="filter_columns[]" required>' +
                '<option value="" disabled selected>Select Column</option>' +
                options +
                '</select>' +
                '</div>' +
                '<div class="col-3 inputData">' +
                '<select class="form-control filter-operation " name="filter_operations[]" required>' +
                '<option value="equal" ' + (operation === 'equal' ? 'selected' : '') + '>Equal</option>' +
                '<option value="between" ' + (operation === 'between' ? 'selected' : '') + '>Between</option>' +
                '<option value="like" ' + (operation === 'like' ? 'selected' : '') + '>Like</option>' +
                '</select>' +
                '</div>' +
                '<div class="col-3 inputData ">' +
                '<input type="text" class="form-control filter-value " name="filter_values[]" value="' + value + '" required>' +
                '</div>' +
                '<div class="col-2 inputData">' +
                '<button type="button" class="btn btn-danger remove-filter"><i class="fa fa-close"></i></button>' +
                '</div>' +
                '</div>';

            $('#filter-form').append(row);
        }

       
        $('#add-filter').click(function () {
            addFilterRow('', 'equal', '');
        });


        $('#filter-form').on('click', '.remove-filter', function () {
            $(this).closest('.form-row').remove();
        });

    });
</script>







<script>
    $(function() {
        // Initialize sortable list
        $("#sortable").sortable();
       

        // Handle checkbox change
        $(".column-checkbox").change(function() {
            var index = $(this).closest('li').data('index');
            var isVisible = $(this).is(':checked');

            // Update the visibility status in the modal
            $("[data-index='" + index + "']").find(".column-checkbox").prop('checked', isVisible);
        });

        // Handle save button click
        $("#saveColumns").click(function() {
            // Collect column settings after reordering
            var newColumnSettings = [];

            $("#sortable li").each(function(index) {
                var isVisible = $(this).find(".column-checkbox").is(':checked');
                newColumnSettings.push({
                    'column': $(this).data('column'),
                    'title': $(this).data('title'),
                    'visibleStatus': isVisible ? 1 : 0
                });
            });
          
      

            // Send the updated column settings to the backend using AJAX
            $.ajax({
            type: 'POST',
            url: '/admin/application/updateOrder',
                data: {
                    columnSettings: newColumnSettings,
                   
                },
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                success: function(response) {
                    // Handle success, e.g., close the modal
                    console.log(response);
                   // $("#columnModal").modal('hide');
                },
                error: function(error) {
                    // Handle error
                    console.error(error);
                }
            });
        });
    });
</script>
    @endif