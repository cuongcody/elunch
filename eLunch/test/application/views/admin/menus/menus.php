<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-12'>
            <div class="row">
                <div class= "col-md-6">
                <?php
                    echo anchor('admin/menus/add', $menus_lang['create_menu'], "class='btn btn-primary'");
                ?>
                </div>
            </div>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php if (!empty($_SESSION['message'])) echo "<script>toastr.success('".$_SESSION['message']."')</script>"; ?>
            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                <thead>
                    <tr class='heading'>
                        <?php
                            echo "<th class='column-title'></th>";
                            echo "<th class='column'>".$menus_lang['menu']."</th>";
                            echo "<th class='column'>".$menus_lang['description']."</th>";
                            echo "<th class='column'>".$menus_lang['dishes_of_menu']."</th>";
                            echo "<th class='column'></th>";
                            echo "<th class='column'></th></thead>";
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($menus as $key => $menu)
                        {
                            echo "<tr id='menu_".$menu->id."'>";
                            echo "<td class='active'>".($key+1)."</td>";
                            echo "<td class='active'>".$menu->name."</td>";
                            echo "<td class='active'>".anchor('admin/menus/edit/'.$menu->id, substr($menu->description,0,10)."...",'')."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#list_dishes_modal' class='label label-success' data-toggle='modal' data-target='#list_dishes_modal' data-path='".base_url()."admin/menus/list_dishes_from_menu/".$menu->id."' onclick='false;'>".$menus_lang["dishes_of_menu"]."</a></td>";
                            echo "<td class='active'>".anchor('admin/menus/edit/'.$menu->id, $menus_lang['edit'], "class='label label-info'")."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#delete_menu_modal' class='label label-warning' data-toggle='modal' data-target='#delete_menu_modal' data-menu-id={$menu->id} onclick='false;'>".$menus_lang["delete"]."</a></td>";
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
<div class="modal fade" id="delete_menu_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $menus_lang['delete'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $menus_lang['are_you_sure'] ?>
                <input type="hidden" name='menu_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $menus_lang['cancel'] ?></button>
                <button type="button" id='delete_menu' data-dismiss="modal" data-path="<?php echo base_url().'admin/menus/delete/'; ?>" class="btn btn-primary"><?php echo $menus_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="list_dishes_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $menus_lang['dishes_of_menu'] ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                      <tr class="heading">
                         <th class="column-title"></th>
                         <th class="column-title"><?php echo $menus_lang['image'] ?></th>
                         <th class="column-title"><?php echo $menus_lang['name_dish'] ?></th>
                         <th class="column-title"><?php echo $menus_lang['category'] ?></th>
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