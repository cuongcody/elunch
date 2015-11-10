$(function() {
    $('#delete_category_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var category_id = $(e.relatedTarget).data('category-id');
            $(e.currentTarget).find('input[name="category_id"]').val(category_id);
        });

    $('#delete_category').click(function() {
        var category_id = $('input[name="category_id"]').val();
        base_url = $('#delete_category').data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + category_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#category_' + category_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#category_' + category_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        });
    });
});