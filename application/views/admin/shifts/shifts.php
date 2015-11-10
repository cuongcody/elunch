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
                            foreach ($shifts as $key => $shift)
                            {
                                echo "<tr id='shift_".$shift->id."'>";
                                echo "<td class='active'>".($key+1)."</td>";
                                echo "<td class='active'>".$shift->name."</td>";
                                echo "<td class='active'><a href='#detail_text_modal' data-toggle='modal' data-target='#detail_text_modal' data-content='{$shift->description}' data-title='{$shifts_lang['title']}' onclick='false;'><p class='detail-text'>".substr($shift->description,0,100)."...</a></td>";
                                echo "<td class='active'>".date("g:i A", strtotime($shift->start_time))."</td>";
                                echo "<td class='active'>".date("g:i A", strtotime($shift->end_time))."</td>";
                                echo "<td class='active'>".anchor('admin/shifts/edit/'.$shift->id, $shifts_lang['edit'], "class='label label-info'")."</td>";
                                echo "<td class='active'>";
                                echo "<a href='#delete_shift_modal' class='label label-warning' data-toggle='modal' data-target='#delete_shift_modal' data-shift-id={$shift->id} onclick='false;'>".$shifts_lang["delete"]."</a></td>";
                                echo "</tr>";
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