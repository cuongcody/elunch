<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-xs-12'>
            <div class="row">
                <div class= "col-xs-12 col-md-5">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                <?php echo anchor('admin/meals/add', $meals_lang['create_meal'], "class='btn btn-primary'"); ?>
                </div>
                <div class= "col-xs-12 col-md-7">
                    <?php echo form_open_multipart( 'admin/meals/'); ?>
                        <div class="form-group col-md-5 col-sm-5 col-xs-12">
                            <?php
                                $data = array(
                                    'name' => 'from',
                                    'class' => 'form-control datetimepicker',
                                    'placeholder' => $meals_lang['from']);
                                echo form_input($data, set_value('from', ''));
                            ?>
                        </div>
                        <div class="form-group col-md-5 col-sm-5 col-xs-12">
                            <?php
                                $data = array(
                                    'name' => 'to',
                                    'class' => 'form-control datetimepicker',
                                    'placeholder' => $meals_lang['to']);
                                echo form_input($data, set_value('to', ''));
                            ?>
                        </div>
                        <div class="form-group col-md-2 col-sm-2 col-xs-12">
                            <?php echo form_submit( 'submit', $meals_lang['search'], 'class = "btn btn-primary"'); ?>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
            <div class="table-responsive">
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class='heading'>
                            <?php
                                echo "<th class='column-title'></th>";
                                echo "<th class='column'>".$meals_lang['lunch_date']."</th>";
                                echo "<th class='column'>".$meals_lang['preordered_meal']."</th>";
                                echo "<th class='column'>".$meals_lang['menu']."</th>";
                                echo "<th class='column'>".$meals_lang['dishes_of_menu']."</th>";
                                echo "<th class='column'></th>";
                                echo "<th class='column'></th>";
                                echo "<th class='column'></th>";
                                echo "<th class='column'></th></thead>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($meals != NULL)
                            {
                                foreach ($meals as $key => $meal)
                                {
                        ?>
                                    <tr id="meal_<?php echo $meal->id ?>">
                                        <td class="active"><?php echo (($page == 0 ? $page : ($page - 1)) * 10 + $key + 1) ?></td>
                                        <td class="active"><?php echo $meal->meal_date ?></td>
                                        <td class="active"><?php echo $meal->preordered_meals ?></td>
                                        <td class="active"><?php echo $meal->menu_name ?></td>
                                        <td class="active">
                                            <a href="#list_dishes_modal" class="label label-success" data-toggle="modal" data-target="#list_dishes_modal" data-path="<?php echo base_url()."admin/menus/list_dishes_from_menu/".$meal->menu_id ?>" onclick="false;">
                                                <?php echo $meals_lang["dishes_of_menu"] ?>
                                            </a>
                                        </td>
                                        <td class="active"><?php echo anchor('admin/meals/edit/'.$meal->id, $meals_lang['edit'], "class='label label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_meal_modal" class="label label-warning" data-toggle="modal" data-target="#delete_meal_modal" data-meal-id="<?php echo $meal->id ?>" onclick="false;"><?php echo $meals_lang["delete"] ?></a>
                                        </td>
                                        <td class="active">
                                        <?php if ($meal->check_log == 0){
                                        ?>
                                            <a href="#gen_log_file_meal_modal" class="label label-danger log_file" data-toggle="modal" data-target="#gen_log_file_meal_modal" data-meal-id="<?php echo $meal->id ?>" data-meal-date="<?php echo $meal->meal_date ?>" onclick="false;"><?php echo $meals_lang["generate_log_file"] ?></a>
                                        <?php } ?>
                                        </td>
                                        <td class="active">
                                            <span class="label label-default btn-meal-report" data-date="<?php echo $meal->meal_date ?>" data-path="<?php echo base_url('admin/meals/report')?>">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </span>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="delete_meal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $meals_lang['delete'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $meals_lang['are_you_sure'] ?>
                <input type="hidden" name='meal_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $meals_lang['cancel'] ?></button>
                <button type="button" id='delete_meal' data-dismiss="modal" data-path="<?php echo base_url().'admin/meals/delete/'; ?>" class="btn btn-primary"><?php echo $meals_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="list_dishes_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $meals_lang['dishes_of_menu'] ?></h4>
            </div>
            <div class="modal-body pre-scrollable">
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class="heading">
                            <th class="column-title"></th>
                            <th class="column-title"><?php echo $meals_lang['image'] ?></th>
                            <th class="column-title"><?php echo $meals_lang['name_dish'] ?></th>
                            <th class="column-title"><?php echo $meals_lang['category'] ?></th>
                      </tr>
                    </thead>
                   <tbody class="dishes-of-menu">
                   </tbody>
                </table>
                <input type="hidden" name='menu_id' value="" data-path="<?php echo base_url().'admin/menus/list_dishes_from_menu/'; ?>" >
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gen_log_file_meal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $meals_lang['generate_log_file'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $meals_lang['want_to_gen_log_file'] ?>
                <input type="hidden" name='meal_date' value="">
                <input type="hidden" name='meal_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $meals_lang['cancel'] ?></button>
                <button type="button" id='gen_log_file_meal' data-dismiss="modal" data-path="<?php echo base_url().'admin/meals/generate_log_file_meal/'; ?>" class="btn btn-primary"><?php echo $meals_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>
