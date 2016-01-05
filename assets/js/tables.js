$(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        table_id = $(e.target).data('table-id');
        base_url = $(e.target).data('path');
        var day  = $('input[name="day"]').val();
        $('#add_user_modal input[name="table_id"]').val(table_id);
        $('#leave_table_modal input[name="table_id"]').val(table_id);
        getUsersInTableAjax(base_url, table_id, day);
    });

    $('#add_user').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var table_id = $('#add_user_modal input[name="table_id"]').val();
        var user_id = $( "#user-choose option:selected" ).val();
        var day  = $('input[name="day"]').val();
        base_url = $(this).data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + '?day=' + day,
            dataType: 'json',
            data: {table_id:table_id, user_id:user_id, day:day},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        toastr.success(res.message);
                        $('.users_item').append(
                            "<tr id='user_" + res.user.id + "' class='heading'>" +
                            "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='" + res.user.avatar_content_file + "'alt=''></td>" +
                            "<td class='column-title'>" + res.user.first_name + "</td>" +
                            "<td class='column-title'><input type='checkbox' disabled class='text-center' name='vehicle' " + ((res.user.want_vegan_meal == 1) ? 'checked' : '') + "></td>" +
                            "<td class='column-title'>" + res.user.floor + "</td>" +
                            "<td class='column-title'><a href='#leave_table_modal' class='label label-warning' data-toggle='modal' data-target='#leave_table_modal' data-table-id='" + table_id + "' data-user-id='" + res.user.id + "' onclick='false;'><i class='fa fa-times'></i></a></td></tr>"
                        );
                        new_occupied_seats = parseInt($('#table-tab_' + table_id).find('.occupied_seats').text()) + 1;
                        $('#table-tab_' + table_id).find('.occupied_seats').text(new_occupied_seats);
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });

    $('#leave_table_modal').on('show.bs.modal', function(e) {
            var user_id = $(e.relatedTarget).data('user-id');
            $('#leave_table_modal input[name="user_id"]').val(user_id);
        });

    $('#leave_table').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var table_id  = $('#leave_table_modal input[name="table_id"]').val();
        var user_id  = $('#leave_table_modal input[name="user_id"]').val();
        base_url = $(this).data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {table_id:table_id, user_id:user_id},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#user_' + user_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#user_' + user_id).remove();
                         });
                        new_occupied_seats = parseInt($('#table-tab_' + table_id).find('.occupied_seats').text()) - 1;
                        $('#table-tab_' + table_id).find('.occupied_seats').text(new_occupied_seats);
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });

    $('#delete_table_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var table_id = $(e.relatedTarget).data('table-id');
            $(e.currentTarget).find('input[name="table_id"]').val(table_id);
        });

    $('#delete_table').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var table_id = $('#delete_table_modal input[name="table_id"]').val();
        base_url = $('#delete_table').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + table_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#table_' + table_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#table_' + table_id).remove();
                         });
                    }
                    else {toastr.error(res.message);}
                });
            }
        })
    });
});

function getUsersInTableAjax(base_url, table_id, day)
{
    $.ajax({
        type:"POST",
        url: base_url + "/" + table_id + "?day=" + day,
        data: {},
        dataType: 'json',
        success: function(res){
            $('.users_item').empty();
            $.each(res, function(index, value){
                $('.users_item').append(
                    "<tr id='user_"+value.id+"' class='heading'>" +
                         "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='" + value.avatar_content_file + "'alt=''></td>" +
                         "<td class='column-title'>" + value.first_name + "</td>" +
                         "<td class='column-title'><input type='checkbox' disabled class='text-center' name='vehicle' " + ((value.want_vegan_meal == 1) ? 'checked' : '') + "></td>" +
                         "<td class='column-title'>" + value.floor + "</td>" +
                         "<td class='column-title'><a href='#leave_table_modal' class='label label-warning' data-toggle='modal' data-target='#leave_table_modal' data-table-id='" + table_id + "' data-user-id='" + value.id + "' onclick='false;'><i class='fa fa-times'></i></a></td></tr>"
                );
            });
            $('#table-tab_' + table_id).find('.occupied_seats').text(res.length);
        }
    });
}
