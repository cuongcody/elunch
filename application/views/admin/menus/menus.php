<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class='col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <div class='row'>
                <div class= "col-xs-12 col-md-5">
                    <?php echo anchor('admin/menus/add', $menus_lang['create_menu'], "class='btn btn-loading btn-loading btn-primary'"); ?>
                </div>
                <div class= "col-xs-12 col-md-offset-2 col-md-5">
                    <?php echo form_open('admin/menus/search'); ?>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                    $data = array(
                                        'name' => 'search',
                                        'class' => 'form-control',
                                        'placeholder' => $menus_lang['search_name']);
                                    echo form_input($data, $this->session->userdata('search_name'));
                                ?>
                                <span class="input-group-btn">
                                    <?php echo form_submit( 'submit', $menus_lang['search'], 'class = "btn btn-primary"'); ?>
                                </span>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
            <div class='table-responsive'>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class='heading'>
                            <?php
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'>".$menus_lang['menu']."</th>";
                                echo "<th class='column-title'>".$menus_lang['description']."</th>";
                                echo "<th class='column-title'>".$menus_lang['dishes_of_menu']."</th>";
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'></th></thead>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($menus != NULL)
                            {
                                foreach ($menus as $key => $menu)
                                {
                        ?>
                                    <tr id="menu_<?php echo $menu->id ?>">
                                        <td class="active"><?php echo (($page == 0 ? $page : ($page - 1)) * 10 + $key + 1) ?></td>
                                        <td class="active"><?php echo $menu->name?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $menu->description ?>" data-title="<?php echo $menus_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($menu->description) > 30) ? substr($menu->description, 0, 30)."..." : $menu->description ?></p>
                                            </a>
                                        </td>
                                        <td class="active">
                                            <a href="#list_dishes_modal" class="label label-success" data-toggle="modal" data-target="#list_dishes_modal" data-path="<?php echo base_url()."admin/menus/list_dishes_from_menu/".$menu->id ?>" onclick="false;"><?php echo $menus_lang["dishes_of_menu"] ?></a>
                                        </td>
                                        <td class="active"><?php echo anchor('admin/menus/edit/'.$menu->id, $menus_lang['edit'], "class='btn-loading label label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_menu_modal" class="label label-warning" data-toggle="modal" data-target="#delete_menu_modal" data-menu-id="<?php echo $menu->id?>" onclick="false;"><?php echo $menus_lang["delete"] ?></a></td>
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
            <div class="modal-body pre-scrollable">
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