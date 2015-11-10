$(function() {
    $('#delete_shift_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var shift_id = $(e.relatedTarget).data('shift-id');
            $(e.currentTarget).find('input[name="shift_id"]').val(shift_id);
        });

    $('#delete_shift').click(function() {
        var shift_id = $('input[name="shift_id"]').val();
        base_url = $('#delete_shift').data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + shift_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#shift_' + shift_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#shift_' + shift_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        });
    });
});