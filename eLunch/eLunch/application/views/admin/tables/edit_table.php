<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <h2><?php echo $edit_table_lang['title'] ?></h2>
                    <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                    <?php echo form_open('admin/tables/edit/'.$table->id); ?>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang['table'] ?></label>
                        <?php
                            $data = array(
                                'name' => 'table',
                                'class' => 'form-control',
                                'placeholder' => $edit_table_lang['table']);
                            echo form_input($data, set_value('table', $table->name));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang['description'] ?></label>
                        <?php
                            $data = array(
                              'name' => 'description',
                              'rows' => '5',
                              'cols' => '10',
                              'class' => 'form-control'
                            );
                            echo form_textarea($data, set_value('description', $table->description));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang['seats'] ?></label>
                        <?php
                            $data = array(
                                'type' => 'number',
                                'name' => 'seats',
                                'class' => 'form-control',
                                'id' => 'number',
                                'placeholder' => $edit_table_lang['seats']);
                            echo form_input($data, set_value('seats', $table->seats));
                        ?>
                    </div>
                    <div class="checkbox">
                        <label>
                        <?php
                            echo ($table->for_vegans == 1) ? form_checkbox('for_vegans', 'accept', TRUE) : form_checkbox('for_vegans', TRUE);
                            echo $edit_table_lang['for_vegans'];
                        ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang[ 'shift'];?>: </label>
                        <?php
                            $options=array();
                            foreach ($shifts as $temp)
                            { $options[$temp->id] = $temp->name; }
                            echo form_dropdown('shift', $options, set_value('shift',$table->shift_id), 'class = "form-control"');
                        ?>
                    </div>
                    <div class="form-group text-center">
                        <?php echo form_submit( 'submit', $edit_table_lang[ 'edit'], 'class = "btn btn-primary"'); ?>
                        <a href="<?php echo base_url('admin/tables'); ?>" class='btn btn-info'><?php echo $edit_table_lang['manage_tables'] ?></a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->