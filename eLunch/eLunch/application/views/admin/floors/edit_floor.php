<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-2 col-md-8'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <h2><?php echo $edit_floor_lang['title'] ?></h2>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/floors/edit/'.$floor->id); ?>
                        <div class="form-group">
                            <label for="inputfloor"><?php echo $edit_floor_lang['floor'] ?> </label>
                            <?php
                                $data = array(
                                  'name' => 'floor',
                                  'class' => 'form-control',
                                  'placeholder' => $edit_floor_lang['floor']);
                                echo form_input($data, set_value('floor', $floor->name));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription"><?php echo $edit_floor_lang['description'] ?></label>
                            <?php
                                $data = array(
                                  'name' => 'description',
                                  'rows' => '5',
                                  'cols' => '10',
                                  'class' => 'form-control'
                                );
                                echo form_textarea($data, set_value('description',$floor->description));
                            ?>
                        </div>
                        <div class="form-group text-center">
                            <?php echo form_submit('submit', $edit_floor_lang['edit'], 'class = "btn btn-primary"'); ?>
                            <a href="<?php echo base_url('admin/floors'); ?>" class='btn btn-info'><?php echo $edit_floor_lang['manage_floors'] ?></a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->