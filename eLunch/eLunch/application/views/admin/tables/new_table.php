<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <h2><?php echo $new_table_lang['title'] ?></h2>
                    <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                    <?php echo form_open('admin/tables/add'); ?>
                    <div class="form-group">
                        <label><?php echo $new_table_lang['table'] ?></label>
                        <?php
                            $data = array(
                                'name' => 'table',
                                'class' => 'form-control',
                                'placeholder' => $new_table_lang['table']);
                            echo form_input($data, set_value('table', ''));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $new_table_lang['description'] ?></label>
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
                    <div class="form-group">
                        <label><?php echo $new_table_lang['seats'] ?></label>
                        <?php
                            $data = array(
                                'type' => 'number',
                                'name' => 'seats',
                                'class' => 'form-control',
                                'id' => 'number',
                                'placeholder' => $new_table_lang['seats']);
                            echo form_input($data, set_value('seats', ''));
                        ?>
                    </div>
                    <div class="checkbox">
                        <label>
                        <?php
                            echo form_checkbox( 'for_vegans', 'accept', TRUE);
                            echo $new_table_lang[ 'for_vegans']; ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label><?php echo $new_table_lang[ 'shift'];?>: </label>
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
                    <div class="form-group text-center">
                        <?php echo form_submit('submit', $new_table_lang[ 'save'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->