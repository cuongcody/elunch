<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $login_lang['title'] ?></title>
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
      <div class="row" >
        <div class="col-md-3 col-sm-2 col-xs-2"></div>
        <div class="col-md-6 col-sm-8 col-xs-8">
          <div class="layout-center">
            <div id="logo-container"></div>
              <div class="panel panel-default">
                <div class="panel-body">
                  <?php if (NULL != validation_errors()) echo "<div class='alert alert-warning'>".validation_errors().'</div>'; ?>
                  <?php echo form_open('admin/login/check_login'); ?>
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
                      echo anchor('admin/login/index/vietnamese', $login_lang['forgot_password']);
                    ?>
                  </div>
                  <?php echo form_close(); ?>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-2 col-xs-2"></div>
      </div>
    </div><!--container-->
  </body>
</html>