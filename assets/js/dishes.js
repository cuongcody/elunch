$(function() {
    $('#delete_dish_modal').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var dish_id = $(e.relatedTarget).data('dish-id');
        var image_file_name = $(e.relatedTarget).data('dish-image-file-name');
        $(e.currentTarget).find('input[name="dish_id"]').val(dish_id);
        $(e.currentTarget).find('input[name="dish_id"]').data('dish-image-file-name', image_file_name);
    });

    $('#list_users_modal').on('show.bs.modal', function(e) {
        var base_url = $(e.relatedTarget).data('path');
        jQuery.ajax({
            type: "POST",
            url:  base_url,
            dataType: 'json',
            data: {},
            success: function(res) {
               $('.users').empty();
               console.log(res);
                $.each(res.data, function(index, value){
                    $('.users').append(
                        "<tr id='user_"+value.id+"' class='heading'>" +
                            "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='" + value.avatar_content_file + "'alt=''></td>" +
                            "<td class='column-title'>" + value.first_name + "</td></tr>"
                    );
                });
            }
        })
    });
    $('#delete_dish').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var dish_id = $('#delete_dish_modal input[name="dish_id"]').val();
        var image_file_name = $('#delete_dish_modal input[name="dish_id"]').data('dish-image-file-name');
        base_url = $('#delete_dish').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + dish_id,
            dataType: 'json',
            data: {image_file_name:image_file_name},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#dish_' + dish_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#dish_' + dish_id).remove();
                         });
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });
});