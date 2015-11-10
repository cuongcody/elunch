<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-xs-12 col-md-offset-2 col-md-8'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h2><?php echo $edit_dish_lang['title'] ?></h2>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php echo form_open_multipart( 'admin/dishes/edit/'.$dish['id']); ?>
                <div class="form-group">
                    <label for="inputCategory"><?php echo $edit_dish_lang['name'] ?> </label>
                    <?php
                        $data = array(
                        'name' => 'name',
                        'class' => 'form-control',
                        'placeholder' => $edit_dish_lang['name']);
                        echo form_input($data, set_value('name', $dish['name']));
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputDescription"><?php echo $edit_dish_lang['description'] ?></label>
                    <?php
                        $data = array(
                          'name' => 'description',
                          'rows' => '5',
                          'cols' => '10',
                          'class' => 'form-control'
                        );
                        echo form_textarea($data, set_value('description',$dish['description']));
                    ?>
                </div>
                <div class="form-group">
                    <label><?php echo $edit_dish_lang[ 'category'];?>: </label>
                    <?php $options=array();
                    foreach ($categories as $item)
                      { $options[$item->id] = $item->name; }
                    echo form_dropdown('category', $options, set_value('category', $dish['category_id']),'class= "form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="inputFile"><?php echo $edit_dish_lang[ 'image'] ?></label>
                    <div>
                        <img id='img' class="img-thumbnail" height="200" width="200" src="<?php echo base_url("assets/images/dishes/{$upload['file_name']}"); ?>" alt="">
                    </div>
                    <?php echo form_input(array('name'=> 'img', 'type' => 'file', 'onchange'=>'readURL(this)')); ?>
                </div>
                <div class="form-group text-center">
                    <?php echo form_submit('submit', $edit_dish_lang['edit'], 'class = "btn btn-primary"'); ?>
                    <a href="<?php echo base_url('admin/dishes'); ?>" class='btn btn-info'><?php echo $edit_dish_lang['manage_dishes'] ?></a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</div>
<!-- /page content -->