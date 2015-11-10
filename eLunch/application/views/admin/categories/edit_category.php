<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <h2><?php echo $edit_category_lang['title'] ?></h2>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/categories/edit/'.$category_item->id); ?>
                        <div class="form-group">
                            <label for="inputCategory"><?php echo $edit_category_lang['category'] ?> </label>
                            <?php
                                $data = array(
                                  'name' => 'category',
                                  'class' => 'form-control',
                                  'placeholder' => $edit_category_lang['category']);
                                echo form_input($data, set_value('category', $category_item->name));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription"><?php echo $edit_category_lang['description'] ?></label>
                            <?php
                                $data = array(
                                  'name' => 'description',
                                  'rows' => '5',
                                  'cols' => '10',
                                  'class' => 'form-control'
                                );
                                echo form_textarea($data, set_value('description',$category_item->description));
                            ?>
                        </div>
                        <div class="form-group text-center">
                            <?php echo form_submit('submit', $edit_category_lang['edit'], 'class = "btn btn-primary"'); ?>
                            <a href="<?php echo base_url('admin/categories'); ?>" class='btn btn-info'><?php echo $edit_category_lang['manage_categories'] ?></a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->