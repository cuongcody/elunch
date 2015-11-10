<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h2><?php echo $new_meal_lang['title'] ?></h2>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php echo form_open_multipart( 'admin/meals/add'); ?>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                        <label for="inputDescription"><?php echo $new_meal_lang['lunch_date'] ?></label>
                        <div class="input-group date datetimepicker">
                            <?php
                                $data = array(
                                    'name' => 'lunch_date',
                                    'class' => 'form-control',
                                    'placeholder' => $new_meal_lang['lunch_date']);
                                echo form_input($data, set_value('lunch_date', ''));
                            ?>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                        <label for="inputDescription"><?php echo $new_meal_lang['preordered_meal'] ?></label>
                        <?php
                            $data = array(
                                'type' => 'number',
                                'name' => 'preordered_meal',
                                'class' => 'form-control',
                                'data-validate-minmax' => '1,100'
                            );
                            echo form_input($data, set_value('preordered_meal',''));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                        <label ><?php echo $new_meal_lang['menu'] ?></label>
                        <?php
                            $options=array();
                            if (!empty($menus))
                            {
                                foreach ($menus as $item)
                                { $options[$item->id] = $item->name; }
                                $select_menu = $this->input->post('menu');
                                echo form_dropdown('menu', $options, set_value('menu', (!empty($select_menu) ) ? "$select_menu" : $menus[0]->id),'class= "form-control" id="menu" data-path="'.base_url('admin/menus/list_dishes_from_menu').'"');
                                }
                            else
                            {
                                echo form_dropdown('menu', $options, set_value('menu', ''), 'class= "form-control" id="menu" data-path="'.base_url('admin/menus/list_dishes_from_menu').'"');
                            }
                        ?>
                    </div>
                    <div class ="form-group col-md-6 col-sm-6 col-xs-12 table-responsive">
                        <label ><?php echo $new_meal_lang['dishes_of_menu'] ?></label>
                        <table class="table table-header table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr class='heading'>
                                    <th class="column-title"></th>
                                    <th class='column-title'><?php echo $new_meal_lang['image'] ?></th>
                                    <th class='column-title'><?php echo $new_meal_lang['name_dish'] ?></th>
                                    <th class='column-title'><?php echo $new_meal_lang['category'] ?></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="pre-scrollable">
                            <table class="table table-striped responsive-utilities jambo_table bulk_action dishes-of-menu">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12">
                    <?php echo form_submit('submit', $new_meal_lang['save'], 'class = "btn btn-primary"'); ?>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- /page content -->