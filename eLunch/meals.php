<div class= "col-md-6">
    <?php echo form_open_multipart( 'admin/menus/'); ?>
        <div class="form-group col-md-5 col-sm-5 col-xs-12">
            <label><?php echo $menus_lang['from'] ?></label>
            <?php
                $data = array(
                    'name' => 'from',
                    'class' => 'form-control datepicker',
                    'width' => '30%',
                    'data-date-format' => 'yyyy/mm/dd',);
                echo form_input($data, set_value('from', ''));
            ?>
        </div>
        <div class="form-group col-md-5 col-sm-5 col-xs-12">
            <label><?php echo $menus_lang['to'] ?></label>
            <?php
                $data = array(
                    'name' => 'to',
                    'class' => 'form-control datepicker',
                    'width' => '30%',
                    'data-date-format' => 'yyyy/mm/dd',);
                echo form_input($data, set_value('to', ''));
            ?>
        </div>
        <div class="form-group col-md-2 col-md-2 col-xs-12">
        <label></label>
        <?php echo form_submit( 'submit', $menus_lang['search'], 'class = "btn btn-primary"'); ?>
        </div>
    <?php echo form_close(); ?>
</div>