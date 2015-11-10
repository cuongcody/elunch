$(function() {
    $('#delete_floor_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var floor_id = $(e.relatedTarget).data('floor-id');
            $(e.currentTarget).find('input[name="floor_id"]').val(floor_id);
        });

    $('#delete_floor').click(function() {
        var floor_id = $('input[name="floor_id"]').val();
        base_url = $('#delete_floor').data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + floor_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#floor_' + floor_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#floor_' + floor_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        });
    });
});