

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function announcementMessage(res)
{
    data = $.parseJSON(res);
    if(data.status == 'success') toastr.success(data.message);
    else toastr.error(data.message);
}

$(function() {
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('.datetimepicker-1').datetimepicker({
       format: 'LT'
    });

    $('#detail_text_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var title = $(e.relatedTarget).data('title');
            var content = $(e.relatedTarget).data('content');
            $('#detail_text_modal').find('.modal-title').text(title);
            $('#detail_text_modal').find('.detail_text').text(content);
    });
});

$(function() {
    $(window).scroll(function(){
        var scrolltop = $(this).scrollTop();
        if (scrolltop >= 200){
            $("#elevator_item").show();
        }else {
            $("#elevator_item").hide();
        }
    });
    $("#elevator").click(function(){
        $("html,body").animate({scrollTop: 0}, 500);
    });

    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });

    $('input[name="submit"]').click(function(event) {
        $(".se-pre-con").fadeIn('slow');
    });
    $(".btn-loading").click(function(event) {
        $(".se-pre-con").fadeIn('slow');
    });
});
