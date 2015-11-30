
<div class="right_col" role="main">
    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
    <div class="row">
        <div class= 'col-xs-12'>
            <div class="x_panel">
                <div class="x_content">
                    <!-- Introduction Row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-header"><?php echo $join_table_lang['join_table'] ?></h1>
                            <div class="choose_day">
                                <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                                <?php echo form_open_multipart( 'admin/home/tracking'); ?>
                                    <div class="form-group col-xs-6">
                                        <label><?php echo $join_table_lang['shift'] ?></label>
                                        <?php
                                            $options=array();
                                            if (!empty($shift))
                                            {
                                                $options[$shift->id] = $shift->name;
                                                $select_shift = $this->input->post('shift');
                                                echo form_dropdown('shift', $options, set_value('shift', ''), 'data-path="'.base_url('web_portal/select_table/get_tables_from_shift').'" id="shift" class= "form-control"');
                                            }
                                            else
                                            {
                                                echo form_dropdown('shift', $options, set_value('shift', ''), 'class= "form-control"');
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label><?php echo $join_table_lang['day'] ?></label>
                                        <?php
                                            if ($user['want_vegan_meal'])
                                            {
                                                $options = array(
                                                    NORMAL_DAY => $join_table_lang['normal_day'],
                                                    VEGAN_DAY => $join_table_lang['vegan_day']);
                                            }
                                            else
                                            {
                                                $options = array(
                                                    NORMAL_DAY => $join_table_lang['normal_day']);
                                            }
                                            $select_day = $this->input->post('day');
                                            echo form_dropdown('day', $options, set_value('day',( !empty($select_day) ) ? "$select_day" : 0),'data-path="'.base_url('web_portal/select_table/list_status_of_users_from_tables').'" id="shift" class= "form-control"');
                                        ?>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div>
                                <input type="hidden" name="user" value="<?php echo $user['user_id'] ?>" data-path-join="<?php echo base_url('web_portal/select_table/join_table') ?>" data-path-leave="<?php echo base_url('web_portal/select_table/leave_table') ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h2 class="page-header">
                                <?php echo $join_table_lang['list_tables'] ?>
                                <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                            </h2>
                            <div class='row'>
                                <div class='col-xs-12 btn-tables'>
                                </div>
                            </div>
                        </div>
                        <div class="row all-tables">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

