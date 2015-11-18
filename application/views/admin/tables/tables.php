<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <div class='row'>
                <div class= "col-xs-12 col-md-5">
                    <?php echo anchor('admin/tables/add', $tables_lang['create_table'], "class='btn btn-primary'"); ?>
                </div>
                <div class= "col-xs-12 col-md-offset-2 col-md-5">
                    <?php echo form_open_multipart('admin/tables/'); ?>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                    $data = array(
                                        'name' => 'search',
                                        'class' => 'form-control',
                                        'placeholder' => $tables_lang['search_name']);
                                    echo form_input($data, set_value('search', ''));
                                ?>
                                <span class="input-group-btn">
                                    <?php echo form_submit( 'submit', $tables_lang['search'], 'class = "btn btn-primary"'); ?>
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
                                echo "<th class='column'>".$tables_lang['table_name']."</th>";
                                echo "<th class='column'>".$tables_lang['description']."</th>";
                                echo "<th class='column'>".$tables_lang['for_vegans']."</th>";
                                echo "<th class='column'>".$tables_lang['seats']."</th>";
                                echo "<th class='column'>".$tables_lang['shift']."</th>";
                                echo "<th class='column'></th>";
                                echo "<th class='column'></th></thead>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($tables != NULL)
                            {
                                foreach ($tables as $key => $table)
                                {
                        ?>
                                    <tr id="table_<?php echo $table->id ?>">
                                        <td class="active"><?php echo (($page == 0 ? $page : ($page - 1))*10 + $key + 1) ?></td>
                                        <td class="active"><?php echo $table->name ?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $table->description ?>" data-title="<?php echo $tables_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($table->description) > 30) ? substr($table->description, 0, 30)."..." : $table->description ?></p>
                                            </a>
                                        </td>
                                        <td class="active">
                                            <input type="checkbox" disabled class="text-center" <?php echo (($table->for_vegans == 1) ? "checked" : "") ?> >
                                        </td>
                                        <td class="active"><?php echo $table->seats ?></td>
                                        <td class="active"><?php echo $table->shift ?></td>
                                        <td class="active"><?php echo anchor('admin/tables/edit/'.$table->id, $tables_lang['edit'], "class='label label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_table_modal" class="label label-warning" data-toggle="modal" data-target="#delete_table_modal" data-table-id="<?php echo $table->id ?>" onclick="false;"><?php echo $tables_lang["delete"] ?></a>
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