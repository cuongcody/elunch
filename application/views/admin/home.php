
<div class="right_col" role="main">
    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
    <div class="row">
        <div class= 'left-side col-xs-12 col-md-8'>
            <div class="x_panel">
                <div class="x_content">
                    <!-- Introduction Row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-header"><?php echo $home_lang['live_attendant_status'] ?></h1>
                            <div class="choose_day">
                                <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                                <?php echo form_open_multipart( 'admin/home/tracking'); ?>
                                    <div class="form-group col-xs-6">
                                        <?php
                                            $options=array();
                                            if (!empty($shifts))
                                            {
                                                foreach ($shifts as $temp)
                                                { $options[$temp->id] = $temp->name; }
                                                $select_shift = $this->input->post('shift');
                                                echo form_dropdown('shift', $options, set_value('shift', (!empty($select_shift) ) ? "$select_shift" : $shifts[0]->id), 'data-path="'.base_url('admin/home/get_tables_from_shift').'" id="shift" class= "form-control"');
                                            }
                                            else
                                            {
                                                echo form_dropdown('shift', $options, set_value('shift', ''), 'class= "form-control"');
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <?php
                                            $options=array(
                                                NORMAL_DAY => $home_lang['normal_day'],
                                                VEGAN_DAY => $home_lang['vegan_day']);
                                            $select_day = $this->input->post('day');
                                            echo form_dropdown('day', $options, set_value('day',( !empty($select_day) ) ? "$select_day" : 0),'data-path="'.base_url('admin/home/list_status_of_users_from_tables').'" id="shift" class= "form-control"');
                                        ?>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h2 class="page-header">
                                <?php echo $home_lang['list_tables'] ?>
                                <a class="btn btn-info btn-tracking" href="#tracking_meal_log_modal" data-toggle="modal" data-target="#tracking_meal_log_modal"><?php echo $home_lang['create_log'] ?></a>
                                <div class='form-group'>
                                    <textarea class='form-control' id='note' cols='1' rows='3' placeholder='<?php echo $home_lang['note'] ?>'></textarea>
                                </div>
                                <div class='form-group'>
                                    <textarea class='form-control' id='private_note' cols='1' rows='3' placeholder='<?php echo $home_lang['private_note'] ?>'></textarea>
                                </div>
                                <div class='form-group'>
                                    <input type='number' class='form-control' name='actual_meals' min="1" placeholder="<?php echo $home_lang['actual_meals'] ?>">
                                </div>
                                <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                            </h2>
                            <div class='row'>
                                <div class='col-xs-12 btn-tables'>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4><?php echo $home_lang['status'] ?></h4>
                            <div class='row'>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                    <div class='row'>
                                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                            <div class='progress_title'><?php echo $home_lang['attend'] ?></div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                                            <div class="progress right">
                                                <div class="progress-bar progress-bar-success" data-transitiongoal="100" aria-valuenow="100" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class='row'>
                                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 ">
                                            <div class='progress_title'><?php echo $home_lang['absent'] ?></div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-68 col-lg-8 ">
                                            <div class="progress right">
                                                <div class="progress-bar progress-bar-danger" data-transitiongoal="100" aria-valuenow="100" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class='row'>
                                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                            <div class='progress_title'><?php echo $home_lang['late'] ?></div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                                            <div class="progress right">
                                                <div class="progress-bar progress-bar-warning" data-transitiongoal="100" aria-valuenow="100" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row all-tables">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='right-side col-xs-12 col-md-4'>
            <div class="panel panel-default">
                <div class="panel-heading"> <span class="glyphicon glyphicon-list-alt"></span> <b><?php echo $home_lang['lastest_comments'] ?></b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <i class="fa fa-arrow-up" id="lastest-comments-prev"></i>
                            <ul id="lastest-comments" class="list-unstyled msg_list" data-path="<?php echo base_url('admin/comments/get_lastest_comments') ?>" data-comments-path="<?php echo base_url('admin/comments') ?>" data-replies-path="<?php echo base_url('admin/comments/get_detail_comment') ?>" data-add-reply-path="<?php echo base_url('admin/comments/add_reply') ?>" >
                            </ul>
                            <i class="fa fa-arrow-down" id="lastest-comments-next"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tracking_meal_log_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $home_lang['log'] ?></h4>
            </div>
            <div class="modal-body tracking-body">
                <div class="input-group date datetimepicker">
                    <input type="text" class='form-control' name='lunch_date' value="" placeholder="<?php echo $home_lang['lunch_date'] ?>">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $home_lang['cancel'] ?></button>
                <button type="button" id='tracking_meal_log' data-path="<?php echo base_url().'admin/home/tracking_meal_log/'; ?>" class="btn btn-primary"><?php echo $home_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="choose_status_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $home_lang['choose_status'] ?></h4>
            </div>
            <div class="modal-body">
                <input type='hidden' name="table_id" value=""/>
                <input type='hidden' name="user_id" value="" data-path="<?php echo base_url('admin/home/update_status_of_user_from_table') ?>"/>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="alert alert-success alert-dismissible fade in choose-status" role="alert" data-dismiss="modal">
                            <strong data-status='1'><?php echo $home_lang['attend'] ?></strong>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="alert alert-danger alert-dismissible fade in choose-status" role="alert" data-dismiss="modal">
                            <strong data-status='2'><?php echo $home_lang['absent'] ?></strong>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="alert alert-warning alert-dismissible fade in choose-status" role="alert" data-dismiss="modal">
                            <strong data-status='3'><?php echo $home_lang['late'] ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>