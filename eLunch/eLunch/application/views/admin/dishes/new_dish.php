<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h2><?php echo $new_dish_lang['title'] ?></h2>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php echo form_open_multipart( 'admin/dishes/add'); ?>
                <div class="form-group">
                    <label for="inputCategory"><?php echo $new_dish_lang['name'] ?> </label>
                    <?php
                        $data = array(
                            'name' => 'name',
                            'class' => 'form-control',
                            'placeholder' => $new_dish_lang['name']);
                        echo form_input($data, set_value('name', ''));
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputDescription"><?php echo $new_dish_lang['description'] ?></label>
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
                    <label><?php echo $new_dish_lang[ 'category'];?>: </label>
                    <?php
                        $options=array();
                        if (!empty($categories))
                        {
                            foreach ($categories as $item)
                            { $options[$item->id] = $item->name; }
                            $select_category = $this->input->post('category');
                            echo form_dropdown('category', $options, set_value('category', ( !empty($select_category) ) ? "$select_category" : $categories[0]->id),'class= "form-control"');
                        }
                        else
                        {
                            echo form_dropdown('category', $options, set_value('category', ''),'class= "form-control"');
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputFile"><?php echo $new_dish_lang['image'] ?></label>
                    <div>
                        <img id='img' class="img-thumbnail" height="200" width="200" src="<?php echo (!isset($upload)) ? base_url('assets/images/dishes/default-image.png') : base_url('assets/images/dishes/'.$upload['file_name']); ?>" alt="">
                    </div>
                    <?php echo form_input(array('name'=> 'img', 'type' => 'file', 'onchange'=>'readURL(this)')); ?>
                </div>
                <div class="form-group text-center">
                    <?php echo form_submit( 'submit', $new_dish_lang['save'], 'class = "btn btn-primary"'); ?>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</div>
<!-- /page content -->