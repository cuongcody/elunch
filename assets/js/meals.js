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
        $(".se-pre-con").fadeIn('slow');
        var meal_id  = $('#delete_meal_modal input[name="meal_id"]').val();
        base_url = $('#delete_meal').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + meal_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#meal_' + meal_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#meal_' + meal_id).remove();
                        });
                    }
                    else {toastr.error(res.message);}
                });
            }
        })
    });

    $('.btn-meal-report').click(function() {
        $(".se-pre-con").fadeIn('slow');
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
        $(".se-pre-con").fadeIn('slow');
        var meal_id  = $('#gen_log_file_meal_modal input[name="meal_id"]').val();
        var meal_date  = $('#gen_log_file_meal_modal input[name="meal_date"]').val();
        base_url = $('#gen_log_file_meal').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + meal_date,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#meal_' + meal_id).find('.log_file').hide('slow', function() {
                            toastr.success(res.message);
                            $('#meal_' + meal_id).find('.log_file').remove();
                        });
                    }
                    else {toastr.error(res.message);}
                });

            }
        })
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


