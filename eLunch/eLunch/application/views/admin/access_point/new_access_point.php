<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
                    <?php if (!empty(validation_errors())) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                    <?php echo form_open('admin/access_point/add'); ?>
                    <h2><?php echo $new_access_point_lang['title'] ?></h2>
                    <div class="form-group">
                        <label for="inputaccess_point"><?php echo $new_access_point_lang['ssid'] ?> </label>
                        <?php
                            $data = array(
                            'name' => 'ssid',
                            'class' => 'form-control',
                            'placeholder' => $new_access_point_lang['ssid']);
                            echo form_input($data, set_value('ssid', ''));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="inputbssid"><?php echo $new_access_point_lang['bssid'] ?></label>
                        <?php
                            $data = array(
                              'name' => 'bssid',
                              'class' => 'form-control',
                              'placeholder' => $new_access_point_lang['bssid']);
                            echo form_input($data, set_value('bssid',''));
                        ?>
                    </div>
                    <div class="checkbox">
                        <label>
                        <?php
                            echo form_checkbox( 'selected', 'accept', TRUE);
                            echo $new_access_point_lang[ 'selected']; ?>
                        </label>
                    </div>
                    <div class="form-group text-center">
                        <?php echo form_submit('submit', $new_access_point_lang['save'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->