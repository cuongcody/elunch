<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <?php echo anchor('admin/floors/add', $floors_lang['create_floor'], "class='btn btn-loading btn-primary'"); ?>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
            <div class='table-responsive'>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class='heading'>
                            <?php
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'>".$floors_lang['floor']."</th>";
                                echo "<th class='column-title'>".$floors_lang['description']."</th>";
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'></th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($floors != NULL)
                            {
                                foreach ($floors as $key => $floor)
                                {
                        ?>
                                    <tr id="floor_<?php echo $floor->id ?>">
                                        <td class="active"><?php echo ($key + 1) ?></td>
                                        <td class="active"><?php echo $floor->name ?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $floor->description ?>" data-title="<?php echo $floors_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($floor->description) > 30) ? substr($floor->description, 0, 30)."..." : $floor->description ?></p>
                                            </a>
                                        </td>
                                        <td class="active"><?php echo anchor('admin/floors/edit/'.$floor->id, $floors_lang['edit'], "class='btn-loading label label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_floor_modal" class="label label-warning" data-toggle="modal" data-target="#delete_floor_modal" data-floor-id="<?php echo $floor->id ?>" onclick="false;"><?php echo $floors_lang["delete"] ?></a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="delete_floor_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $floors_lang['delete'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $floors_lang[ 'are_you_sure'] ?>
                <input type="hidden" name='floor_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $floors_lang[ 'cancel'] ?>
                </button>
                <button type="button" id='delete_floor' data-dismiss="modal" data-path="<?php echo base_url().'admin/floors/delete/'; ?>" class="btn btn-primary">
                <?php echo $floors_lang[ 'yes'] ?>
                </button>
            </div>
        </div>
    </div>
</div>