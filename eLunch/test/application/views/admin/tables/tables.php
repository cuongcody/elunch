<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-12'>
            <div class="row">
                <div class= "col-md-6">
                <?php
                    echo anchor('admin/tables/add', $tables_lang['create_table'], "class='btn btn-primary'");
                ?>
                </div>
            </div>
            <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
            <?php if (!empty($_SESSION['message'])) echo "<script>announce_message('".$_SESSION['message']."')</script>"; ?>
            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                <thead>
                    <tr class='heading'>
                        <?php
                            echo "<th class='column-title'></th>";
                            echo "<th class='column'>".$tables_lang['table_name']."</th>";
                            echo "<th class='column'>".$tables_lang['description']."</th>";
                            echo "<th class='column'>".$tables_lang['for_vegans']."</th>";
                            echo "<th class='column'>".$tables_lang['seats']."</th>";
                            echo "<th class='column'>".$tables_lang['available_seats']."</th>";
                            echo "<th class='column'>".$tables_lang['shift']."</th>";
                            echo "<th class='column'>".$tables_lang['list_of_users']."</th>";
                            echo "<th class='column'></th>";
                            echo "<th class='column'></th></thead>";
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($tables as $key => $table)
                        {
                            echo "<tr id='table_".$table->id."'>";
                            echo "<td class='active'>".($key+1)."</td>";
                            echo "<td class='active'>".$table->name."</td>";
                            echo "<td class='active'>".anchor('admin/tables/edit/'.$table->id, substr($table->description,0,10)."...",'')."</td>";
                            echo "<td class='active'><input type='checkbox' disabled class='text-center' ".(($table->for_vegans == 1) ? 'checked' : '')."></td>";
                            echo "<td class='active'>".$table->seats."</td>";
                            echo "<td class='active'>".$table->available_seats."</td>";
                            echo "<td class='active'>".$table->shift."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#list_tables_modal' class='label label-success' data-toggle='modal' data-target='#list_tables_modal' data-path='".base_url()."admin/tables/list_users_from_table/".$table->id."' onclick='false;'>".$tables_lang["list_of_users"]."</a></td>";
                            echo "<td class='active'>".anchor('admin/tables/edit/'.$table->id, $tables_lang['edit'], "class='label label-info'")."</td>";
                            echo "<td class='active'>";
                            echo "<a href='#delete_table_modal' class='label label-warning' data-toggle='modal' data-target='#delete_table_modal' data-table-id={$table->id} onclick='false;'>".$tables_lang["delete"]."</a></td>";
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
<div class="modal fade" id="delete_table_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $tables_lang['delete'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $tables_lang['are_you_sure'] ?>
                <input type="hidden" name='table_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tables_lang['cancel'] ?></button>
                <button type="button" id='delete_table' data-dismiss="modal" data-path="<?php echo base_url().'admin/tables/delete/'; ?>" class="btn btn-primary"><?php echo $tables_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="list_tables_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $tables_lang['list_of_users'] ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                      <tr class="heading">
                         <th class="column-title"></th>
                         <th class="column-title"><?php echo $tables_lang['image'] ?></th>
                         <th class="column-title"><?php echo $tables_lang['name'] ?></th>
                         <th class="column-title"><?php echo $tables_lang['floor'] ?></th>
                      </tr>
                    </thead>
                    <tbody class="users_item">
                   </tbody>
                </table>
                <input type="hidden" name='table_id' value="" data-path="<?php echo base_url().'admin/tables/list_users_from_table/'; ?>" >
            </div>
        </div>
    </div>
</div>