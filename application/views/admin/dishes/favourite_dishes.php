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
                                        <span class="value text-danger"><?php echo $dish->num_votes ?></span>
                                    </strong>
                                </p>
                                <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $dish->description ?>" data-title="<?php echo $favourite_dishes_lang['title'] ?>" onclick="false;">
                                    <p class="detail-text"><?php echo (strlen($dish->description) > 30) ? substr($dish->description, 0, 30)."..." : $dish->description ?></p>
                                </a>
                            </div>
                            <?php
                                if (($key+1) % 3 == 0)
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
