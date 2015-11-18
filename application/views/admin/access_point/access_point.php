<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <?php echo anchor('admin/access_point/add', $access_point_lang['create_access_point'], "class='btn btn-primary'"); ?>
            <a href="#" onclick='chooseAccessPoint();' id='push_notification' class='btn btn-success' data-path="<?php echo base_url('admin/access_point/push_notification') ?>"><?php echo $access_point_lang['push_notification'] ?></a>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <div class='table-responsive'>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class='heading'>
                            <?php
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'>".$access_point_lang['ssid']."</th>";
                                echo "<th class='column-title'>".$access_point_lang['bssid']."</th>";
                                echo "<th class='column-title'>".$access_point_lang['selected']."</th>";
                                echo "<th class='column-title'></th>";
                                echo "<th class='column-title'></th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($access_point != NULL)
                            {
                                foreach ($access_point as $key => $access_point_item)
                                {
                        ?>
                                    <tr id="access_point_<?php echo $access_point_item->id ?>">
                                        <td class="active"><?php echo ($key + 1) ?></td>
                                        <td class="active"><?php echo $access_point_item->ssid ?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $access_point_item->bssid ?>" data-title="<?php echo $access_point_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($access_point_item->bssid) > 20) ? substr($access_point_item->bssid, 0, 20).'...' : $access_point_item->bssid ?></p>
                                            </a>
                                        </td>
                                        <td class="active"><input type="checkbox" disabled class="text-center" value="<?php echo $access_point_item->id ?>" name="selected_access_point" <?php echo (($access_point_item->selected == 1) ? "checked" : "") ?> ></td>
                                        <td class="active">
                                            <?php echo anchor('admin/access_point/edit/'.$access_point_item->id, $access_point_lang['edit'], "class='label label-info'") ?>
                                        </td>
                                        <td class="active">
                                            <a href="#delete_access_point_modal" class="label label-warning" data-toggle="modal" data-target="#delete_access_point_modal" data-access-point-id=<?php echo $access_point_item->id ?> onclick="false;"><?php echo $access_point_lang["delete"] ?></a>
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
<div class="modal fade" id="delete_access_point_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                &times;
                </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $access_point_lang['delete'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $access_point_lang[ 'are_you_sure'] ?>
                <input type="hidden" name='access_point_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $access_point_lang[ 'cancel'] ?>
                </button>
                <button type="button" id='delete_access_point' data-dismiss="modal" data-path="<?php echo base_url().'admin/access_point/delete/'; ?>" class="btn btn-primary">
                <?php echo $access_point_lang[ 'yes'] ?>
                </button>
            </div>
        </div>
    </div>
</div>