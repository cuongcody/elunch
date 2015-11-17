<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-xs-12 col-md-offset-1 col-md-10'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <?php echo anchor('admin/dishes/add', $dishes_lang['create_dish'], "class='btn btn-primary'"); ?>
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
                            foreach ($dishes as $key => $dish)
                            {
                                echo "<tr id='dish_".$dish->id."'>";
                                echo "<td class='active'>".(($page == 0 ? $page : ($page - 1))*10 + $key + 1)."</td>";
                                echo "<td class='active'><img class='img-thumbnail' width='200' height='200' src='".$dish->image."' alt=''></td>";
                                echo "<td class='active'>".$dish->name."</td>";
                                echo "<td class='active'><a href='#detail_text_modal' data-toggle='modal' data-target='#detail_text_modal' data-content='{$dish->description}' data-title='{$dishes_lang['title']}' onclick='false;'><p class='detail-text'>".substr($dish->description,0,100)."...</a></td>";
                                echo "<td class='active'>".$dish->category."</td>";
                                echo "<td class='active'>".anchor('admin/dishes/edit/'.$dish->id, $dishes_lang['edit'], "class='label label-info'")."</td>";
                                echo "<td class='active'>";
                                echo "<a href='#delete_dish_modal' class='label label-warning' data-toggle='modal' data-target='#delete_dish_modal' data-dish-image-file-name='{$dish->image_file_name}' data-dish-id={$dish->id} onclick='false;'>".$dishes_lang["delete"]."</a></td>";
                                echo "</tr>";
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

