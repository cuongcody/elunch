function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function announce_message(res)
{
    data = $.parseJSON(res);
    if(data.status == 'success') toastr.success(data.message);
    else toastr.error(data.message);
}

$(function() {
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        startDate: '-3d'
    });
});

$(function() {
    $('#category').on('change', function() {
        $('.dishes_item').empty();
        category = $(this).val();
        base_url = $(this).data("path");
        get_dishes_by_category_ajax(category, base_url);
    });
});
$(function() {
    category = $('#category').val();
    base_url = $('#category').data("path");
    if(base_url != null ) get_dishes_by_category_ajax(category, base_url);
});

function get_users_by_table_ajax(base_url)
{
    $.ajax({
        type:"POST",
        url: base_url,
        data: {},
        dataType: 'json',
        success: function(res){
            $('.users_item').empty();
            $.each(res, function(index, value){
                $('.users_item').append(
                    "<tr class='heading'><td class='column-title'></td>" +
                         "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='" + value.avatar_content_file + "'alt=''></td>" +
                         "<td class='column-title'>" + value.first_name + "</td>" +
                         "<td class='column-title'>" + value.floor + "</td></tr>"
                );
            });
        }
    });
}

function get_dishes_by_category_ajax(category_id, base_url)
{
    $.ajax({
        type:"POST",
        url: base_url + "/" + category_id,
        data: {},
        dataType: 'json',
        success: function(res){
            $.each(res, function(index, value){
                $('.dishes_item').append(
                    "<tr id='dish_item_" + value.id + "' class='dish_item'><td value='" + value.id + "' class=''>" + value.name + "</td></tr>"
                );
            });
            selected_dish();
            remove_dish();
        }
    });
}

function get_dishes_by_menu_ajax(base_url)
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
function selected_dish() {
    $('.dish_item').hover(function(){
        dish_name_select = $(this).text();
        dish_id_select = $(this).find('td').attr('value');
        $(this).find('td').append('<a id="insert" onclick="set_dish_for_menu(dish_id_select, dish_name_select)" class="badge bg-green"><i class="fa fa-check"></i></a>');
    }, function () {
        $("#insert").remove();
    });
}

function remove_dish() {
    $('.dish_item_of_menu').hover(function(){
        dish_item = $(this);
        $(this).find('td').append('<a id="remove" onclick="remove_dish_for_menu(dish_item)" class="badge bg-red"><i class="fa fa-times"></i></a>');

    }, function () {
        $("#remove").remove();
    });
}

function set_dish_for_menu(dish_id_select, dish_name_select) {
    is_exist_dish_in_menu = false;
    if ($('.dish_item_of_menu').find('td').text().length != 0){
        $('.dish_item_of_menu').find('td').each(function() {
            if ($(this).text() === dish_name_select)
            {
                is_exist_dish_in_menu = true;
            }
        });
    }
    if (is_exist_dish_in_menu == false)
    {
        $('.dishes_item_of_menu').append(
            "<tr id='dish_item_of_menu_" + dish_id_select + "' class='dish_item_of_menu'><td value='" + dish_id_select + "'>" + dish_name_select + "</td></tr>"
        );
        $('.dishes_item_of_menu').append(
            "<input type='hidden' name='dishes_of_menu[]' value='" + dish_id_select + "'>" +
            "<input type='hidden' name='name_dishes[]' value='" + dish_name_select + "'>"
        );
        remove_dish();
    }
}

function remove_dish_for_menu(dish_item) {
    dish_id_item = dish_item.find('td').attr('value');
    $('input[name="dishes_of_menu[]"]').each(function() {
        if ($(this).val() === dish_id_item) {
            $(this).remove();
            $(this).next().remove();
        }
    });
    $(dish_item).remove();
}
$(function() {
    $('#change_password').click(function() {
        base_url = $('#change_password').data("path");
        var password = $("input[name=password]").val();
        var confirm_password = $("input[name=confirm_password]").val();
        $.ajax({
            type:"POST",
            url: base_url,
            data: {password: password, confirm_password: confirm_password},
            dataType: 'json',
            success: function(res){
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
});

$(function() {
    $('#list_dishes_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var base_url = $(e.relatedTarget).data('path');
            get_dishes_by_menu_ajax(base_url);
        });
});

$(function() {
    $('#list_tables_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var base_url = $(e.relatedTarget).data('path');
            get_users_by_table_ajax(base_url);
        });
});

$(function() {
    $('#detail_text_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var title = $(e.relatedTarget).data('title');
            var content = $(e.relatedTarget).data('content');
            $('#detail_text_modal').find('.modal-title').text(title);
            $('#detail_text_modal').find('.detail_text').text(content);
        });
});

$(function() {
    $('#delete_menu_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var menu_id = $(e.relatedTarget).data('menu-id');
            $(e.currentTarget).find('input[name="menu_id"]').val(menu_id);
        });

    $('#delete_menu').click(function() {
        var menu_id  = $('input[name="menu_id"]').val();
        base_url = $('#delete_menu').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + menu_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#menu_' + menu_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#menu_' + menu_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });
});

$(function() {
    $('#delete_user_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var user_id = $(e.relatedTarget).data('user-id');
            $(e.currentTarget).find('input[name="user_id"]').val(user_id);
        });

    $('#delete_user').click(function() {
        var user_id = $('input[name="user_id"]').val();
        base_url = $('#delete_user').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + user_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#user_' + user_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#user_' + user_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });
});

$(function() {
    $('#delete_category_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var category_id = $(e.relatedTarget).data('category-id');
            $(e.currentTarget).find('input[name="category_id"]').val(category_id);
        });

    $('#delete_category').click(function() {
        var category_id = $('input[name="category_id"]').val();
        base_url = $('#delete_category').data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + category_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#category_' + category_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#category_' + category_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        });
    });
});

$(function() {
    $('#delete_dish_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var dish_id = $(e.relatedTarget).data('dish-id');
            $(e.currentTarget).find('input[name="dish_id"]').val(dish_id);
        });

    $('#delete_dish').click(function() {
        var dish_id = $('input[name="dish_id"]').val();
        base_url = $('#delete_dish').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + dish_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#dish_' + dish_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#dish_' + dish_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });
});

$(function() {
    $('#delete_table_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var table_id = $(e.relatedTarget).data('table-id');
            $(e.currentTarget).find('input[name="table_id"]').val(table_id);
        });

    $('#delete_table').click(function() {
        var table_id = $('input[name="table_id"]').val();
        base_url = $('#delete_table').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + table_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#table_' + table_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#table_' + table_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });
});

$(function() {
    $('#delete_user_in_table_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var user_id = $(e.relatedTarget).data('user-id');
            $(e.currentTarget).find('input[name="user_id"]').val(user_id);
        });

    $('#delete_user_in_table').click(function() {
        var user_id = $('input[name="user_id"]').val();
        base_url = $('#delete_user_in_table').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + user_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#user_' + user_id).hide('slow', function() {
                        toastr.success(res.message);
                        $('#user_' + user_id).remove();
                     });
                }
                else {toastr.error(res.message);}
            }
        })
    });
});
