
@if(isset($includeOffset) && $includeOffset)

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" defer></script>

<!-- offset area start -->
<div class="offset-area2">
        <div class="offset-close2"><i class="ti-close"></i></div>

        <div class="offset-settings">
                    <h4>Manage Order</h4>
                    <div class="settings-list">


                    <ul id="sortable">
                    @foreach($finalColumnSettings as $index => $columnSetting)
                        <li data-index="{{ $index }}" data-column="{{ $columnSetting['column'] }}" data-title="{{ $columnSetting['title'] }}">

                            <input type="checkbox" class="column-checkbox" {{ $columnSetting['visibleStatus'] ? 'checked' : '' }}>{{ preg_replace('/[\s\x{200B}-\x{200D}]+/u', '', $columnSetting['title']) }}</li>
                    @endforeach
                    </ul>

                     <button type="button" class="btn btn-primary" id="saveColumns">Save</button>

                       
                    </div>
                </div>
       
       
    </div>
    <!-- offset area end -->
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
