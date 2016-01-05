$(function() {
    $('.comment_item').click(function() {
        $(".comment-detail").empty();
        base_url = $(this).data('path');
        comment_id = $(this).find('.comment_id').val();
        comment_dish_img = $(this).find('.comment_dish_img').val();
        comment_dish_img = (comment_dish_img.length != 0) ? "<p class='img'><img class='img-thumbnail' height='150' width='150' src='" + comment_dish_img + "'></p>" : '';
        title = $(this).find('.title-comment').data('title');
        content = $(this).find('.content-comment').data('content');
        $('.comment_item').removeClass('bg-blue');
        $('#comment_item_' + comment_id).addClass('bg-blue');
        $(".comment-detail").append(
            "<div class='panel panel-default'>" +
            "<div class='panel-heading'>" +
            "<h4 class='title'>" + title + "</h4></div>" +
            "<div class='panel-body'>" +
            "<input type='hidden' name='comment_id_choose' value='" + comment_id + "'>" +
             comment_dish_img +
            "<p class='content'>" + content + "</p>" +
            "<div class='text-right'><a class='btn btn-sm btn-primary btn-add-reply' href='#add_reply_comment_modal' data-toggle='modal' data-target='#add_reply_comment_modal'><i class='fa fa-reply'></i></a>" +
            "<a href='#delete_comment_modal' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#delete_comment_modal' data-comment-id='" + comment_id + "' onclick='false;'><i class='fa fa-remove'></i></a></div>" +
            "</div></div>");
        getReplyCommentAjax(base_url);
    });

    $('#add_reply_comment_modal').on('show.bs.modal', function(e) {
        $('.error').remove();
        $('.txt-content').val('');
    });

    $('#add_reply_comment').click(function() {
        $(".loadingx").fadeIn('slow');
        $(document).find('button').prop('disabled', true);
        comment_id = $('input[name="comment_id_choose"]').val();
        if (comment_id != null){
            base_url = $('#add_reply_comment').data("path") + '/' + comment_id;
            content = $(".txt-content").val();
            $.ajax({
                type:"POST",
                url: base_url,
                data: {content: content},
                dataType: 'json',
                success: function(res){
                    $(".loadingx").fadeOut('slow');
                    $(document).find('button').prop('disabled', false);
                    $('.error').remove();
                    if (res.status == 'errors')
                    {
                        $('div.add_reply').prepend(
                            "<div class='error alert alert-warning'>" + res.message + '</div>');
                    }
                    else if (res.status == 'success')
                    {
                        $('#add_reply_comment_modal').modal('toggle');
                        toastr.success(res.message);
                        $('.msg_list').prepend(
                        "<li><a><span class='image'>" +
                        "<img class='img-thumbnail' src='" + res.avatar_content_file + "' alt=''></span>" +
                        "<span><span>" + res.email + "</span></span>" +
                        "<span class='message'>" + res.content + "</span>" +
                        "<span class='time'>" + res.created_at + "</span></a>"
                        ).show('slow');
                        new_num_replies = parseInt($("#comment_item_" + comment_id).find('.num_replies').text()) + 1;

                        $("#comment_item_" + comment_id).find('.num_replies').text(new_num_replies);
                    }
                    else if (res.status == 'failure')
                    {
                        toastr.error(res.message);
                    }
                }
            });
        }
        else $('#add_reply_comment_modal').modal('toggle');
    });

    $('#delete_comment_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var comment_id = $(e.relatedTarget).data('comment-id');
            $(e.currentTarget).find('input[name="comment_id"]').val(comment_id);
        });

    $('#delete_comment').click(function() {
        $(".se-pre-con").fadeIn('slow');
        var comment_id = $('input[name="comment_id"]').val();
        base_url = $('#delete_comment').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + comment_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                $(".se-pre-con").fadeOut('slow', function() {
                    if (res.status == 'success')
                    {
                        $('#comment_item_' + comment_id).hide('slow', function() {
                            $(".comment-detail").hide('slow', function() {
                                $(".all-comment").hide('slow', function() {
                                    toastr.success(res.message);
                                    $(".comment-detail").replaceWith('<div class="col-xs-12 comment-detail"></div>');
                                    $(".all-comment").replaceWith('<div class="col-xs-12 all-comment"><ul class="list-unstyled msg_list"></ul></div>');
                                    $('#comment_item_' + comment_id).remove();
                                });
                            });
                         });
                    }
                    else {toastr.error(res.message);}
                });
            }
        });
    });
});

function getReplyCommentAjax(base_url)
{
    $('.msg_list').empty();
    $('.all-comment').removeClass('pre-scrollable');
    $.ajax({
        type:"POST",
        url: base_url,
        data: {},
        dataType: 'json',
        success: function(res){
            $('.all-comment').addClass('pre-scrollable');
            $('input[name=comment_id_choose]').val(comment_id);
            $.each(res.replies, function(index, value){
                $('.msg_list').append(
                    "<li><a><span class='image'>" +
                    "<img class='img-thumbnail' src='" + value.avatar_content_file + "' alt=''></span>" +
                    "<span><span>" + value.email + "</span></span>" +
                    "<span class='message'>" + value.content + "</span>" +
                    "<span class='time'>" + value.created_at + "</span></a>"

                    );
            });
            $("#comment_item_" + comment_id).find('.num_replies').text(res.replies.length);
        }
    });
}
