<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h2><?php echo $edit_meal_lang['title'] ?></h2>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php echo form_open_multipart( 'admin/meals/edit/'.$meal->id); ?>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                        <label><?php echo $edit_meal_lang['lunch_date'] ?></label>
                        <?php
                            $data = array(
                                'name' => 'lunch_date',
                                'class' => 'form-control',
                                'data-validate-minmax' => '1,100'
                            );
                            echo form_input($data, set_value('lunch_date', $meal->meal_date), 'disabled');
                        ?>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6">
                        <label><?php echo $edit_meal_lang['preordered_meal'] ?></label>
                        <?php
                            $data = array(
                                'type' => 'number',
                                'name' => 'preordered_meal',
                                'class' => 'form-control',
                                'data-validate-minmax' => '1,100'
                            );
                            echo form_input($data, set_value('preordered_meal', $meal->preordered_meals));
                        ?>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6">
                        <label for="inputDescription"></label>
                        <div class="checkbox">
                            <label>
                            <?php
                                echo ($meal->for_vegans == 1) ? form_checkbox( 'for_vegans', 'accept', TRUE) : form_checkbox( 'for_vegans', TRUE);
                                echo $edit_meal_lang[ 'for_vegans']; ?>
                            </label>
                        </div>
                    </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                        <label ><?php echo $edit_meal_lang['menu'] ?></label>
                        <?php
                            $options=array();
                            foreach ($menus as $item)
                            { $options[$item->id] = $item->name; }
                            echo form_dropdown('menu', $options, set_value('menu', $meal->menu_id), 'class= "form-control" id="menu" data-path="'.base_url('admin/menus/list_dishes_from_menu').'"');
                        ?>
                    </div>
                    <div class ="form-group col-md-6 col-sm-6 col-xs-12">
                        <label ><?php echo $edit_meal_lang['dishes_of_menu'] ?></label>
                        <div class='table-responsive'>
                            <table class="table table-header table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class='heading'>
                                        <th class="column-title"></th>
                                        <th class='column-title'><?php echo $edit_meal_lang['image'] ?></th>
                                        <th class='column-title'><?php echo $edit_meal_lang['name_dish'] ?></th>
                                        <th class='column-title'><?php echo $edit_meal_lang['category'] ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="pre-scrollable">
                            <div class='table-responsive'>
                                <table class="table table-striped responsive-utilities jambo_table bulk_action dishes-of-menu">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12">
                        <?php echo form_submit( 'submit', $edit_meal_lang['edit'], 'class = "btn btn-primary"'); ?>
                        <a href="<?php echo base_url('admin/meals'); ?>" class='btn btn-loading btn-info'><?php echo $edit_meal_lang['manage_meals'] ?></a>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- /page content -->