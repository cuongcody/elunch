$(function() {
    $('#menu').on('change', function() {
        $('.dishes-of-menu').empty();
        menu_id = $(this).val();
        base_url = $(this).data("path");
        getDishesByMenuAjax(base_url + '/' + menu_id);
    });

    $('#list_dishes_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var base_url = $(e.relatedTarget).data('path');
            getDishesByMenuAjax(base_url);
    });

    $('#delete_meal_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var meal_id = $(e.relatedTarget).data('meal-id');
            $(e.currentTarget).find('input[name="meal_id"]').val(meal_id);
    });

    $('#delete_meal').click(function() {

        var meal_id  = $('#delete_meal_modal input[name="meal_id"]').val();
        base_url = $('#delete_meal').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + meal_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#meal_' + meal_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#meal_' + meal_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });

    $('.btn-meal-report').click(function() {
        meal_date = $(this).data('date');
        base_url = $(this).data('path');
        window.location.replace(base_url + '/' + meal_date);
    });

    $('#gen_log_file_meal_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var meal_id = $(e.relatedTarget).data('meal-id');
            var meal_date = $(e.relatedTarget).data('meal-date');
            $(e.currentTarget).find('input[name="meal_id"]').val(meal_id);
            $(e.currentTarget).find('input[name="meal_date"]').val(meal_date);
    });

    $('#choose_status_user_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var table_id = $(e.relatedTarget).find("input[name='user_in_table']").data('table-id');
            var user_id = $(e.relatedTarget).find("input[name='user_in_table']").data('user-id');
            $(e.currentTarget).find('input[name="table_id"]').val(table_id);
            $(e.currentTarget).find('input[name="user_id"]').val(user_id);
    });

    $('#gen_log_file_meal').click(function() {
        var meal_id  = $('#gen_log_file_meal_modal input[name="meal_id"]').val();
        var meal_date  = $('#gen_log_file_meal_modal input[name="meal_date"]').val();
        base_url = $('#gen_log_file_meal').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + meal_date,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#meal_' + meal_id).find('.log_file').hide('slow', function() {
                        toastr.success(res.message);
                        $('#meal_' + meal_id).find('.log_file').remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
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
        trackingMealLog(base_url, shift, tables, lunch_date, note, actual_meals);
    });

});

$(function() {
    menu_id = $("#menu").val();
    base_url = $("#menu").data("path");
    if (menu_id != undefined) getDishesByMenuAjax(base_url + '/' + menu_id);
});

function getDishesByMenuAjax(base_url)
{
    $.ajax({
        type:"POST",
        url: base_url,
        data: {},
        dataType: 'json',
        success: function(res){
            $('.dishes-of-menu').empty();
            $.each(res, function(index, value){
                $('.dishes-of-menu').append(
                    "<tr class='heading'><td class='column-title'></td>" +
                         "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='" + value.image + "'alt=''></td>" +
                         "<td class='column-title'>" + value.name + "</td>" +
                         "<td class='column-title'>" + value.category + "</td></tr>"
                );
            });
        }
    });
}


