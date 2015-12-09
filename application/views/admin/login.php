<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/logo_webportal.png'); ?>" />
        <title><?php echo $login_lang['title'] ?></title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo (base_url('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/style.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/fonts/css/font-awesome.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/animate.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/custom.css')); ?>" rel="stylesheet">
        <link href="<?php echo (base_url('assets/css/style.css')); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/toastr.min.css'); ?>" rel="stylesheet"/>
        <script src="<?php echo (base_url('assets/js/jquery.min.js')); ?>"></script>
        <script src="<?php echo (base_url('assets/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo base_url('assets/js/toastr.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
        <script src="<?php echo (base_url('assets/js/bootstrap-datetimepicker.min.js')); ?>"></script>
        <script src="<?php echo (base_url('assets/js/js.js')); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.modernizr.js'); ?>"></script>
    </head>
    <body>
        <div class="se-pre-con"></div>
        <div class="container">
            <div class="row" >
                <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-offset-1 col-xs-10">
                    <div class="layout-center">
                        <div id="logo-container"></div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                                <?php if (NULL != validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                                <?php echo form_open('admin/login/'); ?>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <?php
                                        $data = array(
                                          'name' => 'email',
                                          'class' => 'form-control',
                                          'placeholder' => $login_lang['email']);
                                        echo form_input($data, set_value('email', ''));
                                    ?>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <?php
                                        $data = array(
                                            'name' => 'password',
                                            'class' => 'form-control',
                                            'placeholder' => $login_lang['password']);
                                        echo form_password($data);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $login_lang['select_lang'];?>: </label>
                                    <?php
                                        echo anchor('admin/login/index/english', $login_lang['english'])."&nbsp;|&nbsp;";
                                        echo anchor('admin/login/index/vietnamese', $login_lang['vietnamese']);
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                    <?php echo form_submit('submit', $login_lang['login'], 'class = "btn btn-primary"'); ?>
                                </div>
                                <div class="form-group text-center">
                                    <?php
                                        echo anchor('admin/forgot_password/', $login_lang['forgot_password'], "class='btn-loading'");
                                    ?>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--container-->
    </body>
</html>