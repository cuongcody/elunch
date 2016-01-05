$(function () {
    getTablesByShiftAjax();
    $('select[name="shift"]').on('change', function() {
      getTablesByShiftAjax();
    });

    $('select[name="day"]').on('change', function() {
      getTablesByShiftAjax();
    });
    $(document).on('click', '.join_table', function(){
        $(".se-pre-con").fadeIn('slow');
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
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        leave_table_class ='leave_table border-danger';
                            $('#table_' + table_id).find('.circle_' + i).addClass(leave_table_class);
                            $('#table_' + table_id).find('.circle_' + i).attr('id', 'user_' + res.user.id);
                            html = '<img class="img-responsive img-user img-circle" src="' +
                                res.user.avatar_content_file + '"><div class="text-center user-name">' + res.user.first_name + '</div>' +
                                '<input type="hidden" name="user_in_table" data-table-id="'+ table_id + '" data-user-id="'+ user_id + '" data-user-email="'+ res.user.email + '" data-user-avatar_content_file="'+ res.user.avatar_content_file + '" data-user-firstname="'+ res.user.first_name + '" data-user-lastname="'+ res.user.last_name + '" value="'+ res.user.status_id +'">';
                            $('#table_' + table_id).find('.circle_' + i).html(html);
                        $('.join_table').addClass('have_joined_table');
                        $('.join_table').removeClass('join_table');
                        $('.select-table').replaceWith('<p class="text-center select-table"></p>');
                        toastr.success(res.message);
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });

    $(document).on('click', '.leave_table', function(){
        $(".se-pre-con").fadeIn('slow');
        table_id = $(this).parent().find('input[name="table_id"]').val();
        user_id = $("input[name='user']").val();
        base_url = $("input[name='user']").data("path-leave");
        jQuery.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {table_id:table_id, user_id:user_id},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        i = $('#table_' + table_id).find('#user_' + user_id).data('index');
                        $('#table_' + table_id).find('.circle_' + i).removeClass('leave_table');
                        $('#table_' + table_id).find('.circle_' + i).removeClass('border-danger');
                        $('#table_' + table_id).find('.circle_' + i).removeAttr('id');
                        $('#table_' + table_id).find('.circle_' + i).html('<p class="text-center select-table"></p>');
                        $('.have_joined_table').addClass('join_table');
                        $('.have_joined_table').removeClass('have_joined_table');
                        $('.select-table').replaceWith('<p class="text-center select-table">SELECT<i class="fa fa-plus-circle"></i></p>');
                        toastr.success(res.message);
                    }
                    else {toastr.error(res.message);}
                });
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
                tables += '<div class="col-xs-offset-1 col-xs-8 col-xs-offset-1 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-md-12"><div id="table_' + value.id + '" class="tables orbit-center">' +
                '<input type="hidden" data-seats="' + value.seats + '" data-name="' + value.name + '" name="table_id" value="' + value.id + '">' +
                '<h4 class="table-name text-center">' + value.name + '</h4></div></div></hr>';
            });
            $('.btn-tables').html(btn_tables);
            $('.all-tables').html(tables);
            $(".tables").each(function(index, el) {
                seats = $(this).find('input[name="table_id"]').data('seats');
                drawSeats($(this).attr('id'), seats,  index);
            });
            getUsersByTablesAjax();
        }
    });
}

function drawSeats(table, seats, index)
{
    if (window.matchMedia('(max-width: 767px)').matches) {
        var map = new MoonMap('#' + table, {
            n: seats,
            radius: 100
        });
    } else {
        var map = new MoonMap('#' + table, {
            n: seats,
            radius: 170
        });
    }
    $("#" + table).find('.moon').each(function(index, el) {
        $(this).addClass('circle_' + index);
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
            select_html = '<p class="text-center select-table">SELECT <i class="fa fa-plus-circle"></i></p>';
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
                var count_users = $('#table_' + el.id).find('.moon').length;
                for(var i = 0; i < count_users; i++) {
                    if (el.users[i] != undefined) {
                        leave_table_class = (el.users[i].id != user_id) ? 'border-success' : 'have_joined_table leave_table border-danger';
                        $('#table_' + el.id).find('.circle_' + i).addClass(leave_table_class);
                        $('#table_' + el.id).find('.circle_' + i).data('index', i);
                        $('#table_' + el.id).find('.circle_' + i).attr('id', 'user_' + el.users[i].id);
                        html = '<img class="img-responsive img-user img-circle" src="' +
                            el.users[i].avatar_content_file + '"><div class="text-center user-name">' + el.users[i].first_name + '</div>' +
                            '<input type="hidden" name="user_in_table" data-table-id="'+ el.id + '" data-user-id="'+ el.users[i].id + '" data-user-email="'+ el.users[i].email + '" data-user-avatar_content_file="'+ el.users[i].avatar_content_file + '" data-user-firstname="'+ el.users[i].first_name + '" data-user-lastname="'+ el.users[i].last_name + '" value="'+ el.users[i].status_id +'">';
                        $('#table_' + el.id).find('.circle_' + i).html(html);
                    }
                    else {
                        $('#table_' + el.id).find('.circle_' + i).removeClass('leave_table');
                        $('#table_' + el.id).find('.circle_' + i).removeClass('border-danger');
                        $('#table_' + el.id).find('.circle_' + i).removeAttr('id');
                        $('#table_' + el.id).find('.circle_' + i).data('index', i);
                        $('#table_' + el.id).find('.circle_' + i).addClass(((select_table == 1) ? 'have_joined_table' : 'join_table'));
                        $('#table_' + el.id).find('.circle_' + i).html(select_html);
                    }
                }
            });
        }
    });
}

