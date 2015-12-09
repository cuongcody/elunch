<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/logo_webportal.png'); ?>" />
    <title></title>

    <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <script src="<?php echo (base_url('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo (base_url('assets/js/js.js')); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.modernizr.js'); ?>"></script>
    <style type="text/css">
        .green {
            color: #1ABB9C;
        }
        .orange {
            color: #F39C12;
        }
        .red {
            color: #E74C3C;
        }
        .italic {
          font-style: italic;
          color: #003366;
        }
        .table-header {
            background-color: #024700; color: #fff;
        }
        .border-left {
            border-left: 1px solid #d7d7d7;
        }
        .border-right {
            border-right: 1px solid #d7d7d7;
        }
        .border-bottom {
            border-bottom: 1px solid #d7d7d7;
        }
        .background-green {
            background-color: #f0e7e7;
        }
        .background-pink {
            background-color: #d7e6fa;
        }
        .background-blue {
            background-color: #BBE2F1;
        }
        .background-grey {
            background-color: #f8f9fb;
        }
        .col-3-a {
            width: 164px;
        }
        .col-1-a {
            width: 198px;
        }
        .col-2-a {
            width: 138px;
        }
        .margin {
            margin: 5px;
        }
        .col-3-b:last-child{
            border: 0px;
        }
        .tables, .users {
            padding: 0px;
        }
        .user {
            padding-top: 15px;
        }
        .col-1-a,.col-2-a,.col-2-b, .col-1-b, .col-3-a, .col-3-b {
            float: left;
            position: relative;
            padding: 5px;
        }
        .padding {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container body">
        <div class="main_container">
            <p>Dear Ladies and Gentlemen,</p>
            <p>We'd like to confirm your lunch table information:
            <div class='row'>
                <div class='col-xs-12'>
                    <div class='text-right italic'>
                        <strong>
                            <div>Name: <?php echo $table->name ?></div>
                            <div>Seat: <?php echo $table->seats ?></div>
                        </strong>
                    </div>
                    <h3>NORMAL DAY</h3>
                    <div>
                        <table>
                            <tr class="table-header">
                                <td class="col-1-a">Name</td>
                                <td class="col-1-b">Floor</td>
                            </tr>
                            <?php
                                if (isset($users['normal_day']))
                                {
                                    foreach ($users['normal_day'] as $key => $user)
                                    {
                                        $background = ($key % 2 == 0) ? "background-grey" : "background-blue";
                                ?>
                                <tr class="<?php echo $background ?>">
                                    <td class="col-1-a"><?php echo $user->first_name ?></td>
                                    <td class="col-1-b"><?php echo $user->floor ?></td>
                                </tr>
                                <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
                    <h3>VEGETARIAN DAY</h3>
                    <div>
                        <table>
                            <tr class="table-header">
                                <td class="col-1-a">Name</td>
                                <td class="col-1-b">Floor</td>
                            </tr>
                            <?php
                                if (isset($users['vegan_day']))
                                {
                                    foreach ($users['vegan_day'] as $key => $user)
                                    {
                                        $background = ($key % 2 == 0) ? "background-grey" : "background-blue";
                                ?>
                                <tr class="<?php echo $background ?>">
                                    <td class="col-1-a"><?php echo $user->first_name ?></td>
                                    <td class="col-1-b"><?php echo $user->floor ?></td>
                                </tr>
                                <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
                    <div>
                        The lunch will start at <strong><?php echo $table->start_time ?></strong> and you have lunch in shift: <strong><?php echo $table->shift ?></strong>.We hope you will enjoy your lunch.
                        <p>Best regards, <br>ELunch Service.</p>
                    <div>
                </div>
            </div>
        </div>
    </div>
</body>