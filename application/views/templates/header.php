<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="public">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/logo_webportal.png'); ?>" />
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/moonMap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/fonts/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animate.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/toastr.min.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/jquery.webui-popover.min.css'); ?>" rel="stylesheet"/>
    <!-- Custom styling plus plugins -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/nprogress.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/toastr.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/moonMap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/js.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.newsTicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.modernizr.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.webui-popover.min.js'); ?>"></script>
    <?php
        $this->load->library('common');
        if ($this->common->is_url_exist((base_url('assets/js').'/'.($this->router->fetch_class()).'.js')))
        {
            echo "<script src='".(base_url('assets/js').'/'.($this->router->fetch_class()).'.js')."'></script>";
        }
    ?>
    <script type="text/javascript">
        NProgress.start();
    </script>

</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="se-pre-con"></div>