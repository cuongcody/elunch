<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-xs-12">
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <h1 class="page-header"><?php echo $favourite_dishes_lang['name']; ?></h1>
        </div>
        <?php
            if (!empty($dishes))
            {
                echo "<div class='row'><div class='col-xs-12'>";
                foreach ($dishes as $key => $dish)
                {
                    echo "<div class='col-xs-12 col-sm-4 dish-favourite-item'>";
                    echo ($key < 3) ? "<span class='top-5 badge bg-green'>".($key + 1)."</span>" : "";
                    echo "<a href='#'>";
                    echo "<img class='img-responsive img-thumbnail' width='auto' height='150' src='".$dish->image."' alt=''></a>";
                    echo "<h3>";
                    echo "<a href='#'>".$dish->name."</a>";
                    echo "</h3>";
                    echo "<p><strong>".$favourite_dishes_lang['votes']." <span class='value text-danger'>".$dish->num_votes."</span></strong></p>";
                    echo "<a href='#detail_text_modal' data-toggle='modal' data-target='#detail_text_modal' data-content='{$dish->description}' data-title='{$favourite_dishes_lang['title']}' onclick='false;'><p class='detail-text'>".substr($dish->description,0,100)."...</p></a>";
                    echo "</div>";
                    if (($key+1) % 3 == 0)
                    {
                        echo "</div></div><div class='row'><div class='col-xs-12'>";
                    }
                }
                echo "</div></div>";
            }
        ?>
    </div>
</div>
