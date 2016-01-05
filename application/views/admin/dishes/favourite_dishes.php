<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-xs-12">
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h1 class="page-header"><?php echo $favourite_dishes_lang['name']; ?></h1>
        </div>
        <?php
            if ($dishes != NULL)
            {
        ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        foreach ($dishes as $key => $dish)
                        {
                        ?>
                            <div class="col-xs-12 col-sm-4 dish-favourite-item">
                                <?php if ($key < 3){ ?><span class="top-5 badge bg-green"><?php echo ($key + 1) ?></span><?php } ?>
                                <a href="#">
                                    <img class="img-responsive img-thumbnail" width="300" height="300" src="<?php echo $dish->image ?>" alt="">
                                </a>
                                <h3>
                                    <a href="#"><?php echo $dish->name ?></a>
                                </h3>
                                <p>
                                    <strong>
                                        <?php echo $favourite_dishes_lang['votes'] ?>
                                        <a href="#list_users_modal" class="value text-danger" data-toggle="modal" data-target="#list_users_modal" data-path="<?php echo base_url('admin/dishes/get_users_vote_for_dishes'.'/'.$dish->id) ?>" onclick="false;"><?php echo $dish->num_votes ?></a>
                                    </strong>
                                </p>
                                <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $dish->description ?>" data-title="<?php echo $favourite_dishes_lang['title'] ?>" onclick="false;">
                                    <p class="detail-text"><?php echo (strlen($dish->description) > 30) ? substr($dish->description, 0, 30)."..." : $dish->description ?></p>
                                </a>
                            </div>
                            <?php
                                if (($key + 1) % 3 == 0)
                                {
                            ?>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-xs-12'>
                            <?php
                                }
                            }
                            ?>
                    </div>
                </div>
        <?php
            }
        ?>
    </div>
</div>
<div class="modal fade" id="list_users_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $favourite_dishes_lang['users_voted'] ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr class="heading">
                            <th class="column-title"><?php echo $favourite_dishes_lang['avatar'] ?></th>
                            <th class="column-title"><?php echo $favourite_dishes_lang['first_name'] ?></th>
                        </tr>
                    </thead>
                   <tbody class="users">
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
