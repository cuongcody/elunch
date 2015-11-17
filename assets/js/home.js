$(function () {
    getTablesByShiftAjax();
    interval1 = setInterval('getUsersByTablesAjax()', 10000);
    getLastestCommentsAjax();
    interval2 = setInterval('getLastestCommentsAjax()', 100000);
    var lastest_comments = $('#lastest-comments').newsTicker({
        row_height: 80,
        max_rows: 5,
        duration: 4000,
        autostart: 0,
        direction: 'up',
        prevButton: $('#lastest-comments-prev'),
        nextButton: $('#lastest-comments-next')
    });

    $('select[name="shift"]').on('change', function() {
      getTablesByShiftAjax();
    });

    $('select[name="day"]').on('change', function() {
      getTablesByShiftAjax();
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
                btn_tables += '<a class="btn ' + ((value.for_vegans == 1) ? 'btn-table-vegan' : 'btn-table-normal') + '" href="#table_' + value.id + '">' + value.name + '</a>';
                tables += '<div id="table_' + value.id + '" class="col-xs-offset-1 col-xs-8 col-xs-offset-1 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-md-12 tables">' +
                '<div class="table text-center circle big ' + ((value.for_vegans == 1) ? 'bg-green' : '') + '">' +
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
            $.each(res.tables, function(index, el) {
                for(var i = 0; i < 7; i++) {
                    $('#table_' + el.id).find('.circle-' + (i+1)).remove();
                    if (el.users[i] != undefined)
                    {
                        if (el.users[i].status_id == 2) status_user = 'border-danger';
                        else if (el.users[i].status_id == 1) status_user = 'border-success';
                        else status_user = 'border-warning';
                        html = '<a href="#choose_status_user_modal" id="user_' +
                            el.users[i].id + '" data-toggle="modal" data-target="#choose_status_user_modal" onclick="false;" class="users circle small border-a circle-' +
                            (i + 1) + ' ' + status_user + '"><img class="img-thumbnail img-user img-circle" src="' +
                            el.users[i].avatar_content_file + '"><p class="text-center">' + el.users[i].first_name + '</p>' +
                            '<input type="hidden" name="user_in_table" data-table-id="'+ el.id + '" data-user-id="'+ el.users[i].id + '" data-user-email="'+ el.users[i].email + '" data-user-avatar_content_file="'+ el.users[i].avatar_content_file + '" data-user-firstname="'+ el.users[i].first_name + '" data-user-lastname="'+ el.users[i].last_name + '" value="'+ el.users[i].status_id +'"></a>';
                        $('#table_' + el.id).find('.table').append(html);
                    }
                    else
                    {
                        $('#table_' + el.id).find('.table').append('<a class="circle small circle-' + (i + 1) + '"></a>');
                    }
                }
            });
        }
    });
}

function trackingMealLog(base_url, shift, tables, lunch_date, note, private_note, actual_meals)
{
    $.ajax({
        type:"POST",
        url: base_url,
        dataType: 'json',
        data: {shift:shift, tables:tables, lunch_date:lunch_date, note:note, private_note:private_note, actual_meals:actual_meals},
        success: function(res){
            $('.error').remove();
            if (res.status == 'failure')
            {
                $('div.tracking-body').prepend(
                    "<div class='error alert alert-warning'>" + res.message + '</div>');
            }
            else
            {
                $('#tracking_meal_log_modal').modal('toggle');
                toastr.success(res.message);
            }
        }
    });
}

$(function() {

    $('#choose_status_user_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var table_id = $(e.relatedTarget).find("input[name='user_in_table']").data('table-id');
            var user_id = $(e.relatedTarget).find("input[name='user_in_table']").data('user-id');
            $(e.currentTarget).find('input[name="table_id"]').val(table_id);
            $(e.currentTarget).find('input[name="user_id"]').val(user_id);
    });

    $(".choose-status").click(function(event) {
        base_url = $("#choose_status_user_modal").find('input[name="user_id"]').data('path');
        status = $(this).find('strong').data('status');
        user_id = $("#choose_status_user_modal").find('input[name="user_id"]').val();
        table_id = $("#choose_status_user_modal").find('input[name="table_id"]').val();
        updateStatusOfUser(base_url, table_id, user_id, status);
    });

    $("#tracking_meal_log").click(function() {
        base_url = $(this).data("path");
        lunch_date  = $('input[name="lunch_date"]').val();
        note = $('#note').val();
        private_note = $('#private_note').val();
        actual_meals = $('input[name=actual_meals]').val();
        shift = {
            id : $('input[name="shift"]').val(),
            name : $('input[name="shift"]').data('name'),
            start_time : $('input[name="shift"]').data('start-time'),
            end_time : $('input[name="shift"]').data('end-time')
        };
        var tables = [];
        $('.tables').each(function(index, value) {
            var table = {};
            var users = [];
            $(this).find('.users').each(function(index, value) {
                var user = {};
                user = {
                    email : $(this).find('input[name="user_in_table"]').data('user-email'),
                    avatar_content_file : $(this).find('input[name="user_in_table"]').data('user-avatar_content_file'),
                    first_name : $(this).find('input[name="user_in_table"]').data('user-firstname'),
                    last_name : $(this).find('input[name="user_in_table"]').data('user-lastname'),
                    status_user : $(this).find('input[name="user_in_table"]').val()
                }
                users.push(user);
            });
            table = {
                id : $(this).find('input[name="table_id"]').val(),
                name : $(this).find('input[name="table_id"]').data('name'),
                users : users
            }
            tables.push(table);
        });
        trackingMealLog(base_url, shift, tables, lunch_date, note, private_note, actual_meals);
    });

});

function updateStatusOfUser(base_url, table_id, user_id, status)
{
    $.ajax({
        type:"POST",
        url: base_url,
        dataType: 'json',
        data: {user_id:user_id, status:status},
        success: function(res){
            if (res.status == 'failure')
            {
               toastr.error(res.message);
            }
            else
            {
                toastr.success(res.message);
                $("#table_" + table_id).find('#user_' + user_id).removeClass('border-success border-warning border-danger');
                $("#table_" + table_id).find('#user_' + user_id).find('input[name="user_in_table"]').val(status);
                if (status == 1) {
                    $("#table_" + table_id).find('#user_' + user_id).addClass('border-success');
                }
                else if( status == 2) {
                    $("#table_" + table_id).find('#user_' + user_id).addClass('border-danger');
                }
                else {
                    $("#table_" + table_id).find('#user_' + user_id).addClass('border-warning');
                }
            }
        }
    });
}

function getLastestCommentsAjax()
{
    base_url = $("#lastest-comments").data('path');
    $.ajax({
        type:"POST",
        url: base_url,
        dataType: 'json',
        data: {},
        success: function(res){
            html = '';
            $.each(res.comments, function(index, value) {
                html +=  "<li><a><span class='image'>" +
                    "<img class='img-thumbnail' src='" + value.avatar_content_file + "' alt=''></span>" +
                    "<span><span>" + value.email + "</span></span>" +
                    "<span class='message'>" + ((value.content.title > 70) ? (value.title.substring(0, 70) + ' ...') : value.title) + "</span>" +
                    "<span class='time'>" + value.created_at + "</span></a>"
            });
            $('#lastest-comments').html(html);
        }
    });
}
