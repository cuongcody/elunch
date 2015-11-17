<!-- page content -->
<div class="right_col" role="main">
    <div class='row'>
        <div class='col-xs-12'>
            <div class="page-title">
                <div class="title_left">
                    <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                    <h3><?php echo $comments_lang['comments'] ?></h3>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $comments_lang['inbox'] ?></h2>
                        <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 mail_list_column">
                                <?php
                                    foreach ($comments as $key => $comment_item)
                                    {
                                        echo "<div onclick='false;' id='comment_item_".$comment_item->id."' class='comment_item well profile_view' data-path='".base_url('admin/comments/get_detail_comment/'.$comment_item->id)."'>";
                                        echo "<div class='col-sm-12'>";
                                        echo "<h4 class='brief'><i>".$comments_lang['from'].": ".$comment_item->email."</i></h4>";
                                        echo "<div class='left col-xs-9'>";
                                        echo "<h2 class='title-comment' data-title='{html_entity_encode($comment_item->title)}'>".substr($comment_item->title, 0, 30)."</h2>";
                                        echo "<input type='hidden' class='comment_id' value='".$comment_item->id."'>";
                                        echo "<input type='hidden' class='comment_dish_img' value='".$comment_item->image."'>";
                                        echo "<p class='content-comment' data-content='{$comment_item->content}'>".substr($comment_item->content, 0,50)."</p>";
                                        echo "<ul class='list-unstyled'>";
                                        echo "<li><strong>".$comments_lang['lunch_date'].":</strong> ".$comment_item->meal_date." </li>";
                                        echo "<li><strong>".$comments_lang['reply'].":</strong> <span class='num_replies'>".(($comment_item->number_of_replies > 0 ) ? $comment_item->number_of_replies : 0)."</span></li>";
                                        echo "</ul></div>";
                                        echo "<div class='right col-xs-3 text-center'>";
                                        echo "<img src='".$comment_item->avatar_content_file."' width='80' height='80' alt='' class='img-circle img-responsive'>";
                                        echo "</div></div></div>";
                                    }
                                ?>
                                <div class="row">
                                    <div class="col-xs-12 text-center"><?php echo $pagination; ?></div>
                                </div>
                            </div>
                            <div id="content_view" class="col-xs-12 col-sm-7 mail_view">
                                <div class='row'>
                                    <div class="col-xs-12 comment-detail"></div>
                                    <div class="col-xs-12 all-comment">
                                        <ul class="list-unstyled msg_list"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add_reply_comment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $comments_lang['comments'] ?>
                </h4>
            </div>
            <div class="modal-body add_reply">
                <?php echo form_open('admin/categories/add'); ?>
                    <h2><?php echo $comments_lang['reply'] ?></h2>
                    <div class="form-group">
                        <label for="inputDescription"><?php echo $comments_lang['content'] ?></label>
                        <?php
                            $data = array(
                              'name' => 'content',
                              'rows' => '5',
                              'cols' => '10',
                              'class' => 'form-control txt-content'
                            );
                            echo form_textarea($data, set_value('content',''));
                        ?>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $comments_lang['cancel'] ?></button>
                <button type="button" id="add_reply_comment" class="btn btn-primary" data-path="<?php echo base_url('admin/comments/add_reply') ?>"><?php echo $comments_lang['send'] ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete_comment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $comments_lang['delete'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $comments_lang[ 'are_you_sure'] ?>
                <input type="hidden" name='comment_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $comments_lang[ 'cancel'] ?>
                </button>
                <button type="button" id='delete_comment' data-dismiss="modal" data-path="<?php echo base_url().'admin/comments/delete/'; ?>" class="btn btn-primary">
                <?php echo $comments_lang[ 'yes'] ?>
                </button>
            </div>
        </div>
    </div>
</div>