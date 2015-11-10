$(function() {
    $('.announcement_item').click(function() {
        $(".announcement-detail").empty();
        base_url = $(this).data('path');
        announcement_id = $(this).find('.announcement_id').val();
        title = $(this).find('.title-announcement').data('title');
        content = $(this).find('.content-announcement').data('content');
        $('.announcement_item').removeClass('bg-blue');
        $('#announcement_item_' + announcement_id).addClass('bg-blue');
        $(".announcement-detail").append(
            "<div class='panel panel-default'>" +
            "<div class='panel-heading'>" +
            "<h4 class='title'>" + title + "</h4></div>" +
            "<div class='panel-body'>" +
            "<input type='hidden' name='announcement_id_choose' value='" + announcement_id + "'>" +
            "<p class='content'>" + content + "</p>" +
            "<div class='text-right'><a class='btn btn-sm btn-primary btn-add-reply' href='#add_reply_announcement_modal' data-toggle='modal' data-target='#add_reply_announcement_modal'><i class='fa fa-reply'></i></a>" +
            "<a href='#delete_announcement_modal' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#delete_announcement_modal' data-announcement-id='" + announcement_id + "' onclick='false;'><i class='fa fa-remove'></i></a></div>" +
            "</div></div>");
        getReplyAnnouncementAjax(base_url);
    });

    $('#add_reply_announcement_modal').on('show.bs.modal', function(e) {
        $('.error').remove();
        $('.txt-content').val('');
    });

    $('#add_reply_announcement').click(function() {
        announcement_id = $('input[name="announcement_id_choose"]').val();
        if (announcement_id != null){
            base_url = $('#add_reply_announcement').data("path") + '/' + announcement_id;
            content = $(".txt-content").val();
            $.ajax({
                type:"POST",
                url: base_url,
                data: {content: content},
                dataType: 'json',
                success: function(res){
                    $('.error').remove();
                    if (res.status == 'errors')
                    {
                        $('div.add_reply').prepend(
                            "<div class='error alert alert-warning'>" + res.message + '</div>');
                    }
                    else if (res.status == 'success')
                    {
                        $('#add_reply_announcement_modal').modal('toggle');
                        toastr.success(res.message);
                        $('.msg_list').prepend(
                        "<li><a><span class='image'>" +
                        "<img class='img-thumbnail' src='" + res.avatar_content_file + "' alt=''></span>" +
                        "<span><span>" + res.email + "</span></span>" +
                        "<span class='message'>" + res.content + "</span>" +
                        "<span class='time'>" + res.created_at + "</span></a>"
                        ).show('slow');
                        new_num_replies = parseInt($("#announcement_item_" + announcement_id).find('.num_replies').text()) + 1;

                        $("#announcement_item_" + announcement_id).find('.num_replies').text(new_num_replies);
                    }
                    else if (res.status == 'failure')
                    {
                        toastr.error(res.message);
                    }
                }
            });
        }
        else $('#add_reply_announcement_modal').modal('toggle');
    });

    $('#announcement-for').on('change', function() {
        choose = $(this).val();
        switch(choose) {
            case 'User':
                $('.user-choose').removeClass('hidden');
                $('.table-choose').addClass('hidden');
                $('.shift-choose').addClass('hidden');
                break;
            case 'Table':
                $('.table-choose').removeClass('hidden');
                $('.user-choose').addClass('hidden');
                $('.shift-choose').addClass('hidden');
                break;
            case 'Shift':
                $('.shift-choose').removeClass('hidden');
                $('.table-choose').addClass('hidden');
                $('.user-choose').addClass('hidden');
                break;
            default:
                $('.user-choose').addClass('hidden');
                $('.table-choose').addClass('hidden');
                $('.shift-choose').addClass('hidden');
        }
    });

    $('#delete_announcement_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var announcement_id = $(e.relatedTarget).data('announcement-id');
            $(e.currentTarget).find('input[name="announcement_id"]').val(announcement_id);
        });

    $('#delete_announcement').click(function() {
        var announcement_id = $('input[name="announcement_id"]').val();
        base_url = $('#delete_announcement').data("path");
        jQuery.ajax({
            type: "POST",
            url:  base_url + announcement_id,
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.status == 'success')
                {
                    $('#announcement_item_' + announcement_id).hide('slow', function() {
                        $(".announcement-detail").hide('slow', function() {
                            $(".all-comment").hide('slow', function() {
                                toastr.success(res.message);
                                $(".announcement-detail").replaceWith('<div class="col-xs-12 announcement-detail"></div>');
                                $(".all-comment").replaceWith('<div class="col-xs-12 all-comment"><ul class="list-unstyled msg_list"></ul></div>');
                                $('#announcement_item_' + announcement_id).remove();
                            });
                        });
                     });
                }
                else {toastr.error(res.message);}
            }
        });
    });
});

function getReplyAnnouncementAjax(base_url)
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
            $('input[name=announcement_id_choose]').val(announcement_id);
            $.each(res.replies, function(index, value){
                $('.msg_list').append(
                    "<li><a><span class='image'>" +
                    "<img class='img-thumbnail' src='" + value.avatar_content_file + "' alt=''></span>" +
                    "<span><span>" + value.email + "</span></span>" +
                    "<span class='message'>" + value.content + "</span>" +
                    "<span class='time'>" + value.created_at + "</span></a>"
                    );
            });
            $("#announcement_item_" + announcement_id).find('.num_replies').text(res.replies.length);
        }
    });
}
