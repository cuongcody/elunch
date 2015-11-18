<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <?php echo anchor('admin/shifts/add', $shifts_lang['create_shift'], "class='btn btn-primary'"); ?>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
            <div class='table-responsive'>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class='heading'>
                            <?php
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'>".$shifts_lang['shift']."</th>";
                                echo "<th class='column-title'>".$shifts_lang['description']."</th>";
                                echo "<th class='column-title'>".$shifts_lang['start_time']."</th>";
                                echo "<th class='column-title'>".$shifts_lang['end_time']."</th>";
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'></th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($shifts != NULL)
                            {
                                foreach ($shifts as $key => $shift)
                                {
                        ?>
                                    <tr id="shift_<?php echo $shift->id ?>">
                                        <td class="active"><?php echo ($key + 1) ?></td>
                                        <td class="active"><?php echo $shift->name ?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $shift->description ?>" data-title="<?php echo $shifts_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($shift->description) > 30) ? substr($shift->description, 0, 30)."..." : $shift->description ?></p>
                                            </a>
                                        </td>
                                        <td class="active"><?php echo date("g:i A", strtotime($shift->start_time)) ?></td>
                                        <td class="active"><?php echo date("g:i A", strtotime($shift->end_time)) ?></td>
                                        <td class="active"><?php echo anchor('admin/shifts/edit/'.$shift->id, $shifts_lang['edit'], "class='label label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_shift_modal" class="label label-warning" data-toggle="modal" data-target="#delete_shift_modal" data-shift-id="<?php echo $shift->id ?>" onclick="false;"><?php echo $shifts_lang["delete"] ?></a>
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
<div class="modal fade" id="delete_shift_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $shifts_lang['delete'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $shifts_lang[ 'are_you_sure'] ?>
                <input type="hidden" name='shift_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $shifts_lang[ 'cancel'] ?>
                </button>
                <button type="button" id='delete_shift' data-dismiss="modal" data-path="<?php echo base_url().'admin/shifts/delete/'; ?>" class="btn btn-primary">
                <?php echo $shifts_lang[ 'yes'] ?>
                </button>
            </div>
        </div>
    </div>
</div>