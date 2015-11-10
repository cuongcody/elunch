<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-xs-12 col-md-offset-2 col-md-8'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/shifts/add'); ?>
                    <h2><?php echo $new_shift_lang['title'] ?></h2>
                    <div class="form-group">
                        <label for="inputshift"><?php echo $new_shift_lang['shift'] ?> </label>
                        <?php
                            $data = array(
                            'name' => 'shift',
                            'class' => 'form-control',
                            'placeholder' => $new_shift_lang['shift']);
                            echo form_input($data, set_value('shift', ''));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription"><?php echo $new_shift_lang['description'] ?></label>
                        <?php
                            $data = array(
                              'name' => 'description',
                              'rows' => '5',
                              'cols' => '10',
                              'class' => 'form-control'
                            );
                            echo form_textarea($data, set_value('description',''));
                        ?>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="inputDescription"><?php echo $new_shift_lang['start_time'] ?></label>
                        <div class="input-group date datetimepicker-1">
                            <?php
                                $data = array(
                                    'name' => 'start_time',
                                    'class' => 'form-control',
                                    'placeholder' => $new_shift_lang['start_time']);
                                echo form_input($data, set_value('start_time', ''));
                            ?>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </div>
                    <div class="form-group col-xs-12  col-md-6">
                        <label for="inputDescription"><?php echo $new_shift_lang['end_time'] ?></label>
                        <div class="input-group date datetimepicker-1">
                        <?php
                            $data = array(
                                'name' => 'end_time',
                                'class' => 'form-control',
                                'placeholder' => $new_shift_lang['end_time']);
                            echo form_input($data, set_value('end_time', ''));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <?php echo form_submit('submit', $new_shift_lang['save'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->