$(function () {
    getTablesByShiftAjax();
    $('select[name="shift"]').on('change', function() {
      getTablesByShiftAjax();
    });

    $('select[name="day"]').on('change', function() {
      getTablesByShiftAjax();
    });
    $(document).on('click', '.join_table', function(){
        table_id = $(this).parent().find('input[name="table_id"]').val();
        user_id = $("input[name='user']").val();
        base_url = $("input[name='user']").data("path-join");
        i = $(this).data('index');
        jQuery.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {table_id:table_id, user_id:user_id},
            success: function(res) {
                if (res.status == 'success')
                {
                    html = '<a id="user_' +
                            res.user.id + '" class="leave_table users border-danger circle small border-a circle-' +
                            i  + '" data-index="' + i + '"><img class="img-thumbnail img-user img-circle" src="' +
                            res.user.avatar_content_file + '"><p class="text-center">' + res.user.first_name + '</p>' +
                            '<input type="hidden" name="user_in_table" data-table-id="'+ table_id + '" data-user-id="'+ res.user.id + '" data-user-email="'+ res.user.email + '" data-user-avatar_content_file="'+ res.user.avatar_content_file + '" data-user-firstname="'+ res.user.first_name + '" data-user-lastname="'+ res.user.last_name + '" value="'+ res.user.status_id +'"></a>';
                    $(this).remove();
                    $('#table_' + table_id).find('.table').append(html);
                    $('.join_table').addClass('have_joined_table');
                    $('.join_table').removeClass('join_table');
                    $('.select-table').replaceWith('<p class="text-center select-table"></p>');
                    toastr.success(res.message);
                }
                else {toastr.error(res.message);}
            }
        });
    });

    $(document).on('click', '.leave_table', function(){
        table_id = $(this).parent().find('input[name="table_id"]').val();
        user_id = $("input[name='user']").val();
        base_url = $("input[name='user']").data("path-leave");
        jQuery.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {table_id:table_id, user_id:user_id},
            success: function(res) {
                if (res.status == 'success')
                {
                    i = $('#table_' + table_id).find('#user_' + user_id).data('index');
                    $('#table_' + table_id).find('#user_' + user_id).remove();
                    $('#table_' + table_id).find('.table').append('<a class="join_table circle small circle-' + i + '" data-index="' + i +'"><p class="text-center select-table">SELECT <br><i class="fa fa-plus-circle"></i></p></a>');
                    $('.have_joined_table').addClass('join_table');
                    $('.have_joined_table').removeClass('have_joined_table');
                    $('.select-table').replaceWith('<p class="text-center select-table">SELECT <br><i class="fa fa-plus-circle"></i></p>');
                    toastr.success(res.message);
                }
                else {toastr.error(res.message);}
            }
        });
    });

});

function getTablesByShiftAjax() {
    shift_id = $('select[name="shift"] option:selected').val();
    day = $('select[name="day"] option:selected').val();
    base_url = $('select[name="shift"]').data('path');
    jQuery.ajax({
        type:"POST",
        url: base_url,
        data: {shift_id:shift_id, day:day},
        dataType: 'json',
        success: function(res){
            $(".choose_day").find('input[name=shift]').remove();
            $(".choose_day").append('<input type="hidden" data-end-time="' + res.shift.end_time + '" data-start-time ="'+ res.shift.start_time + '" data-name ="' + res.shift.name + '" value="' + res.shift.id + '" name="shift" >');
            btn_tables = '';
            tables = '';
            $.each(res.tables, function(index, value) {
                btn_tables += '<a class="btn btn-table-normal" href="#table_' + value.id + '">' + value.name + '</a>';
                tables += '<div id="table_' + value.id + '" class="col-xs-offset-1 col-xs-8 col-xs-offset-1 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-md-12 tables">' +
                '<div class="table text-center circle big">' +
                '<input type="hidden" data-name="' + value.name + '" name="table_id" value="' + value.id + '">' +
                '<h4 class="table-name text-center">' + value.name + '</h4></div></div></hr>'
            });
            $('.btn-tables').html(btn_tables);
            $('.all-tables').html(tables);
            getUsersByTablesAjax();
        }
    });
}
function getUsersByTablesAjax() {
    day = $('select[name="day"] option:selected').val();
    base_url =  $('select[name="day"]').data('path');
    user_id = $("input[name='user']").val();
    table_ids = [];
    $(".tables").find('input[name="table_id"]').each(function(index, value) {
        table_ids.push($(this).val());
    });
    jQuery.ajax({
        type:"POST",
        url: base_url,
        data: {table_ids:table_ids, day:day},
        dataType: 'json',
        success: function(res){
            select_html = '<p class="text-center select-table">SELECT <br><i class="fa fa-plus-circle"></i></p>';
            select_table = 0;
            $.each(res.tables, function(index1, el1) {
                $.each(el1.users, function(index2, el2) {
                    if (el2.id == user_id)
                    {
                        select_html = '<p class="text-center select-table"></p>';
                        select_table = 1;
                    }
                });
            });
            $.each(res.tables, function(index, el) {
                for(i = 0; i < 7; i++) {
                    $('#table_' + el.id).find('.circle-' + (i+1)).remove();
                    if (el.users[i] != undefined)
                    {
                        leave_table_class = (el.users[i].id != user_id) ? '' : 'leave_table border-danger';
                        html = '<a id="user_' +
                            el.users[i].id + '" class="' + leave_table_class + ' users border-success circle small border-a circle-' +
                            (i + 1) + '" data-index="' + (i + 1) + '"><img class="img-thumbnail img-user img-circle" src="' +
                            el.users[i].avatar_content_file + '"><p class="text-center">' + el.users[i].first_name + '</p>' +
                            '<input type="hidden" name="user_in_table" data-table-id="'+ el.id + '" data-user-id="'+ el.users[i].id + '" data-user-email="'+ el.users[i].email + '" data-user-avatar_content_file="'+ el.users[i].avatar_content_file + '" data-user-firstname="'+ el.users[i].first_name + '" data-user-lastname="'+ el.users[i].last_name + '" value="'+ el.users[i].status_id +'"></a>';
                        $('#table_' + el.id).find('.table').append(html);
                    }
                    else
                    {
                        $('#table_' + el.id).find('.table').append('<a class="' + ((select_table == 1) ? 'have_joined_table' : 'join_table') + ' circle small circle-' + (i + 1) + '" data-index="' + (i + 1) + '">' + select_html +'</a>');
                    }
                }
            });
        }
    });
}

