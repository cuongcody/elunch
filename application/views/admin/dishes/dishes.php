<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-xs-12 col-md-offset-1 col-md-10'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <div class='row'>
                <div class= "col-xs-12 col-md-5">
                    <?php echo anchor('admin/dishes/add', $dishes_lang['create_dish'], "class='btn btn-loading btn-primary'"); ?>
                </div>
                <div class= "col-xs-12 col-md-7">
                    <?php echo form_open('admin/dishes/search'); ?>
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <?php
                                    $options=array('all' => 'All categories');
                                    if (!empty($categories))
                                    {
                                        foreach ($categories as $item)
                                        { $options[$item->id] = $item->name; }
                                        $select_category = $this->input->post('category');
                                        echo form_dropdown('category', $options, $this->session->userdata('search_category'), 'class= "form-control"');
                                    }
                                    else
                                    {
                                        echo form_dropdown('category', $options, set_value('category', ''),'class= "form-control"');
                                    }
                                ?>
                            </div>
                            <div class="form-group col-xs-7">
                                <div class="input-group">
                                    <?php
                                        $data = array(
                                            'name' => 'search',
                                            'class' => 'form-control',
                                            'placeholder' => $dishes_lang['search_name']);
                                        echo form_input($data, $this->session->userdata('search_dishes_name'));
                                    ?>
                                    <span class="input-group-btn">
                                        <?php echo form_submit( 'submit', $dishes_lang['search'], 'class = "btn btn-primary"'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
            <div class='table-responsive'>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class='heading'>
                            <?php
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'>".$dishes_lang['image']."</th>";
                                echo "<th class='column-title'>".$dishes_lang['name']."</th>";
                                echo "<th class='column-title'>".$dishes_lang['description']."</th>";
                                echo "<th class='column-title'>".$dishes_lang['category']."</th>";
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'></th>";
                             ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($dishes != NULL)
                            {
                                foreach ($dishes as $key => $dish)
                                {
                        ?>
                                    <tr id="dish_<?php echo $dish->id ?>">
                                        <td class="active"><?php echo (($page == 0 ? $page : ($page - 1)) * 10 + $key + 1) ?></td>
                                        <td class="active">
                                            <img class="img-thumbnail" width="200" height="200" src="<?php echo $dish->image ?>" alt="">
                                        </td>
                                        <td class="active"><?php echo $dish->name ?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $dish->description ?>" data-title="<?php echo $dishes_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($dish->description) > 30) ? substr($dish->description, 0, 30)."..." : $dish->description ?></p>
                                            </a>
                                        </td>
                                        <td class="active"><?php echo $dish->category ?></td>
                                        <td class="active"><?php echo anchor('admin/dishes/edit/'.$dish->id, $dishes_lang['edit'], "class='btn-loading label label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_dish_modal" class="label label-warning" data-toggle="modal" data-target="#delete_dish_modal" data-dish-image-file-name="<?php echo $dish->image_file_name ?>" data-dish-id="<?php echo $dish->id ?>" onclick="false;"><?php echo $dishes_lang["delete"] ?></a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    <tbody>
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
<div class="modal fade" id="delete_dish_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $dishes_lang['delete'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $dishes_lang['are_you_sure'] ?>
                <input type="hidden" name='dish_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dishes_lang['cancel'] ?></button>
                <button type="button" id='delete_dish' data-dismiss="modal" data-path="<?php echo base_url().'admin/dishes/delete/'; ?>" class="btn btn-primary"><?php echo $dishes_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>

