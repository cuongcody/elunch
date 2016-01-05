$(function() {
    $('#delete_user_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var user_id = $(e.relatedTarget).data('user-id');
            var avatar_file_name = $(e.relatedTarget).data('user-avatar-file-name');
            $(e.currentTarget).find('input[name="user_id"]').val(user_id);
            $(e.currentTarget).find('input[name="user_id"]').data('user-avatar-file-name', avatar_file_name);
        });

    $('#delete_user').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var user_id = $('#delete_user_modal input[name="user_id"]').val();
        var avatar_file_name = $('#delete_user_modal input[name="user_id"]').data('user-avatar-file-name');
        base_url = $('#delete_user').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + user_id,
            data: {avatar_file_name: avatar_file_name},
            dataType: 'json',
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#user_' + user_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#user_' + user_id).remove();
                         });
                    }
                    else {toastr.error(res.message);}
                });

            }
        })
    });

    $('#change_password').click(function() {
        $(".loadingx").fadeIn('slow');
        $(document).find('button').prop('disabled', true);
        base_url = $('#change_password').data("path");
        var password = $("input[name=password]").val();
        var confirm_password = $("input[name=confirm_password]").val();
        $.ajax({
            type:"POST",
            url: base_url,
            data: {password: password, confirm_password: confirm_password},
            dataType: 'json',
            success: function(res){
                $(document).find('button').prop('disabled', false);
                $(".loadingx").fadeOut('slow');
                $('.error').remove();
                if (res.status == 'failure')
                {
                    $('div.change_password').prepend(
                        "<div class='error alert alert-warning'>" + res.message + '</div>');
                }
                else
                {
                    $('#change_password_modal').modal('toggle');
                    toastr.success(res.message);
                }
            }
        });
    });

    $('#change_shift').click(function() {
        $(".loadingx").fadeIn('slow');
        $(document).find('button').prop('disabled', true);
        base_url = $('#change_shift').data("path");
        var shift = $("select[name=shift]").val();
        $.ajax({
            type:"POST",
            url: base_url,
            data: {shift: shift},
            dataType: 'json',
            success: function(res){
                $(document).find('button').prop('disabled', false);
                $(".loadingx").fadeOut('slow');
                $('.error').remove();
                if (res.status == 'failure')
                {
                    $('div.change_shift').prepend(
                        "<div class='error alert alert-warning'>" + res.message + '</div>');
                }
                else
                {
                    $('#change_shift_modal').modal('toggle');
                    toastr.success(res.message);
                }
            }
        });
    });
});