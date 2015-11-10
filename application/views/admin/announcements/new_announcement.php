<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <h2><?php echo $new_announcement_lang['title'] ?></h2>
                    <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                    <?php echo form_open('admin/announcements/add'); ?>
                    <div class="form-group">
                        <label><?php echo $new_announcement_lang['subject'] ?></label>
                        <?php
                            $data = array(
                                'name' => 'subject',
                                'class' => 'form-control',
                                'placeholder' => $new_announcement_lang['subject']);
                            echo form_input($data, set_value('subject', ''));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $new_announcement_lang['content'] ?></label>
                        <?php
                            $data = array(
                              'name' => 'content',
                              'rows' => '5',
                              'cols' => '10',
                              'class' => 'form-control'
                            );
                            echo form_textarea($data, set_value('content',''));
                        ?>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label><?php echo $new_announcement_lang['lunch_date'] ?></label>
                        <div class="input-group date datetimepicker">
                            <?php
                                $data = array(
                                    'name' => 'lunch_date',
                                    'class' => 'form-control',
                                    'placeholder' => $new_announcement_lang['lunch_date']);
                                echo form_input($data, set_value('lunch_date', ''));
                            ?>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label><?php echo $new_announcement_lang[ 'announcement_for'];?>: </label>
                        <?php
                            $options = array();
                            if (!empty($choose))
                            {
                                foreach ($choose as $temp)
                                { $options[$temp] = $temp; }
                                $select_announcement_for = $this->input->post('announcement_for');
                                echo form_dropdown('announcement_for', $options, set_value('announcement_for', (!empty($select_announcement_for) ) ? "$select_announcement_for" : $choose[0]), 'class= "form-control" id="announcement-for"');
                            }
                            else
                            {
                                echo form_dropdown('announcement_for', $options, set_value('announcement_for', ''), 'class= "form-control" id="announcement-for"');
                            }
                        ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 user-choose hidden">
                        <label><?php echo $new_announcement_lang[ 'user'];?>: </label>
                        <?php
                            $options = array();
                            if (!empty($users))
                            {
                                foreach ($users as $temp)
                                { $options[$temp->id] = $temp->first_name; }
                                $select_user = $this->input->post('user');
                                echo form_dropdown('user', $options, set_value('user', (!empty($select_user) ) ? "$select_user" : $users[0]->id), 'class= "form-control"');
                            }
                            else
                            {
                                echo form_dropdown('user', $options, set_value('user', ''), 'class= "form-control"');
                            }
                        ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 table-choose hidden">
                        <label><?php echo $new_announcement_lang[ 'table'];?>: </label>
                        <?php
                            $options = array();
                            if (!empty($tables))
                            {
                                foreach ($tables as $temp)
                                { $options[$temp->id] = $temp->name; }
                                $select_table = $this->input->post('table');
                                echo form_dropdown('table', $options, set_value('table', (!empty($select_table) ) ? "$select_table" : $tables[0]->id), 'class= "form-control"');
                            }
                            else
                            {
                                echo form_dropdown('table', $options, set_value('table', ''), 'class= "form-control"');
                            }
                        ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 shift-choose hidden">
                        <label><?php echo $new_announcement_lang[ 'shift'];?>: </label>
                        <?php
                            $options = array();
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
                    <div class="clearfix"></div>
                    <div class="form-group text-center">
                        <?php echo form_submit('submit', $new_announcement_lang[ 'send'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->