<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10'>
            <?php echo anchor('admin/categories/add', $categories_lang['create_category'], "class='btn btn-primary'"); ?>
            <?php if (!empty($_SESSION['message'])) echo "<script>toastr.success('".$_SESSION['message']."')</script>"; ?>
            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                <thead>
                    <tr class='heading'>
                        <?php
                            echo "<th class='column-title'></th>";
                            echo "<th class='column-title'>".$categories_lang['category']."</th>";
                            echo "<th class='column-title'>".$categories_lang['description']."</th>";
                            echo "<th class='column-title'></th>";
                            echo "<th class='column-title'></th>";
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($categories as $key => $category)
                        {
                            echo "<tr id='category_".$category->id."'>";
                            echo "<td class='active'>".($key+1)."</td>";
                            echo "<td class='active'>".$category->name."</td>";
                            echo "<td class='active'>".anchor('admin/categories/edit/'.$category->id, substr($category->description,0,60)."...",'')."</td>";
                            echo "<td class='active'>".anchor('admin/categories/edit/'.$category->id, $categories_lang['edit'], "class='label label-info'")."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#delete_category_modal' class='label label-warning' data-toggle='modal' data-target='#delete_category_modal' data-category-id={$category->id} onclick='false;'>".$categories_lang["delete"]."</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="delete_category_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $categories_lang['delete'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $categories_lang[ 'are_you_sure'] ?>
                <input type="hidden" name='category_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $categories_lang[ 'cancel'] ?>
                </button>
                <button type="button" id='delete_category' data-dismiss="modal" data-path="<?php echo base_url().'admin/categories/delete/'; ?>" class="btn btn-primary">
                <?php echo $categories_lang[ 'yes'] ?>
                </button>
            </div>
        </div>
    </div>
</div>