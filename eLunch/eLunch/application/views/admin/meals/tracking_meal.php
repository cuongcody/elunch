<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="x_panel">
                <div class="x_content">
                    <!-- Introduction Row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-header"><?php echo $home_lang['title'] ?></h1>
                            <div class="choose_day">
                                <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                                <?php echo form_open_multipart( 'admin/meals/tracking'); ?>
                                    <input type="hidden" id="meal" name='day' data-path="<?php echo base_url('admin/meals/list_status_of_users_from_tables') ?>" value="<?php echo $day; ?>">
                                    <input type="hidden" data-end-time=<?php echo $end_time ?> data-start-time=<?php echo $start_time ?> data-name='<?php echo $shift_name ?>' name='shift' value="<?php echo $shift_id ?>">
                                    <div class="form-group col-xs-6 col-sm-6 col-md-5">
                                        <?php
                                            $options=array();
                                            if (!empty($shifts))
                                            {
                                                foreach ($shifts as $temp)
                                                { $options[$temp->id] = $temp->name; }
                                                $select_shift = $this->input->post('shift');
                                                echo form_dropdown('shift', $options, set_value('shift', (!empty($select_shift) ) ? "$select_shift" : $shifts[0]->id), 'class= "form-control"');
                                            }
                                            else
                                            {
                                                echo form_dropdown('shift', $options, set_value('shift', ''), 'class= "form-control"');
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group col-xs-6 col-sm-6 col-md-5">
                                        <?php
                                            $options=array(
                                                NORMAL_DAY => $home_lang['normal_day'],
                                                VEGAN_DAY => $home_lang['vegan_day']);
                                            $select_day = $this->input->post('day');
                                            echo form_dropdown('day', $options, set_value('day',( !empty($select_day) ) ? "$select_day" : 0),'class= "form-control"');
                                        ?>
                                    </div>
                                    <div class="form-group col-xs-2 col-sm-2 col-md-2">
                                        <?php echo form_submit( 'submit', $home_lang['search'], 'class = "btn btn-primary"'); ?>
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
                                <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                            </h2>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <?php
                                        foreach ($tables as $table)
                                        {
                                            echo '<a class="btn '.(($table->for_vegans == FOR_VEGANS) ? 'btn-table-vegan' : 'btn-table-normal').'" href="#table_'.$table->id.'">'.$table->name.'</a>';
                                        }
                                    ?>
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
                        <div class="row">
                        <?php
                            if (!empty($tables))
                            {
                                foreach ($tables as $key => $table)
                                {
                                    echo '<div id="table_'.$table->id.'" class="col-xs-offset-1 col-xs-8 col-xs-offset-1 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-md-offset-3 col-md-6 col-md-offset-3 col-lg-offset-3 col-lg-6 col-lg-offset-3 tables">';
                                    echo '<div class="table text-center circle big '.(($table->for_vegans == FOR_VEGANS) ? 'bg-green' : '').'">';
                                    echo '<input type="hidden" data-name="'.$table->name.'" name="table_id" value="'.$table->id.'">';
                                    echo '<h4 class="table-name text-center">'.$table->name.'</h4></div></div></hr>';
                                }
                            }
                        ?>
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
                <div class='form-group'>
                    <textarea class='form-control' id='note' cols=10 rows=5 placeholder='<?php echo $home_lang['note'] ?>'></textarea>
                </div>
                <div class='form-group'>
                    <input type='number' class='form-control' name='actual_meals' min="1" placeholder="<?php echo $home_lang['actual_meals'] ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $home_lang['cancel'] ?></button>
                <button type="button" id='tracking_meal_log' data-path="<?php echo base_url().'admin/meals/tracking_meal_log/'; ?>" class="btn btn-primary"><?php echo $home_lang['yes'] ?></button>
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
                <input type='hidden' name="user_id" value="" data-path="<?php echo base_url('admin/meals/update_status_of_user_from_table') ?>"/>
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