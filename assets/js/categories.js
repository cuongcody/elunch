$(function() {
    $('#delete_category_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var category_id = $(e.relatedTarget).data('category-id');
            $(e.currentTarget).find('input[name="category_id"]').val(category_id);
        });

    $('#delete_category').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var category_id = $('input[name="category_id"]').val();
        base_url = $('#delete_category').data("path");
        jQuery.ajax({
            type: "POST",
            url: base_url + category_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#category_' + category_id).hide('slow', function() {
                            toastr.success(res.message);
                            $('#category_' + category_id).remove();
                         });
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });
    $(".up").click(function(event) {
        $(this).parent().parent().each(function(index, el) {
            if (!$(this).text().match(/^\s*$/)) {
                if(parseInt($(this).find('.index').text()) > 1)
                {
                    $(this).find('.index').text(parseInt($(this).find('.index').text()) - 1);
                    $(this).prev().find('.index').text(parseInt($(this).prev().find('.index').text()) + 1);
                }
                $(this).insertBefore($(this).prev());

            }
        });
    });

    $(".down").click(function(event) {
        $(this).parent().parent().each(function(index, el) {
            if (!$(this).text().match(/^\s*$/)) {
                if (parseInt($(this).next().find('.index').text()) > 1) {
                    $(this).find('.index').text(parseInt($(this).find('.index').text()) + 1);
                    $(this).next().find('.index').text(parseInt($(this).next().find('.index').text()) - 1);
                }
                $(this).insertAfter($(this).next()).fadeIn("slow");
            }
        });
    });
    $("#sort_cats").click(function(event) {
        $(".se-pre-con").fadeIn('slow');
        base_url = $(this).data('path');
        cats = new Array;
        $("tbody").find("tr").each(function(index, el) {
            cat = {
                id : $(this).data('id'),
                order : $(this).find('.index').text()
            }
            cats.push(cat);
        });
        jQuery.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {cats:cats},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        toastr.success(res.message);
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });
});