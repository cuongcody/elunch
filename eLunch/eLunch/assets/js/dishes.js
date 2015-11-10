$(function() {
    $('#delete_dish_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var dish_id = $(e.relatedTarget).data('dish-id');
            var image_file_name = $(e.relatedTarget).data('dish-image-file-name');
            $(e.currentTarget).find('input[name="dish_id"]').val(dish_id);
            $(e.currentTarget).find('input[name="dish_id"]').data('dish-image-file-name', image_file_name);
        });

    $('#delete_dish').click(function() {
        var dish_id = $('#delete_dish_modal input[name="dish_id"]').val();
        var image_file_name = $('#delete_dish_modal input[name="dish_id"]').data('dish-image-file-name');
        base_url = $('#delete_dish').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + dish_id,
            dataType: 'json',
            data: {image_file_name:image_file_name},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#dish_' + dish_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#dish_' + dish_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });
});