<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?php echo $register_lang[ 'title'] ?>
        </title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo (base_url('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/style.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/fonts/css/font-awesome.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/animate.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/custom.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/style.css')); ?>" rel="stylesheet">
        <script src="<?php echo (base_url('assets/js/jquery.min.js')); ?>"></script>
        <script src="<?php echo (base_url('assets/js/bootstrap.min.js')); ?>"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-2 col-xs-2"></div>
                <div class="col-md-6 col-sm-8 col-xs-8">
                    <div class="layout-center">
                        <div id="logo-container"></div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                                <?php echo form_open_multipart( 'admin/register/validation'); ?>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <?php $data=array(
                                        'name'=> 'first_name',
                                        'class' => 'form-control',
                                        'placeholder' => $register_lang['first_name']);
                                        echo form_input($data, set_value('first_name', '')); ?>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <?php $data=array(
                                        'name'=> 'last_name',
                                        'class' => 'form-control',
                                        'placeholder' => $register_lang['last_name']);
                                        echo form_input($data, set_value('last_name', '')); ?>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <?php $data=array(
                                        'name'=> 'email',
                                        'class' => 'form-control',
                                        'placeholder' => $register_lang['email']);
                                        echo form_input($data, set_value('email', '')); ?>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <?php $data=array(
                                        'name'=> 'password',
                                        'class' => 'form-control',
                                        'placeholder' => $register_lang['password']);
                                        echo form_password($data); ?>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <?php $data=array(
                                        'name'=> 'confirm_password',
                                        'class' => 'form-control',
                                        'placeholder' => $register_lang['confirm_password']);
                                        echo form_password($data); ?>
                                </div>
                                <div class="checkbox">
                                    <label>
                                    <?php
                                        echo form_checkbox( 'want_vegan_meal', 'accept', TRUE);
                                        echo $register_lang[ 'want_vegan_meal']; ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="comment"><?php echo $register_lang[ 'what_taste']; ?></label>
                                    <?php $data=array(
                                        'name'=> 'what_taste',
                                        'id' => 'txt_area',
                                        'rows' => '5', 'cols' => '10',
                                        'style' => 'width:80%',
                                        'class' => 'form-control' );
                                        echo form_textarea($data, set_value('what_taste','')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $register_lang[ 'avatar'] ?></label>
                                    <div>
                                        <img id='img' class="img-thumbnail" height="200" width="200" src="<?php echo (!isset($upload)) ? base_url('assets/images/users/default-avatar.png') : base_url('assets/images/users/'.$upload['file_name']); ?>" alt="">
                                    </div>
                                    <?php $data=array( 'name'=> 'img', 'type' => 'file', 'onchange'=>'readURL(this)' ); echo form_input($data); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $register_lang[ 'floor'];?>: </label>
                                    <?php $options=array();
                                    foreach ($floors as $temp)
                                      { $options[$temp->id] = $temp->name; }
                                    $select_floor = $this->input->post('floor');
                                    echo form_dropdown('floor', $options, set_value('floor',( !empty($select_floor) ) ? "$select_floor" : $floors[0]->id),'class= "form-group"'); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $register_lang[ 'role'];?>: </label>
                                    <?php $options=array(
                                    '0'=> $register_lang['user'],
                                    '1' => $register_lang['admin']);
                                    $select_role = $this->input->post('role');
                                    echo form_dropdown('role', $options, set_value('role',( !empty($select_role) ) ? "$select_role" : 0),'class= "form-group"'); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $register_lang[ 'select_lang'];?>: </label>
                                    <?php echo anchor( 'admin/register/index/english', $register_lang[ 'english']). "&nbsp;|&nbsp;"; echo anchor( 'admin/register/index/vietnamese', $register_lang[ 'vietnamese']); ?>
                                </div>
                                <div class="form-group text-center">
                                    <?php echo form_submit( 'submit', $register_lang[ 'register'], 'class = "btn btn-primary"'); ?>
                                </div>
                                <div class="form-group text-center">
                                    <a href="<?php echo base_url('admin/login') ?>">
                                        <?php echo $register_lang[ 'login_page'] ?>
                                    </a>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-2"></div>
            </div>
            <!--row-->
        </div>
    </body>
</html>