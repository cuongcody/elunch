<div class="col-xs-3 col-sm-3 col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?php echo base_url('admin/home'); ?>" class="site_title btn-loading"><i class="fa fa-home"></i> <span><?php echo $sidebar_lang['title'] ?></span></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="<?php echo $avatar_content_file ?>" alt="..." class="img-circle profile_img" width="60" height="50">
                        </div>
                        <div class="profile_info">
                            <span><?php echo $sidebar_lang['welcome'] ?>,</span>
                            <h2><?php echo $first_name.' '.$last_name ?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <?php if ($this->session->userdata('logged_in')['role'] == 1) { ?>
                        <div class="menu_section">
                            <h3><?php echo $sidebar_lang['manage'] ?></h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['users'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/users'); ?>"><?php echo $sidebar_lang['manage_users'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/users/add'); ?>"><?php echo $sidebar_lang['add_user'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['categories'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/categories'); ?>"><?php echo $sidebar_lang['manage_categories'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/categories/add'); ?>"><?php echo $sidebar_lang['add_category'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['menus'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/menus'); ?>"><?php echo $sidebar_lang['manage_menus'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/menus/add'); ?>"><?php echo $sidebar_lang['add_menu'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['dishes'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/dishes'); ?>"><?php echo $sidebar_lang['manage_dishes'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/dishes/add'); ?>"><?php echo $sidebar_lang['add_dish'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/dishes/favourite_dishes'); ?>"><?php echo $sidebar_lang['favourite_dishes'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['meals'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/meals'); ?>"><?php echo $sidebar_lang['manage_meals'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/meals/add'); ?>"><?php echo $sidebar_lang['add_meal'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['tables'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/tables'); ?>"><?php echo $sidebar_lang['manage_tables'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/tables/add'); ?>"><?php echo $sidebar_lang['add_table'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/tables/arrange'); ?>"><?php echo $sidebar_lang['arrange_tables'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['floors'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/floors'); ?>"><?php echo $sidebar_lang['manage_floors'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/floors/add'); ?>"><?php echo $sidebar_lang['add_floor'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['shifts'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/shifts'); ?>"><?php echo $sidebar_lang['manage_shifts'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/shifts/add'); ?>"><?php echo $sidebar_lang['add_shift'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['announcement'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/announcements'); ?>"><?php echo $sidebar_lang['manage_announcement'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/announcements/add'); ?>"><?php echo $sidebar_lang['add_announcement'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['comments'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/comments'); ?>"><?php echo $sidebar_lang['manage_comments'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> <?php echo $sidebar_lang['access_point'] ?> <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url('admin/access_point'); ?>"><?php echo $sidebar_lang['manage_access_point'] ?></a>
                                        </li>
                                        <li><a href="<?php echo base_url('admin/access_point/add'); ?>"><?php echo $sidebar_lang['add_access_point'] ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                       <?php } ?>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>