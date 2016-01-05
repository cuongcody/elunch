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
    $(document).on('click', 'input[name="submit"]', function(event) {
        $('.loadingx').fadeIn('slow');
        $(document).find('input[type="button"]').prop('disabled', true);
        comment_id = $('.in .post-replies').find('form').data('comment-id');
        base_url = $("#lastest-comments").data('add-reply-path') + '/' + comment_id;
        content = $('.in .post-replies').find('.content').val();
        $.ajax({
            type:"POST",
            url: base_url,
            data: {content: content},
            dataType: 'json',
            success: function(res){
                $('.loadingx').fadeOut('slow');
                $(document).find('input[type="button"]').prop('disabled', false);
                $('.error').remove();
                if (res.status == 'errors')
                {
                    $('.in .post-replies').find('form').prepend(
                        "<div class='error alert alert-warning'>" + res.message + '</div>');
                }
                else if (res.status == 'success')
                {
                    toastr.success(res.message);
                    $('.in .replies').find('ul').append("<li>" +
                                        "<a>" +
                                            "<span class='image'>" +
                                                "<img class='img-thumbnail' width=20 height=20 src='" + res.avatar_content_file + "' alt='>" +
                                            "</span>" +
                                            "<span>" +
                                            "<span>" + res.email + "</span>" +
                                            "</span>" +
                                            "<span class='message'>" + res.content + "</span>" +
                                            "<span class='time'>" + res.created_at + "</span>" +
                                        "</a>" +
                                    "</li>");
                    $('.post-replies').find('.content').val('');
                }
                else if (res.status == 'failure')
                {
                    toastr.error(res.message);
                }
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
                btn_tables += '<a class="btn ' + ((value.for_vegans == 1) ? 'btn-table-vegan' : 'btn-table-normal') + '" href="#table_' + value.id + '">' + value.name + '</a>';
                tables += '<div class="col-xs-offset-1 col-xs-8 col-xs-offset-1 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-md-12"><div id="table_' + value.id + '" class="tables orbit-center ' + ((value.for_vegans == 1) ? 'bg-green' : '') + '">' +
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
                var count_users = $('#table_' + el.id).find('.moon').length;
                for(var i = 0; i < count_users; i++) {
                    if (el.users[i] != undefined) {
                        if (el.users[i].status_id == 2) status_user = 'border-danger';
                        else if (el.users[i].status_id == 1) status_user = 'border-success';
                        else status_user = 'border-warning';
                        $('#table_' + el.id).find('.circle_' + i).addClass(status_user);
                        $('#table_' + el.id).find('.circle_' + i).addClass('update-status');
                        $('#table_' + el.id).find('.circle_' + i).attr('href', '#choose_status_user_modal');
                        $('#table_' + el.id).find('.circle_' + i).attr('id', 'user_' + el.users[i].id);
                        $('#table_' + el.id).find('.circle_' + i).attr('data-toggle', 'modal');
                        $('#table_' + el.id).find('.circle_' + i).attr('data-target', 'choose_status_user_modal');
                        html = '<img class="img-responsive img-user img-circle" src="' +
                            el.users[i].avatar_content_file + '"><div class="text-center user-name">' + el.users[i].first_name + '</div>' +
                            '<input type="hidden" name="user_in_table" data-table-id="'+ el.id + '" data-user-id="'+ el.users[i].id + '" data-user-email="'+ el.users[i].email + '" data-user-avatar_content_file="'+ el.users[i].avatar_content_file + '" data-user-firstname="'+ el.users[i].first_name + '" data-user-lastname="'+ el.users[i].last_name + '" value="'+ el.users[i].status_id +'">';
                        $('#table_' + el.id).find('.circle_' + i).html(html);
                    }
                    else {
                        $('#table_' + el.id).find('.circle_' + i).removeClass('border-danger');
                        $('#table_' + el.id).find('.circle_' + i).removeClass('border-success');
                        $('#table_' + el.id).find('.circle_' + i).removeClass('border-warning');
                        $('#table_' + el.id).find('.circle_' + i).removeClass('update-status');
                        $('#table_' + el.id).find('.circle_' + i).removeAttr('href');
                        $('#table_' + el.id).find('.circle_' + i).removeAttr('id');
                        $('#table_' + el.id).find('.circle_' + i).removeAttr('data-toggle');
                        $('#table_' + el.id).find('.circle_' + i).removeAttr('data-target');
                        $('#table_' + el.id).find('.circle_' + i).html("");
                    }
                }
            });
            $(".update-status").click(function(e) {
                /* Act on the event */
                $('#choose_status_user_modal').modal('show');
                var table_id = $(this).find("input[name='user_in_table']").data('table-id');
                var user_id = $(this).find("input[name='user_in_table']").data('user-id');
                $('#choose_status_user_modal').find('input[name="table_id"]').val(table_id);
                $('#choose_status_user_modal').find('input[name="user_id"]').val(user_id);
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
                html +=  "<li id='comment_" +  value.id + "' class='lastest-comment' data-id='" + value.id + "'><a><span class='image'>" +
                    "<img class='img-thumbnail' src='" + value.avatar_content_file + "' alt=''></span>" +
                    "<span><span>" + value.email + "</span></span>" +
                    "<span class='message'>" + ((value.content.title > 70) ? (value.title.substring(0, 70) + ' ...') : value.title) + "</span>" +
                    "<span class='time'>" + value.created_at + "</span></a>"
            });
            $('#lastest-comments').html(html);
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('.lastest-comment').click(function(event) {
                    window.location.replace($("#lastest-comments").data('comments-path'));
                });
            }
            else {
                var placement = 'bottom-left';
                var width = $("#lastest-comments").width() * 2;
                if ($('.left-side').width() == $('.right-side').width())
                {
                    placement = 'top';
                    width = $("#lastest-comments").width();
                }
                $('.lastest-comment').webuiPopover('destroy').webuiPopover({
                    placement: placement,
                    content:function() {
                        comment_id = $(this).data('id');
                        base_replies_url = $("#lastest-comments").data('replies-path');
                        var html = "<div class='replies pre-scrollable'><ul class='list-unstyled msg_list'>";
                        html += $("<div />").append($('#comment_' + comment_id).clone()).html();
                        html += getRepliesOfComment(base_replies_url, comment_id);
                        html +="</ul></div>";
                        html += "<div class='post-replies'>" +
                                    "<form method='post' data-comment-id=" + comment_id + " >" +
                                        "<div class='form-group'><textarea class='form-control content' rows=2></textarea></div>" +
                                        "<div class='form-group'><input type='button' name='submit' value='Send' class='btn btn-primary'><div class='loadingx'></div></div>" +
                                    "</form></div>";
                        return html;
                    },
                    closeable:true,
                    padding:true,
                    animation:'fade',
                    dismissible:true,
                    multi:false,
                    trigger:'hover',
                    delay: {//show and hide delay time of the popover, works only when trigger is 'hover',the value can be number or object
                        show: null,
                        hide: 300
                    },
                    cache: false,
                    width: width
                });
            }
        }
    });

}

function getRepliesOfComment(base_url, comment_id)
{
    var html="";
    var div = document.createElement('div');
    $.ajax({
        type:"POST",
        url: base_url + "/" + comment_id,
        async: false,
        dataType: 'json',
        data: {},
        success: function(res){
            $.each(res.replies, function(index, value) {
                $(div).prepend("<li>" +
                            "<a>" +
                                "<span class='image'>" +
                                    "<img class='img-thumbnail' width=20 height=20 src='" + value.avatar_content_file + "' alt='>" +
                                "</span>" +
                                "<span>" +
                                "<span>" + value.email + "</span>" +
                                "</span>" +
                                "<span class='message'>" + value.content + "</span>" +
                                "<span class='time'>" + value.created_at + "</span>" +
                            "</a>" +
                        "</li>");
            });
            html = $(div).html();
        }
    });
    return html;

}



