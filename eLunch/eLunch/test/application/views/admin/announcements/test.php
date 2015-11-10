<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <?php echo form_open('test/index.php/admin/announcements/test'); ?>
        <div class="form-group">
            <label>RegId</label>
            <?php
                $data = array(
                    'name' => 'regid',
                    'class' => 'form-control',
                    'placeholder' => 'RegId');
                echo form_input($data, set_value('subject', ''));
            ?>
        </div>
        <div class="form-group">
            <label>Messages</label>
            <?php
                $data = array(
                  'name' => 'messages',
                  'rows' => '5',
                  'cols' => '10',
                  'class' => 'form-control'
                );
                echo form_textarea($data, set_value('content',''));
            ?>
        </div>
        <div class="form-group text-center">
            <?php echo form_submit( 'submit', 'Send', 'class = "btn btn-primary"'); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>