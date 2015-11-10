<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h2><?php echo $new_menu_lang['title'] ?></h2>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php echo form_open_multipart( 'admin/menus/add'); ?>
                <div class="form-group">
                    <label for="inputCategory"><?php echo $new_menu_lang['name'] ?> </label>
                    <?php
                        $data = array(
                            'name' => 'menu',
                            'class' => 'form-control',
                            'placeholder' => $new_menu_lang['name']);
                        echo form_input($data, set_value('menu', ''));
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputDescription"><?php echo $new_menu_lang['description'] ?></label>
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
                    <label for="inputDescription"><?php echo $new_menu_lang['filtered_by'] ?></label>
                    <?php
                        $options=array();
                        if (!empty($categories))
                        {
                            foreach ($categories as $item)
                            { $options[$item->id] = $item->name; }
                            $select_category = $this->input->post('category');
                            echo form_dropdown('category', $options, set_value('category',( !empty($select_category) ) ? "$select_category" : $categories[0]->id),'class= "form-control" id="category" data-path="'.base_url('admin/menus/dishes/').'"');
                        }
                        else
                        {
                            echo form_dropdown('category', $options, set_value('category',''),'class= "form-control" id="category" data-path="'.base_url('admin/menus/dishes/').'"');
                        }
                    ?>
                </div>
                <div class ="form-group">
                  <div class="col-md-6 col-md-6 col-xs-12 pre-scrollable">
                        <div class='table-responsive'>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class='heading'>
                                        <th class='text-center'><?php echo $new_menu_lang['dishes'] ?></th>
                                    </tr>
                                </thead>
                                <tbody class='dishes_item'>
                                </tbody>
                            </table>
                        </div>
                        </div>
                </div>
                <div class ="form-group">
                    <div class="col-md-6 col-md-6 col-xs-12 pre-scrollable">
                        <div class='table-responsive'>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class='heading'>
                                        <th class='text-center'><?php echo $new_menu_lang['dishes_of_menu'] ?></th>
                                    </tr>
                                </thead>
                                <tbody class='dishes_item_of_menu'>
                                <?php
                                    if (!empty($this->input->post('dishes_of_menu')))
                                    {
                                        $name_dishes = $this->input->post('name_dishes');
                                        foreach ($this->input->post('dishes_of_menu') as $key => $dish_id)
                                        {
                                            echo "<tr id='dish_item_of_menu_".$dish_id."' class='dish_item_of_menu'><td value='".$dish_id."'>".$name_dishes[$key]."</td></tr>";
                                            echo "<input type='hidden' name='dishes_of_menu[]' value='".$dish_id."'>";
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 col-md-12 col-xs-12 text-center">
                    <?php echo form_submit( 'submit', $new_menu_lang['save'], 'class = "btn btn-primary"'); ?>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- /page content -->