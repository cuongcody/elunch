<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-12'>
            <div class="row">
                <div class= "col-md-6">
                <?php
                    echo anchor('admin/meals/add', $meals_lang['create_meal'], "class='btn btn-primary'");
                ?>
                </div>
                <div class= "col-md-6">
                    <?php echo form_open_multipart( 'admin/meals/'); ?>
                        <div class="form-group col-md-5 col-sm-5 col-xs-12">
                            <?php
                                $data = array(
                                    'name' => 'from',
                                    'class' => 'form-control datepicker',
                                    'data-date-format' => 'yyyy/mm/dd',
                                    'placeholder' => $meals_lang['from']);
                                echo form_input($data, set_value('from', ''));
                            ?>
                        </div>
                        <div class="form-group col-md-5 col-sm-5 col-xs-12 input-group">
                            <?php
                                $data = array(
                                    'name' => 'to',
                                    'class' => 'form-control datepicker',
                                    'data-date-format' => 'yyyy/mm/dd',
                                    'placeholder' => $meals_lang['to']);
                                echo form_input($data, set_value('to', ''));
                            ?>
                            <span class="input-group-btn">
                                <?php echo form_submit( 'submit', $meals_lang['search'], 'class = "btn btn-primary"'); ?>
                            </span>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php if (!empty($_SESSION['message'])) echo "<script>toastr.success('".$_SESSION['message']."')</script>"; ?>
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
                            echo "<th class='column'></th></thead>";
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($meals as $key => $meal)
                        {
                            echo "<tr id='meal_".$meal->id."'>";
                            echo "<td class='active'>".($key+1)."</td>";
                            echo "<td class='active'>".$meal->meal_date."</td>";
                            echo "<td class='active'>".$meal->preordered_meals."</td>";
                            echo "<td class='active'>".$meal->menu_name."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#list_dishes_modal' class='label label-success' data-toggle='modal' data-target='#list_dishes_modal' data-path='".base_url()."admin/menus/list_dishes_from_menu/".$meal->menu_id."' onclick='false;'>".$meals_lang["dishes_of_menu"]."</a></td>";
                            echo "<td class='active'>".anchor('admin/meals/edit/'.$meal->id, $meals_lang['edit'], "class='label label-info'")."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#delete_meal_modal' class='label label-warning' data-toggle='modal' data-target='#delete_meal_modal' data-meal-id={$meal->id} onclick='false;'>".$meals_lang["delete"]."</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12 text-center">
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
            <div class="modal-body">
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