<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->

    <link href="<?php echo CSS.'bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo CSS.'jquery-ui.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo CSS.'style.css'; ?>" rel="stylesheet">

    <link href="<?php echo FONTS.'css/font-awesome.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo CSS.'animate.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo CSS.'toastr.min.css'; ?>" rel="stylesheet"/>
    <!-- Custom styling plus plugins -->
    <link href="<?php echo CSS.'custom.css'; ?>" rel="stylesheet">
    <link href="<?php echo CSS.'bootstrap-datetimepicker.min.css'; ?>" rel="stylesheet">
    <script src="<?php echo JS.'jquery.min.js'; ?>"></script>
    <script src="<?php echo JS.'jquery-ui.min.js'; ?>"></script>
    <script src="<?php echo JS.'bootstrap.min.js'; ?>"></script>
    <script src="<?php echo JS.'custom.js'; ?>"></script>
    <script src="<?php echo JS.'nprogress.js'; ?>"></script>
    <script src="<?php echo JS.'toastr.min.js'; ?>"></script>
    <script src="<?php echo JS.'moment.js'; ?>"></script>
    <script src="<?php echo JS.'bootstrap-datetimepicker.min.js'; ?>"></script>
    <script src="<?php echo JS.'js.js'; ?>"></script>
    <script src="<?php echo JS.'jquery.newsTicker.js'; ?>"></script>
    <?php
        $this->load->library('common');
        if ($this->common->is_url_exist((JS.($this->router->fetch_class()).'.js')))
        {
            echo "<script src='".JS.($this->router->fetch_class()).'.js'."'></script>";
        }
    ?>
    <script type="text/javascript">
        NProgress.start();
    </script>

</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">