<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="page-title">
            <div class="title_left">
                <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                <h3><?php echo $announcements_lang['announcement'] ?>  <small><?php echo anchor('admin/announcements/add', $announcements_lang['create_announce'], "class='btn btn-primary'"); ?></small></h3>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $announcements_lang['inbox'] ?></h2>
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-5 mail_list_column">
                            <?php
                                foreach ($announcements as $announcement_item)
                                {
                                    $type_message = '';
                                    $image_type_message = '';
                                    if ($announcement_item->user == 'all')
                                    {
                                        $type_message = $announcements_lang['all_users'];
                                    }
                                    elseif (is_numeric($announcement_item->user))
                                    {
                                        $type_message = $announcements_lang['user'];
                                    }
                                    elseif (!is_null($announcement_item->shift))
                                    {
                                        $type_message = $announcements_lang['shift'];
                                    }
                                    elseif (!is_null($announcement_item->table))
                                    {
                                        $type_message = $announcements_lang['table'];
                                    }
                            ?>
                                    <div onclick="false;" id="announcement_item_<?php echo $announcement_item->id ?>" class="announcement_item well profile_view" data-path="<?php echo base_url('admin/announcements/get_detail_announcement/'.$announcement_item->id) ?>">
                                        <div class="col-sm-12">
                                            <h4 class="brief"><i><?php echo $announcements_lang['to'].": ".$type_message ?></i></h4>
                                            <div class="left col-xs-9">
                                                <h2 class="title-announcement" data-title="<?php echo htmlentities($announcement_item->title) ?>"> <?php echo substr($announcement_item->title, 0,30) ?></h2>
                                                 <input type="hidden" class="announcement_id" value="<?php echo $announcement_item->id ?>">
                                                <p class="content-announcement" data-content="<?php echo htmlentities($announcement_item->content) ?>"><?php echo substr($announcement_item->content, 0,50) ?></p>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <strong><?php echo $announcements_lang['lunch_date'] ?> :</strong><?php echo $announcement_item->meal_date ?>
                                                    </li>
                                                    <li>
                                                        <strong><?php echo $announcements_lang['reply'] ?></strong> <span class="num_replies"><?php echo (($announcement_item->number_of_replies > 0 ) ? $announcement_item->number_of_replies : 0) ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right col-xs-3 text-center"></div>
                                        </div>
                                    </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-xs-12 text-center"><?php echo $pagination; ?></div>
                            </div>
                        </div>
                        <!-- /MAIL LIST -->
                        <!-- CONTENT MAIL -->
                        <div id="content_view" class="col-xs-12 col-sm-7 mail_view">
                            <div class="inbox-body">
                                <div class="mail_heading row">
                                    <div class="col-xs-12 announcement-detail"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="all-comment col-xs-12">
                                <ul class="list-unstyled msg_list"></ul>
                            </div>
                        </div>
                    </div>
                        <!-- /CONTENT MAIL -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add_reply_announcement_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $announcements_lang['announcement'] ?>
                </h4>
            </div>
            <div class="modal-body add_reply">
                <?php echo form_open('admin/categories/add'); ?>
                    <h2><?php echo $announcements_lang['reply'] ?></h2>
                    <div class="form-group">
                        <label for="inputDescription"><?php echo $announcements_lang['content'] ?></label>
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
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $announcements_lang['cancel'] ?></button>
                <button type="button" id="add_reply_announcement" class="btn btn-primary" data-path="<?php echo base_url('admin/announcements/add_reply') ?>"><?php echo $announcements_lang['send'] ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete_announcement_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $announcements_lang['delete'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $announcements_lang[ 'are_you_sure'] ?>
                <input type="hidden" name='announcement_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $announcements_lang[ 'cancel'] ?>
                </button>
                <button type="button" id='delete_announcement' data-dismiss="modal" data-path="<?php echo base_url().'admin/announcements/delete/'; ?>" class="btn btn-primary">
                <?php echo $announcements_lang[ 'yes'] ?>
                </button>
            </div>
        </div>
    </div>
</div>