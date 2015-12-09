<!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo $avatar_content_file; ?>" alt=""><span><?php echo $first_name." ".$last_name; ?></span>
                                    <span class="fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <?php if ($this->session->userdata('logged_in')['role'] == 0) { ?>
                                    <li><a href="<?php echo base_url('web_portal/select_table/change_users_taste/'. (1 - $this->session->userdata('logged_in')['want_vegan_meal'])) ?>" class="btn-loading"><i class="fa fa-sliders pull-right"></i><?php echo ($this->session->userdata('logged_in')['want_vegan_meal'] == 1) ? $sidebar_lang['dont_want_vegan_food'] : $sidebar_lang['want_vegan_food'] ?></a>
                                    </li>
                                    <?php } ?>
                                    <li><a href="<?php echo base_url('admin/home/logout') ?>" class="btn-loading"><i class="fa fa-sign-out pull-right"></i><?php echo $sidebar_lang['logout'] ?></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->