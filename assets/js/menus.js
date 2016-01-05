$(function() {
    $('#category').on('change', function() {
        $('.dishes_item').empty();
        category_id = $(this).val();
        base_url = $(this).data("path");
        getDishesByCategoryAjax(category_id, base_url);
    });

    $('#delete_menu_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var menu_id = $(e.relatedTarget).data('menu-id');
            $(e.currentTarget).find('input[name="menu_id"]').val(menu_id);
        });

    $('#delete_menu').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var menu_id  = $('input[name="menu_id"]').val();
        base_url = $('#delete_menu').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + menu_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#menu_' + menu_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#menu_' + menu_id).remove();
                         });
                    }
                    else {toastr.error(res.message);}
                });
            }
        })
    });

    $('#list_dishes_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var base_url = $(e.relatedTarget).data('path');
            getDishesByMenuAjax(base_url);
    });
});
$(function (){
    category_id = $('#category').val();
    base_url = $('#category').data("path");
    if(category_id != undefined) getDishesByCategoryAjax(category_id, base_url);
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

function getDishesByCategoryAjax(category_id, base_url)
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
            selectedDish();
            removeDish();
        }
    });
}


function selectedDish() {
    $('.dish_item').hover(function(){
        dish_name_select = $(this).text();
        dish_id_select = $(this).find('td').attr('value');
        $(this).find('td').append('<a id="insert" onclick="setDishForMenu(dish_id_select, dish_name_select)" class="badge bg-green"><i class="fa fa-check"></i></a>');
    }, function () {
        $("#insert").remove();
    });
}

function removeDish() {
    $('.dish_item_of_menu').hover(function(){
        dish_item = $(this);
        $(this).find('td').append('<a id="remove" onclick="removeDishForMenu(dish_item)" class="badge bg-red"><i class="fa fa-times"></i></a>');

    }, function () {
        $("#remove").remove();
    });
}

function setDishForMenu(dish_id_select, dish_name_select) {
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
        removeDish();
    }
}

function removeDishForMenu(dish_item) {
    dish_id_item = dish_item.find('td').attr('value');
    $('input[name="dishes_of_menu[]"]').each(function() {
        if ($(this).val() === dish_id_item) {
            $(this).remove();
            $(this).next().remove();
        }
    });
    $(dish_item).remove();
}