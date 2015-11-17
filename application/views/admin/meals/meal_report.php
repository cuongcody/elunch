<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/logo_webportal.png'); ?>" />
    <title><?php echo $title ?></title>

    <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <style type="text/css">
        .header {
            background: url(<?php echo base_url().'/assets/images/logo.png' ?>);
            background-repeat: no-repeat;
            background-position: top left;
            background-size: 380px 90px;
            padding-left: 100px;
        }
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
            background-color: #c1f5ba;
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
    </style>
</head>
<body>
    <div class="container body">
        <div class="main_container">
            <div class='header text-center'>
                <div><strong>TRG – Enclave (a division of TRG International)</strong></div>
                <div>453-455 Hoang Dieu, Hai Chau, Danang, Vietnam</div>
                <div>Tel: +84(5113) 253 000 – Fax: (05113) 253 222</div>
            </div>
            <h1 class='text-center'>Daily Lunch Service Report</h1>
            <div class='row'>
                <div class='col-xs-12'>
                    <div class='text-right italic'>
                        <strong>
                            <div>On date: <?php echo date('d M Y', strtotime($meal_date)); ?></div>
                            <div>Pre-ordered meals: <?php echo $preordered_meals ?></div>
                            <div>Actual meals: <?php echo $actual_meals ?></div>
                        </strong>
                    </div>
                    <div class='table-header'>
                        <div class='col-1-a border-right'>Shift</div>
                        <div class='col-1-b'>Tables</div>
                    </div>
                        <?php
                        if (isset($meal_log))
                        {
                            foreach ($meal_log as $key => $value)
                            {
                                if (isset($value->shift))
                                {
                                    if ($key % 3 == 0) $background = "background-green";
                                    else if($key % 3 == 1) $background = "background-pink";
                                    else $background = "background-blue";
                                    echo "<div class='".$background."'><div class='col-1-a'>";
                                    echo "<div><strong>NAME: </strong>".$value->shift->name."</div>";
                                    echo "<div><strong>START TIME: </strong>".date('g:i A', strtotime($value->shift->start_time))."</div>";
                                    echo "<div><strong>END TIME: </strong>".date('g:i A', strtotime($value->shift->end_time))."</div>";
                                    echo "</div>";
                                    echo "<div class='col-1-b border-left tables'>";
                                    foreach ($value->tables as $key2 => $value2)
                                    {
                                        echo "<div class='border-bottom'><div class='col-2-a'>";
                                        echo "<div><strong>NAME: </strong>".$value2->name."</div>";
                                        echo "<div><strong>ATTENDANCE: </strong>".$value2->number_users_have_attend."</div>";
                                        echo "<div><strong>TOTAL USERS: </strong>".(isset($value2->users) ? sizeof($value2->users) : 0)."</div>";
                                        echo "</div>";
                                        if (isset($value2->users))
                                        {
                                            echo "<div class='col-2-b background-grey margin users'>";
                                            foreach ($value2->users as $key3 => $value3)
                                            {
                                                echo "<div class='border-bottom'><div class='col-3-a'><img class='img-thumbnail' width='30' height='30' src='".$value3->avatar_content_file."'> ".$value3->first_name."</div>";
                                                echo "<div class='col-3-b user'>";
                                                if ($value3->status_user == 1) echo "<strong class='green'>ATTEND</strong>";
                                                elseif ($value3->status_user == 2) echo "<strong class='red'>ABSENT</strong>";
                                                else echo "<strong class='orange'>LATE</strong>";
                                                echo "</div></div>";
                                            }
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                    }
                                    echo "</div></div>";
                                }
                            }
                        }
                        ?>
                    <div class='italic'>
                        <?php echo ($note != NULL) ? '*Note: <p>'.$note.'</p>' : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>