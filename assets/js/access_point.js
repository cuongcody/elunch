$(function() {
    $('#delete_access_point_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var access_point_id = $(e.relatedTarget).data('access-point-id');
            $(e.currentTarget).find('input[name="access_point_id"]').val(access_point_id);
        });

    $('#delete_access_point').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var access_point_id = $('input[name="access_point_id"]').val();
        base_url = $('#delete_access_point').data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + access_point_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#access_point_' + access_point_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#access_point_' + access_point_id).remove();
                        });
                    }
                    else toastr.error(res.message);
                });
            }
        });
    });
});
function chooseAccessPoint() {
        $(".se-pre-con").fadeIn('slow');
        var base_url = $("#push_notification").data('path');
        jQuery.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success') toastr.success(res.message);
                    else toastr.error(res.message);
                });
            }
        });

    }