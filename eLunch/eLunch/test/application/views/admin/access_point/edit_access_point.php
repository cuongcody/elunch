<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <h2><?php echo $edit_access_point_lang['title'] ?></h2>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/access_point/edit/'.$access_point_item->id); ?>
                        <div class="form-group">
                            <label for="inputaccess_point"><?php echo $edit_access_point_lang['ssid'] ?> </label>
                            <?php
                                $data = array(
                                  'name' => 'ssid',
                                  'class' => 'form-control',
                                  'placeholder' => $edit_access_point_lang['ssid']);
                                echo form_input($data, set_value('ssid', $access_point_item->ssid));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="inputBssid"><?php echo $edit_access_point_lang['bssid'] ?></label>
                            <?php
                                $data = array(
                                  'name' => 'bssid',
                                  'class' => 'form-control',
                                  'placeholder' => $edit_access_point_lang['bssid']);
                                echo form_input($data, set_value('bssid', $access_point_item->bssid));
                            ?>
                        </div>
                        <div class="checkbox">
                                <label>
                                <?php
                                    echo ($access_point_item->selected == 1) ? form_checkbox( 'selected', 'accept', TRUE) : form_checkbox( 'selected', TRUE);
                                    echo $edit_access_point_lang[ 'selected']; ?>
                                </label>
                            </div>
                        <div class="form-group text-center">
                            <?php echo form_submit('submit', $edit_access_point_lang['edit'], 'class = "btn btn-primary"'); ?>
                            <a href="<?php echo base_url('admin/access_point'); ?>" class='btn btn-info'><?php echo $edit_access_point_lang['manage_access_point'] ?></a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->