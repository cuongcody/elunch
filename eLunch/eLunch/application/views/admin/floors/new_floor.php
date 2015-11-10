<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-2 col-md-8'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/floors/add'); ?>
                    <h2><?php echo $new_floor_lang['title'] ?></h2>
                    <div class="form-group">
                        <label for="inputfloor"><?php echo $new_floor_lang['floor'] ?> </label>
                        <?php
                            $data = array(
                            'name' => 'floor',
                            'class' => 'form-control',
                            'placeholder' => $new_floor_lang['floor']);
                            echo form_input($data, set_value('floor', ''));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription"><?php echo $new_floor_lang['description'] ?></label>
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
                    <div class="form-group text-center">
                        <?php echo form_submit('submit', $new_floor_lang['save'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->