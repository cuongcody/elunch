<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/categories/add'); ?>
                    <h2><?php echo $new_category_lang['title'] ?></h2>
                    <div class="form-group">
                        <label for="inputCategory"><?php echo $new_category_lang['category'] ?> </label>
                        <?php
                            $data = array(
                            'name' => 'category',
                            'class' => 'form-control',
                            'placeholder' => $new_category_lang['category']);
                            echo form_input($data, set_value('category', ''));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription"><?php echo $new_category_lang['description'] ?></label>
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
                        <?php echo form_submit('submit', $new_category_lang['save'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->