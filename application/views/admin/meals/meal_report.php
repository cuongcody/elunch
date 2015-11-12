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
    /*        background-size: 380px 90px;*/
            padding-left: 100px;
        }
        .shifts td{
          padding: 5px;
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
        .italic{
          font-style: italic;
          color: #003366;
        }

        table.print-friendly tr td, table.print-friendly tr th {
        page-break-inside: avoid;
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
                            <div>On date: <?php echo $meal_date ?></div>
                            <div>Pre-ordered meals: <?php echo $preordered_meals ?></div>
                            <div>Actual meals: <?php echo $actual_meals ?></div>
                        </strong>
                    </div>
                    <table style='' class='table print-friendly shifts'>
                        <tr style=''>
                            <td style='background-color: #024700; color: #fff;width:180px;'> <strong>Shifts</strong> </td>
                            <td style='background-color: #024700;color: #fff;'> <strong>Tables</strong></td>
                        </tr>
                        <?php
                        if (isset($meal_log))
                        {
                            foreach ($meal_log as $key => $value)
                            {
                                if (isset($value->shift))
                                {
                                    if ($key % 3 == 0) $background = "background-color: #f0e7e7;";
                                    else if($key % 3 == 1) $background = "background-color: #d7e6fa;";
                                    else $background = "background-color: #c1f5ba;";
                                    echo "<tr style='".$background."border:1px'><td style='".$background."width:180px'><div><strong>NAME: </strong> ".$value->shift->name."</div><div><strong>START TIME: </strong>".date('g:i A', strtotime($value->shift->start_time))."</div><div><strong>END TIME: </strong>".date('g:i A', strtotime($value->shift->end_time))."</div> <div><strong>TOTAL TABLES: </strong> ".(isset($value->tables) ? sizeof($value->tables) : 0)."</div></td>";
                                    echo "<td style='".$background."'><table style='margin:-5px;' class='table print-friendly'>";
                                    if (isset($value->tables))
                                    {
                                        foreach ($value->tables as $key2 => $value2)
                                        {
                                            echo "<tr style=''><td style='".$background."width:180px;border-left: 0px;border-top: 0px'><div><strong>NAME:</strong> ".$value2->name."</div><div><strong>ATTENDANCE :</strong> ".$value2->number_users_have_attend."</div><div><strong>TOTAL USERS:</strong> ".(isset($value2->users) ? sizeof($value2->users) : 0)."</div></td>";
                                            echo "<td style='".$background."border:0px'><table style='margin:-1px' class='table print-friendly'>";
                                            if (isset($value2->users))
                                            {
                                                foreach ($value2->users as $key3 => $value3)
                                                {
                                                    echo "<tr style=''><td style='background-color: #f8f9fb;width:200px'><img class='img-thumbnail' width='30' height='30' src='".$value3->avatar_content_file."'> ".($value3->first_name)."</td>";
                                                    echo "<td style='background-color: #f8f9fb;'>";
                                                    if ($value3->status_user == 1) echo "<strong class='green'>ATTEND</strong>";
                                                    elseif ($value3->status_user == 2) echo "<strong class='red'>ABSENT</strong>";
                                                    else echo "<strong class='orange'>LATE</strong>";
                                                    echo "</td></tr>";
                                                }
                                            }
                                            echo "</table></td></tr>";
                                        }
                                    }
                                    echo "</table></td></tr>";
                                }
                            }
                        }
                        ?>
                    </table>
                    <div class='italic'>
                        <?php echo ($note != NULL) ? '*Note: <p>'.$note.'</p>' : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>